<?php

namespace App\Http\Controllers;

use App\Models\PartnerLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnerLogoController extends Controller
{
    public function index()
    {
        $partners = PartnerLogo::orderBy('sort_order')->orderBy('id')->get();

        return view('argon.pages.partner-logos.index')->with(compact('partners'));
    }

    public function create()
    {
        return view('argon.pages.partner-logos.crud');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'nullable|url|max:2048',
            'image' => 'required|image|mimes:'.cms_image_mimes(),
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $created = PartnerLogo::create([
            'name' => $request->name,
            'url' => $request->url,
            'image_alt_ka' => $request->image_alt_ka ?? null,
            'image_alt_en' => $request->image_alt_en ?? null,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        if ($created && $request->hasFile('image') && $request->file('image')->isValid()) {
            $created->addMedia($request->image)->toMediaCollection('main');
        }

        return redirect()->route('partner-logos.index')->withSuccess('Created');
    }

    public function edit(PartnerLogo $partner_logo)
    {
        $partner = $partner_logo;
        $mediaItems = $partner->getMedia('main');

        return view('argon.pages.partner-logos.crud')->with(compact('partner', 'mediaItems'));
    }

    public function update(Request $request, PartnerLogo $partner_logo)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'url' => 'nullable|url|max:2048',
            'image' => 'nullable|image|mimes:'.cms_image_mimes(),
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $partner_logo->update([
            'name' => $request->name,
            'url' => $request->url,
            'image_alt_ka' => $request->image_alt_ka ?? null,
            'image_alt_en' => $request->image_alt_en ?? null,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $mediaItems = $partner_logo->getMedia('main');
            if (isset($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
            $partner_logo->addMedia($request->image)->toMediaCollection('main');
        }

        return redirect()->back()->withSuccess('Updated');
    }

    public function destroy(PartnerLogo $partner_logo)
    {
        $partner_logo->delete();

        return redirect()->route('partner-logos.index')->withSuccess('Deleted');
    }
}
