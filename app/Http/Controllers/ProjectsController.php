<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    private $projectsArr = [
        0 => [
            'title' => "McDonald's Agmashenebeli",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat5'
            ],
            'images' => [
                'mcdonald.jpg?1'
            ]
        ],
        1 => [
            'title' => "Archi",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat2'
            ],
            'images' => [
                'archi.jpg'
            ]
        ],
        2 => [
            'title' => "Dunkin",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat2',
                'cat5'
            ],
            'images' => [
                'dunkin.jpg?1'
            ]
        ],
        3 => [
            'title' => "Domino",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat2'
            ],
            'images' => [
                'domino.png?1'
            ]
        ],
        4 => [
            'title' => "Element Construction",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat2',
                'cat5'
            ],
            'images' => [
                'ec.jpg'
            ]
        ],
        5 => [
            'title' => "LTB",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1'
            ],
            'images' => [
                'ltb.jpg'
            ]
        ],
        6 => [
            'title' => "Mtkvari HPP",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat2'
            ],
            'images' => [
                'mtkvari-hesi.jpg'
            ]
        ],
        7 => [
            'title' => "Noste",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1',
                'cat2'
            ],
            'images' => [
                'noste.jpg'
            ]
        ],
        8 => [
            'title' => "Sulkhan-Saba Orbeliani University",
            'description' => '',
            'icon' => '',
            'content' => '',
            'tag' => [
                'cat1'
            ],
            'images' => [
                'sabauni.jpg?1'
            ]
        ],

    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function front_index()
    {
        $locale = app()->getLocale();
       
        $projects = Projects::select('id','name_'.$locale,'image')->where('status',1)->with('media')->get();
      
        //$projects = $this->projectsArr;
        return view('projects')->with(compact('projects'));
    }


    public function index()
    {
       
        $projects = Projects::all();
        //$projects = $this->projectsArr;
        return view('argon.pages.projects.index')->with(compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('argon.pages.projects.crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'required',
            "image" => 'image|mimes:jpeg,jpg,png,gif',
            "icon" => 'image|mimes:jpeg,jpg,png,gif',
            
        ]);

        $slug = Str::slug($request->name_ka);
       
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

       
        $created = Projects::create([
            "name_ka" => $request->name_ka,
            "name_en" => $request->name_en,
            "slug" => $slug,
            "status" => $request->status ?? 1,
            "meta_title_ka" => $request->meta_title_ka ?? null,
            "meta_title_en" => $request->meta_title_en ?? null,
            "meta_description_ka" => $request->meta_description_ka ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            'projects-trixFields' => $request['projects-trixFields']
        ]);

        
        
        if($created){
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $created
                ->addMedia($request->image)
                ->toMediaCollection('main');
            }
            return redirect()->back()->withSuccess('IT WORKS!');
        } 
        
        return redirect()->back()->withErrors(['error create']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Projects $projects)
    {
        
        //print_r($id);exit;
        $project = $projects->find($id);
        $mediaItems = $project->getMedia('main');
        
        return view('argon.pages.projects.crud')->with(compact('project','mediaItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, Projects $projects)
    {
       
        $projects->find($id)->update([
            'projects-trixFields' => $request['projects-trixFields'],
        ]);

        
        
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

        
        $updated = $projects->find($id)->update(
            [
                "name_ka" => $request->name_ka,
                "name_en" => $request->name_en,
                "status" => $request->status,
                "meta_title_ka" => $request->meta_title_ka ?? null,
                "meta_title_en" => $request->meta_title_en ?? null,
                "meta_description_ka" => $request->meta_description_ka ?? null,
                "content_ka" => $request->content_ka ?? '',
                "content_en" => $request->content_en ?? '',
                'projects-trixFields' => $request['projects-trixFields']
            ]
        );


        

        if($updated){
            if($request->hasFile('image') && $request->file('image')->isValid()){
                
                $project = $projects->find($id);
                $mediaItems = $project->getMedia('main');
                if(isset($mediaItems[0])) $mediaItems[0]->delete();
               
                
                $project
                ->addMedia($request->image)
                ->toMediaCollection('main');
                
            }
            return redirect()->back()->withSuccess('IT WORKS!');
        } 
        
        return redirect()->back()->withErrors(['error update']);
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projects $projects)
    {
        return ['ddddd'];
    }
}
