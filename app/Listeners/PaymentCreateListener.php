<?php

namespace App\Listeners;

use App\Events\PaymentCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Payment;

class PaymentCreateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PaymentCreate $event)
    {
        //
        if ($payment=Payment::where('tracking_id', $event->payment->order_tracking_id)->first()){
            $payment->update([
                'first_name'=>$event->user->name,
                'last_name'=>$event->user->last_name,
                'email'=>$event->user->email,
                'amount'=>$event->postData['amount'],
                'currency'=>$event->postData['currency'],
                'reference'=>$event->postData['id'],
                'description'=>$event->postData['description'],
                'tracking_id'=>$event->payment->order_tracking_id,
                'account_id'=>$event->account->id,
                'user_id'=>$event->user->id
            ]);
        }else{
            $payment=Payment::firstOrCreate([
                'first_name'=>$event->user->name,
                'last_name'=>$event->user->last_name,
                'email'=>$event->user->email,
                'amount'=>$event->postData['amount'],
                'currency'=>$event->postData['currency'],
                'reference'=>$event->postData['id'],
                'description'=>$event->postData['description'],
                'tracking_id'=>$event->payment->order_tracking_id,
                'account_id'=>$event->account->id,
                'user_id'=>$event->user->id
            ]);
        }
    }
}
