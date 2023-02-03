<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $adverts=Advertisement::query()
            ->when(request('search'), function ($query, $search){
                $query->where('title','like', '%'.$search.'%');
            })
            ->when(request('status'), function ($query, $status){
                $query->where('status',$status);
            })
            ->when(request('start'), function ($query, $start){
                $query->where('start','>=',$start);
            })
            ->when(request('end'), function ($query, $end){
                $query->where('expiry','<=',$end);
            })
        ->paginate(20);
        $adverts=AdvertisementResource::collection($adverts);

        //remember to attach filters
        $filters=request()->only(['search','start','end','status']);
        return inertia::render('admin.advertisement.index', compact('adverts','filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return inertia::render('admin.advertisement.create');
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
       $validated=$request->validate([
           'title'=>'required|string|max:100',
           'description'=>'required|string|max:500',
           'expiry'=>'required|date',
           'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=600,height=400',
           'url'=>'required|string|max:355',
           'start'=>'required|date',
           'remarks'=>'nullable|max:1000',
           'price'=>'nullable'
       ]);


       if (Carbon::parse($validated['start'])->isToday()){
           $status=1;
       }else{
           $status=2;
       }

       $advert=Advertisement::create([
            'title'=>$validated['title'],
            'description'=>$validated['description'],
            'expiry'=>$validated['expiry'],
            'status'=>$status,
            'url'=>$validated['url'],
            'remarks'=>$validated['remarks'],
            'start'=>$validated['start'],
            'price'=>$validated['price']
        ]);

        if($image=$request->file('image')) {
            $advert->addMedia($image)->toMediaCollection('image');

        }

        return redirect()->route('advertisement.index')
            ->with('status','Advertisement successfully created');
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
        $advert=new AdvertisementResource(Advertisement::findOrFail($id));
        return inertia::render('admin.advertisement.show', compact('advert'));
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
        $advert=new AdvertisementResource(Advertisement::findOrFail($id));
        return inertia::render('admin.advertisement.edit', compact('advert'));
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
        $validated=$request->validate([
            'title'=>'required|string|max:100',
            'description'=>'required|string|max:500',
            'expiry'=>'required|date',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=600,height=400',
            'url'=>'required|string|max:355',
            'start'=>'required|date',
            'remarks'=>'nullable|max:1000',
            'price'=>'nullable'
        ]);
        if (Carbon::parse($validated['start'])->isToday()){
            $status=1;
        }else{
            $status=2;
        }
        $advert=Advertisement::findOrFail($id);
        $advert->update([
            'title'=>$validated['title'],
            'description'=>$validated['description'],
            'expiry'=>$validated['expiry'],
            'status'=>$status,
            'url'=>$validated['url'],
            'remarks'=>$validated['remarks'],
            'start'=>$validated['start'],
            'price'=>$validated['price']
        ]);

        if($files=$request->file('image')) {
            if ($advert->getMedia('image')->count()>0){
                $advert->clearMediaCollection('image');
                $advert->addMedia($files)->toMediaCollection('image');
            }else{
                $advert->addMedia($files)->toMediaCollection('image');
            }

        }

        return redirect()->route('advertisement.index')
            ->with('status','Advert Successfully updated');

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
        $advert=Advertisement::findOrFail($id);
        $advert->delete();
        return redirect()->back()
            ->with('status',' Advert successfully deleted');
    }
}
