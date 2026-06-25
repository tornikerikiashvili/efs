<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    
   
   
    public function index()
    {
        $sliders = Slider::all();
       
        return view('argon.pages.homepage')->with(compact('sliders'));
    }

    public function update_sliders(Request $request){

        $validator = Validator::make($request->all(), [
            'sliderId' => 'required|exists:slider,id',
            'status' => 'required|numeric',
            'sort' => 'numeric|nullable'
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => $validator->errors()->first()
             ];
        }
        
        $updated = Slider::find($request->sliderId)
        ->update([
            "status" => $request->status ?? 1,
            "sort" => $request->sort ?? null,
        ]);

        return $updated ? ['status'=>true] : ['status' => false]; 

   

        //print_r($request->all());exit;
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
       
        $validator = Validator::make($request->all(), [
            'mainsliderimage_ka' => 'required',
            'mainsliderimage_en' => 'required',
            "mainsliderimage_ka" => 'image|mimes:'.cms_image_mimes(),
            "mainsliderimage_en" => 'image|mimes:'.cms_image_mimes(),
        ]);

        if ($validator->fails()) {
            
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
       
        

        
        if(
            ($request->hasFile('mainsliderimage_ka') && $request->file('mainsliderimage_ka')->isValid()) &&
            ($request->hasFile('mainsliderimage_en') && $request->file('mainsliderimage_en')->isValid())
        ){
            
            $created = Slider::create([
                "status" => $request->status ?? 1,
                "sort" => $request->sorting ?? null,
            ]);
            if($created){
                $created
                ->addMedia($request->mainsliderimage_ka)
                ->toMediaCollection('mainslider_ka');

                $created
                ->addMedia($request->mainsliderimage_en)
                ->toMediaCollection('mainslider_en');

                
            }
            
        }else{
            return redirect()->back()->withErrors(['Please Upload Images for Both Languages']);
        }
            
        if(
            ($request->hasFile('mainmobilesliderimage_ka') && $request->file('mainmobilesliderimage_ka')->isValid()) &&
            ($request->hasFile('mainmobilesliderimage_en') && $request->file('mainmobilesliderimage_en')->isValid())
        ){
            
            
            if($created){
                $created
                ->addMedia($request->mainmobilesliderimage_ka)
                ->toMediaCollection('mainmobileslider_ka');

                $created
                ->addMedia($request->mainmobilesliderimage_en)
                ->toMediaCollection('mainmobileslider_en');

            }
            
        }

        return redirect()->back()->withSuccess('Uploaded');

    }

    public function front_index()
    {

        $services = Services::where('status', 1)->get();
        $mainsliders = Slider::where('status',1)->orderBy('sort')->get();
        return view('homepage')->with(compact('services','mainsliders'));

    }

    public function destroy($id)
    {
        $deleted = Slider::find($id)->delete();
        if($deleted) return ['status'=>true];
    }

}
