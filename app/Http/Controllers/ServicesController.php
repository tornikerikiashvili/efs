<?php

namespace App\Http\Controllers;

use App\Mail\FormLead;
use App\Models\Services;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
   

    public function front_index()
    {
        // Mail::to('iloilo603@gmail.com')->send(new FormLead()); //Works Mail
        // exit;

        $locale = app()->getLocale();
       
        $services = Services::select('id','name_'.$locale,'content_'.$locale,'image')->where('status',1)->get();
        $services = Services::where('status',1)->get();

        foreach ($services as $key => $value) {//დროებით
            if(!$value['slug']){ //if not save new slug
                Services::find($value['id'])->update([
                    'slug' => Str::slug($value['name_ka'])
                ]);
            }
        }
        
        return view('services')->with(compact('services'));

    }


    public function front_show($slug,$id)
    {
        $service = Services::where('status',1)->findOrFail($id);
        $services = Services::where('status',1)->get();
        
        return view('single-service')->with(compact('services','service'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Services::all();
        
        return view('argon.pages.services.index')->with(compact('services'));
       
        
    }

   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('argon.pages.services.crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'required',
            "image" => 'required|image|mimes:jpeg,jpg,png,gif',
            
        ]);

        $slug = Str::slug($request->name_ka);
       
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

       
        $created = Services::create([
            "name_ka" => $request->name_ka,
            "name_en" => $request->name_en,
            "slug" => $slug,
            "status" => $request->status ?? 1,
            "meta_title_ka" => $request->meta_title_ka ?? null,
            "meta_title_en" => $request->meta_title_en ?? null,
            "meta_description_ka" => $request->meta_description_ka ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            "icon" => '',
            'services-trixFields' => $request['services-trixFields']
        ]);

        if($created){
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $created
                ->addMedia($request->image)
                ->toMediaCollection('main');
            }
            if($request->hasFile('icon') && $request->file('icon')->isValid()){
                $created
                ->addMedia($request->icon)
                ->toMediaCollection('icon');
            }
            return redirect()->route('services.index')->withSuccess('Updated');
        } 
        
        return redirect()->back()->withErrors(['error create']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Services $services)
    {
        //print_r($id);exit;
        $service = $services->find($id);
        $mediaItems = $service->getMedia('main');
        $iconmediaItems = $service->getMedia('icon');
       
        

        return view('argon.pages.services.crud')->with(compact('service','mediaItems','iconmediaItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, Services $services)
    {
        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'mimes:jpeg,jpg,png,gif'
        ]);

       

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        
        $updated = $services->find($id)->update(
            [
                "name_ka" => $request->name_ka,
                "name_en" => $request->name_en,
                "status" => $request->status,
                "meta_title_ka" => $request->meta_title_ka ?? null,
                "meta_title_en" => $request->meta_title_en ?? null,
                "meta_description_ka" => $request->meta_description_ka ?? null,
                "content_ka" => $request->content_ka ?? '',
                "content_en" => $request->content_en ?? '',
                'services-trixFields' => $request['services-trixFields']
            ]
        );

        if($updated){
            if($request->hasFile('image') && $request->file('image')->isValid()){
                
                $service = $services->find($id);
                $mediaItems = $service->getMedia('main');
                if(isset($mediaItems[0])) $mediaItems[0]->delete();
               

                $service
                ->addMedia($request->image)
                ->toMediaCollection('main');
            }

            if($request->hasFile('icon') && $request->file('icon')->isValid()){
                
                $service = $services->find($id);
                $iconmediaItems = $service->getMedia('icon');
                if(isset($iconmediaItems[0])) $iconmediaItems[0]->delete();
               
                
                $service
                ->addMedia($request->icon)
                ->toMediaCollection('icon');
            }
            return redirect()->back()->withSuccess('IT WORKS!');
        } 
        
        return redirect()->back()->withErrors(['error update']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }
}
