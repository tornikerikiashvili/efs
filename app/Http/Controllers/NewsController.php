<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    private $kaNewsArr = [
        '1' => [
            'title' => 'ტრენინგი - დაგეგმილი  სამუშაოების მართვა',
            'description' => 'დაგეგმილი სამუშაოების მართვა - აღნიშნულ თემას დაეთმო 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬-ის   ორგანიზებული ტრენინგი.',
            'content' => ',,ეს არის ყველაზე თანამედროვე მექანიზმი, რომელიც უზრუნველყოფს პერსონალის რესურსის სწორად გადანაწილებას, <br> რისკების შეფასებასა და სამუშაო პროცესების კონტროლს“, - განაცხადა EFS-ის პროფესიული ჯანდაცვის, შრომის უსაფრთხოების და გარემოს დაცვის დეპარტამენტის უფროსმა კახა ჭყონიამ. <br>
                <b>𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬</b> სამომავლოდაც განაგრძობს ექსპერტული გამოცდილების გაზიარებას და დაინტერესებულ პირებს საინფორმაციო ტრენინგებით უზრუნველყოფს.
                ',
            'date' => '2022-09-24',
            'images' => [
                '1-1.jpg',
                '1-2.jpg',
                '1-3.jpg',
                '1-4.jpg',
                '1-5.jpg',
            ]
        ],
        '2' => [
            'title' => 'IOSH-ის სერტიფიკატი EFS-ს',
            'description' => '𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬-ს ყველაზე გავლენიანი საერთაშორისო ორგანიზაციის IOSH-ის სერტიფიკატი გადაეცა. ',
            'content' => 'კომპანიის ლონდონში მდებარე სათავო ოფისიდან შესაბამისი აღიარება 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬-ის პროფესიული ჯანდაცვის, შრომის უსაფრთხოების და გარემოს დაცვის დეპარტამენტის უფროსმა კახა ჭყონიამ მიიღო. <br>
            პროგრამის Train the Trainer ფარგლებში მან წარმატებით დაფარა 6 მოდული. 
            აღსანიშნავია, 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬-ის  სამომავლო გეგმები:  IOSH-ის CPD-ში მონაწილეობით,  ქართული კომპანია IOSH-ის ტექნიკური წევრი გახდება. შესაბამისად,  𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬-ი ბიზნეს სექტორში საერთაშორისო სტანდარტების დანერგვას გაძლიერებული რესურსებით განაგრძობს.
            ',
            'date' => '2022-09-22',
            'images' => [
                '2.jpg'
                ]
        ]
    ];

    private $enNewsArr = [
        '1' => [
            'title' => 'Training - management of work',
            'description' => 'Management of planned works - organized training of 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬 was dedicated to the mentioned topic. ',
            'content' => '"This is the most modern mechanism that ensures proper allocation of personnel resources, risk assessment and control of work processes," said Kakha Chkhonia, head of the Occupational Health, Labor Safety and Environmental Protection Department of EFS.
            𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬 will continue to share expert experience in the future.
            ',
            'date' => '2022-09-24',
            'images' => [
                '1-1.jpg',
                '1-2.jpg',
                '1-3.jpg',
                '1-4.jpg',
                '1-5.jpg',
            ]
        ],
        '2' => [
            'title' => 'IOSH certificate to EFS',
            'description' => '𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬 was awarded the IOSH certificate by the most influential international organization. ',
            'content' => "Kakha Chkhonia, head of occupational health, labor safety and environmental protection department of 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬 received the appropriate recognition from the company's head office in London.
            Within the framework of the Train the Trainer program, he successfully covered 6 modules.
            It should be noted, the future plans of 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬. By participating in IOSH's CPD, the Georgian company will become a technical member of IOSH. Accordingly, 𝐄𝐱𝐩𝐞𝐫𝐭𝐬 𝐅𝐨𝐫 𝐒𝐨𝐥𝐮𝐭𝐢𝐨𝐧𝐬 continues to implement international standards in the business sector with strengthened resources.
            ",
            'date' => '2022-09-22',
            'images' => [
                '2.jpg'
                ]
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function front_index()
    {
        $news = News::where('status',1)->orderBy('id', 'DESC')->get();
        //$news = $this->{app()->getLocale()."NewsArr"};
        return view('news')->with(compact('news'));
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$allnews = $this->{app()->getLocale()."NewsArr"};
        $allnews = News::all();

        return view('argon.pages.news.index')->with(compact('allnews'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('argon.pages.news.crud');
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
            "image" => 'image|mimes:jpeg,jpg,png,gif',
            
        ]);

        $slug = Str::slug($request->name_ka);
       
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

       
        $created = News::create([
            "name_ka" => $request->name_ka,
            "name_en" => $request->name_en,
            "slug" => $slug,
            "status" => $request->status ?? 1,
            "meta_title_ka" => $request->meta_title_ka ?? null,
            "meta_title_en" => $request->meta_title_en ?? null,
            "meta_description_ka" => $request->meta_description_ka ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            'news-trixFields' => $request['news-trixFields']
        ]);

        // news::create([
        //     'news-trixFields' => $request['news-trixFields']
        // ]);
        
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
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function front_show($id)
    {
        $news = News::where('status',1)->get();
       
        //$news = $this->{app()->getLocale()."NewsArr"};

        //$single = $this->{app()->getLocale()."NewsArr"}[$id];
        $single = News::where('id',$id)->where('status',1)->first();
        //print_r($single);exit;
        return view('single-news')->with(compact('single','news'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = $this->{app()->getLocale()."NewsArr"};

        $single = $this->{app()->getLocale()."NewsArr"}[$id];
        return view('single-news')->with(compact('single','news'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
         //print_r($id);exit;
        $news = News::find($id);
        $mediaItems = $news->getMedia('main');
        
        
        return view('argon.pages.news.crud')->with(compact('news','mediaItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        News::find($id)->update([
            'news-trixFields' => $request['news-trixFields'],
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

        
        $updated = News::find($id)->update(
            [
                "name_ka" => $request->name_ka,
                "name_en" => $request->name_en,
                "status" => $request->status,
                "meta_title_ka" => $request->meta_title_ka ?? null,
                "meta_title_en" => $request->meta_title_en ?? null,
                "meta_description_ka" => $request->meta_description_ka ?? null,
                "content_ka" => $request->content_ka ?? '',
                "content_en" => $request->content_en ?? '',
                'news-trixFields' => $request['news-trixFields']
            ]
        );


        

        if($updated){
            if($request->hasFile('image') && $request->file('image')->isValid()){
                
                $project = News::find($id);
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
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
