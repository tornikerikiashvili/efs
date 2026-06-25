<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$abouts = About::selecet('page_id')->distinct()->get();
        $abouts = [
            [
                'id' => '1',
                'name' => 'Main About'
            ],
            [
                'id' => '2',
                'name' => 'Section Abouts'
            ]
        ];
        return view('argon.pages.about.index')->with(compact('abouts'));
    }



    public function front_index()
    {
        $about = About::where('page_id',1)->get();
        
        return view('about')->with(compact('about'));
    }

    public function front_index2()
    {
        $about = About::where('page_id',2)->get();
        
        return view('sub-about')->with(compact('about'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('argon.pages.about.crud');
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
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit($about)//ID
    {
        $data = About::where('page_id',$about)->get();

        return view('argon.pages.about.crud')->with(compact('data','about'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        //print_r($request->all());exit;

        foreach ($request['rows'] as $row) {
            //print_r($row['id']);exit;
            About::find($row['id'])->update([
                'text_ka' => $row['text_ka'],
                'text_en' => $row['text_en']
            ]);
        }

        
        if ($request->hasFile('about_image') && $request->file('about_image')->isValid()) {
            $request->validate([
                'about_image' => 'image|mimes:'.cms_image_mimes(),
            ]);

            $staticModel = About::where('page_id', 1)->find(1);

            $staticModel->addMedia($request->about_image)
            ->toMediaCollection('about_image');
        }
        

        return redirect()->back()->withSuccess('Updated');
      


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
    }
}
