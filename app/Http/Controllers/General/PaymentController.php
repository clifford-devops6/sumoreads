<?php

namespace App\Http\Controllers\General;

use App\Events\PaymentCreate;
use App\Http\Controllers\Controller;
use App\Mail\PaymentReciept;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Nyawach\LaravelPesapal\Facades\LaravelPesapal;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth::user();
        $account=$user->account()->first();
        $type=$account->type()->first();
        $balance=$account->balances()->where('status','Pending')->first();
        if (!$balance){
            return  redirect()->route('news.index');
        }
        $amount=$balance->amount;
        $payment_id=$balance->balance_id;
        $postData = array();
        $postData["language"] = "EN";
        $postData["currency"] = 'KES';
        $postData["amount"] =number_format(1,2);
        $postData["id"] =$payment_id;
        $postData["description"] ='Sumo Reads Payment';
        $postData["billing_address"]["phone_number"] ="";
        $postData["billing_address"]["email_address"] =$user->email;
        $postData["billing_address"]["country_code"] = "KE";
        $postData["billing_address"]["first_name"] = $user->name;
        $postData["billing_address"]["middle_name"] ="";
        $postData["billing_address"]["last_name"] = $user->last_name;
        $postData["billing_address"]["line_1"] = "";
        $postData["billing_address"]["line_2"] = "";
        $postData["billing_address"]["city"] = "";
        $postData["billing_address"]["state"] = "KE";
        $postData["billing_address"]["postal_code"] = "";
        $postData["billing_address"]["zip_code"] = "";
        $postData["callback_url"] =route('callback',config('pesapal.pesapal_guard'));
        $postData["notification_id"] =config('pesapal.pesapal_ipn_id');
        $postData["terms_and_conditions_id"] = "";

        //Submit order request
        $order=LaravelPesapal::getMerchantOrderURL($postData);
        if($order->error==null){
            $payment=$order;
            PaymentCreate::dispatch($postData,$user, $account,$payment);
        }

        return inertia::render('payments.index',compact( 'type','payment','balance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //process payments from pesapal
    public function callback(Request $request){
        $tracking_id=$request->OrderTrackingId;
        if (!$tracking_id){
            return redirect()->route('payments.index')
                ->with('status','The payment process failed. Please try again');
        }
        $status=LaravelPesapal::getTransactionStatus($request->OrderTrackingId);
        if ($status){
            if ($status->status_code==1){
                //update order status to complete
                $payment=Payment::where('tracking_id', $tracking_id)->first();
                $user=Auth::user();
                $account=$user->account()->first();


                $payment->update([
                    'status'=>$status->status_code,
                    'payment_method'=>$status->payment_method,
                ]);

                $balance=Balance::where('balance_id',$payment->reference)->firstOrFail();

                $balance->update([
                    'payment_id'=>$payment->id,
                    'status'=>'Paid'
                ]);

                if ($balance->balance_type=='Full'){
                    $token=Token::create([
                        'account_id'=>$balance->account_id,
                        'payment_id'=>$payment->id,
                        'expiry'=>$balance->expires,
                        'balance_id'=>$balance->id,
                        'token'=>Str::random(60),
                        'slots'=>$balance->slots
                    ]);
                }elseif($balance->balance_type=='Additional'){
                    $token=$account->tokens()->latest()->first();
                    $token->update([
                        'slots'=>$token->slots+$balance->slots
                    ]);
                }

                if ($balance->balance_type=='Conversion-Enterprise'){
                    $user->syncPermissions([]);
                    $user->syncRoles([]);
                    $user->givePermissionTo('enterprise-account');
                    $user->assignRole('Enterprise');
                    $account->update([
                        'type_id'=>2
                    ]);

                    $token=Token::create([
                        'account_id'=>$balance->account_id,
                        'payment_id'=>$payment->id,
                        'expiry'=>$balance->expires,
                        'balance_id'=>$balance->id,
                        'token'=>Str::random(60),
                        'slots'=>$balance->slots
                    ]);
                }elseif ($balance->balance_type=='Conversion-Standard'){
                    $user->syncPermissions([]);
                    $user->syncRoles([]);
                    $user->givePermissionTo('standard-account');
                    $user->assignRole('Standard');
                    $account->update([
                        'type_id'=>2
                    ]);
                    $token=Token::create([
                        'account_id'=>$balance->account_id,
                        'payment_id'=>$payment->id,
                        'expiry'=>$balance->expires,
                        'balance_id'=>$balance->id,
                        'token'=>Str::random(60),
                        'slots'=>$balance->slots
                    ]);
                }

                Mail::to($user->email)->send(new PaymentReciept($user,$account,$payment));
                return redirect()->route('news.index')
                    ->with('status', 'Payment Successful. Thank you');

            }else{
                return redirect()->route('payments.index')
                    ->with('status','Payment Unsuccessful. Payment status'.$status->payment_status_description);
            }
        }else{
            return redirect()->route('payments.index')
                ->with('status', 'Payment status could not be verified');
        }
    }
}
