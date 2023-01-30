<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SourceResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\Source;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use function Termwind\render;

class AdminSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sources=SourceResource::collection(Source::query()->when(request('search'),function ($query,$search){
            $query->where('name','like', '%'.$search.'%');
        })->with('country','category')->paginate(10));
        $filters=request()->only(['search']);


        return  inertia::render('admin.sources.index', compact('sources','filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $statuses=Status::select('name','id')->get();
        $categories=Category::select('id','name')->get();
        $countries=Country::select('name','id')->get();
        return inertia::render('admin.sources.create', compact('statuses','categories','countries'));
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
       // dd($request->all());
        $validated=$request->validate([
            'name'=>'required|string|max:50|unique:sources',
            'status_id'=>'required',
            'category_id'=>'required',
            'country_id'=>'required|integer',
            'domain'=>'required|string|max:100',
            'logo'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $source=Source::create([
            'name'=>$validated['name'],
            'status_id'=>$validated['status_id'],
            'country_id'=>$validated['country_id'],
            'domain'=>$validated['domain'],
            'category_id'=>$validated['category_id']
        ]);

        if($logo=$request->file('logo')) {
            $source->addMedia($logo)->toMediaCollection('logo');

        }
        return  redirect('admin/sources')
            ->with('status', 'Source Successfully Added');
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
        $source=Source::select('name','id','domain','country_id','category_id','status_id')->findOrFail($id);

        $statuses=Status::select('name','id')->get();
        $categories=Category::select('id','name')->get();
        $countries=Country::select('name','id')->get();
        return inertia::render('admin.sources.edit', compact('statuses','categories','countries','source'));
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
            'name'=>'required|string|max:50',
            'status_id'=>'required',
            'category_id'=>'required',
            'country_id'=>'required|integer',
            'domain'=>'required|string|max:100',
            'logo'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $source=Source::findOrFail($id);
        $source->update($validated);
        if($files=$request->file('logo')) {
            if ($source->getMedia('logo')->count()>0){
                $source->clearMediaCollection('logo');
                $source->addMedia($files)->toMediaCollection('logo');
            }else{
                $source->addMedia($files)->toMediaCollection('logo');
            }

        }
        return  redirect('admin/sources')
            ->with('status', 'Source Successfully Updated');
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
        $source=Source::findOrFail($id);
        $source->delete();
        return redirect()->route('sources.index')
            ->with('status','Source Successfully deleted');
    }

    public function attemptFetch($id){

        $source=Source::findOrFail($id);
        $domain=$source->domain;
        $date=Carbon::today()->toDateString();
        $response=Http::get('https://newsapi.org/v2/everything?domains='.$domain.'&from='.$date.'&language='.config('news.language').'&apiKey='.config('news.key'));
        $news=json_decode($response);

        if ($news->articles){
            $source->update(['pulls'=>2]);
            return redirect()->back()
                ->with('status','The news source is successfully fetching articles');
        }else{
            $source->update(['pulls'=>0]);
            return redirect()->back()
                ->with('status', 'Failed to pull. Please check the source domain and try again');
        }



    }
}
