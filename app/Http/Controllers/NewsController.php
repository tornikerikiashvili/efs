<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function front_index()
    {
        $news = News::where('status', 1)->orderBy('id', 'DESC')->get();

        return view('news')->with(compact('news'));
    }

    public function index()
    {
        $allnews = News::all();

        return view('argon.pages.news.index')->with(compact('allnews'));
    }

    public function create()
    {
        return view('argon.pages.news.crud');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'image|mimes:jpeg,jpg,png,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $created = News::create(array_merge([
            "name_ka" => $request->name_ka,
            "name_en" => $request->name_en,
            "status" => $request->status ?? 1,
            "meta_title_ka" => $request->meta_title_ka ?? null,
            "meta_title_en" => $request->meta_title_en ?? null,
            "meta_description_ka" => $request->meta_description_ka ?? null,
            "meta_description_en" => $request->meta_description_en ?? null,
            "og_title_ka" => $request->og_title_ka ?? null,
            "og_title_en" => $request->og_title_en ?? null,
            "og_description_ka" => $request->og_description_ka ?? null,
            "og_description_en" => $request->og_description_en ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            'news-trixFields' => $request['news-trixFields'],
        ], slugs_from_request($request, 'news')));

        if ($created) {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $created->addMedia($request->image)->toMediaCollection('main');
            }

            return redirect()->back()->withSuccess('IT WORKS!');
        }

        return redirect()->back()->withErrors(['error create']);
    }

    public function front_show($slug)
    {
        $single = resolve_localized_content(News::class, $slug);

        if ($single instanceof \Illuminate\Http\RedirectResponse) {
            return $single;
        }

        $news = News::where('status', 1)->orderBy('id', 'DESC')->get();

        return view('single-news')->with(compact('single', 'news'));
    }

    public function edit($id)
    {
        $news = News::find($id);
        $mediaItems = $news->getMedia('main');

        return view('argon.pages.news.crud')->with(compact('news', 'mediaItems'));
    }

    public function update($id, Request $request)
    {
        News::find($id)->update([
            'news-trixFields' => $request['news-trixFields'],
        ]);

        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'mimes:jpeg,jpg,png,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updated = News::find($id)->update(array_merge([
            "name_ka" => $request->name_ka,
            "name_en" => $request->name_en,
            "status" => $request->status,
            "meta_title_ka" => $request->meta_title_ka ?? null,
            "meta_title_en" => $request->meta_title_en ?? null,
            "meta_description_ka" => $request->meta_description_ka ?? null,
            "meta_description_en" => $request->meta_description_en ?? null,
            "og_title_ka" => $request->og_title_ka ?? null,
            "og_title_en" => $request->og_title_en ?? null,
            "og_description_ka" => $request->og_description_ka ?? null,
            "og_description_en" => $request->og_description_en ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            'news-trixFields' => $request['news-trixFields'],
        ], slugs_from_request($request, 'news', (int) $id)));

        if ($updated) {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $project = News::find($id);
                $mediaItems = $project->getMedia('main');
                if (isset($mediaItems[0])) {
                    $mediaItems[0]->delete();
                }
                $project->addMedia($request->image)->toMediaCollection('main');
            }

            return redirect()->back()->withSuccess('IT WORKS!');
        }

        return redirect()->back()->withErrors(['error update']);
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')->withSuccess('Deleted');
    }
}
