<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function front_index()
    {
        $blogs = Blog::where('status', 1)->orderBy('id', 'DESC')->get();

        return view('blog')->with(compact('blogs'));
    }

    public function index()
    {
        $allblogs = Blog::all();

        return view('argon.pages.blog.index')->with(compact('allblogs'));
    }

    public function create()
    {
        return view('argon.pages.blog.crud');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'image|mimes:'.cms_image_mimes(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $created = Blog::create(array_merge([
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
            "image_alt_ka" => $request->image_alt_ka ?? null,
            "image_alt_en" => $request->image_alt_en ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            'blog-trixFields' => $request['blog-trixFields'],
        ], slugs_from_request($request, 'blogs')));

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
        $single = resolve_localized_content(Blog::class, $slug);

        if ($single instanceof \Illuminate\Http\RedirectResponse) {
            return $single;
        }

        $blogs = Blog::where('status', 1)->orderBy('id', 'DESC')->get();

        return view('single-blog')->with(compact('single', 'blogs'));
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        $mediaItems = $blog->getMedia('main');

        return view('argon.pages.blog.crud')->with(compact('blog', 'mediaItems'));
    }

    public function update($id, Request $request)
    {
        Blog::find($id)->update([
            'blog-trixFields' => $request['blog-trixFields'],
        ]);

        $validator = Validator::make($request->all(), [
            "name_ka" => "required",
            "name_en" => "required",
            "image" => 'mimes:'.cms_image_mimes(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updated = Blog::find($id)->update(array_merge([
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
            "image_alt_ka" => $request->image_alt_ka ?? null,
            "image_alt_en" => $request->image_alt_en ?? null,
            "content_ka" => $request->content_ka ?? '',
            "content_en" => $request->content_en ?? '',
            'blog-trixFields' => $request['blog-trixFields'],
        ], slugs_from_request($request, 'blogs', (int) $id)));

        if ($updated) {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $blog = Blog::find($id);
                $mediaItems = $blog->getMedia('main');
                if (isset($mediaItems[0])) {
                    $mediaItems[0]->delete();
                }
                $blog->addMedia($request->image)->toMediaCollection('main');
            }

            return redirect()->back()->withSuccess('IT WORKS!');
        }

        return redirect()->back()->withErrors(['error update']);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blog.index')->withSuccess('Deleted');
    }
}
