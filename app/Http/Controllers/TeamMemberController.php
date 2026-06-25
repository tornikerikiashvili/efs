<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::orderBy('sort_order')->orderBy('id')->get();

        return view('argon.pages.team-members.index')->with(compact('teamMembers'));
    }

    public function create()
    {
        return view('argon.pages.team-members.crud');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ka' => 'required',
            'name_en' => 'required',
            'position_ka' => 'required',
            'position_en' => 'required',
            'image' => 'required|image|mimes:'.cms_image_mimes(),
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $created = TeamMember::create([
            'name_ka' => $request->name_ka,
            'name_en' => $request->name_en,
            'position_ka' => $request->position_ka,
            'position_en' => $request->position_en,
            'image_alt_ka' => $request->image_alt_ka ?? null,
            'image_alt_en' => $request->image_alt_en ?? null,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        if ($created && $request->hasFile('image') && $request->file('image')->isValid()) {
            $created->addMedia($request->image)->toMediaCollection('main');
        }

        return redirect()->route('team-members.index')->withSuccess('Created');
    }

    public function edit(TeamMember $team_member)
    {
        $member = $team_member;
        $mediaItems = $member->getMedia('main');

        return view('argon.pages.team-members.crud')->with(compact('member', 'mediaItems'));
    }

    public function update(Request $request, TeamMember $team_member)
    {
        $validator = Validator::make($request->all(), [
            'name_ka' => 'required',
            'name_en' => 'required',
            'position_ka' => 'required',
            'position_en' => 'required',
            'image' => 'nullable|image|mimes:'.cms_image_mimes(),
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $team_member->update([
            'name_ka' => $request->name_ka,
            'name_en' => $request->name_en,
            'position_ka' => $request->position_ka,
            'position_en' => $request->position_en,
            'image_alt_ka' => $request->image_alt_ka ?? null,
            'image_alt_en' => $request->image_alt_en ?? null,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $mediaItems = $team_member->getMedia('main');
            if (isset($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
            $team_member->addMedia($request->image)->toMediaCollection('main');
        }

        return redirect()->back()->withSuccess('Updated');
    }

    public function destroy(TeamMember $team_member)
    {
        $team_member->delete();

        return redirect()->route('team-members.index')->withSuccess('Deleted');
    }
}
