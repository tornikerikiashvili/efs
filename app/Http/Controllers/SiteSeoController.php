<?php

namespace App\Http\Controllers;

use App\Services\SiteSeoManager;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;

class SiteSeoController extends Controller
{
    public function __construct(private SiteSeoManager $siteSeo)
    {
    }

    public function edit()
    {
        return view('argon.pages.site-seo.edit', [
            'pages' => SiteSeoManager::PAGES,
            'fields' => SiteSeoManager::FIELDS,
            'values' => $this->siteSeo->values(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'pages' => ['required', 'array'],
            'pages.*.ka' => ['required', 'array'],
            'pages.*.en' => ['required', 'array'],
            'pages.*.ka.title' => ['nullable', 'string'],
            'pages.*.ka.description' => ['nullable', 'string'],
            'pages.*.ka.og_title' => ['nullable', 'string'],
            'pages.*.ka.og_description' => ['nullable', 'string'],
            'pages.*.ka.og_image' => ['nullable', 'string'],
            'pages.*.en.title' => ['nullable', 'string'],
            'pages.*.en.description' => ['nullable', 'string'],
            'pages.*.en.og_title' => ['nullable', 'string'],
            'pages.*.en.og_description' => ['nullable', 'string'],
            'pages.*.en.og_image' => ['nullable', 'string'],
        ]);

        $localeValues = [
            'ka' => [],
            'en' => [],
        ];

        foreach (array_keys(SiteSeoManager::PAGES) as $pageKey) {
            foreach (SiteSeoManager::LOCALES as $locale) {
                $localeValues[$locale][$pageKey] = Arr::only(
                    $request->input("pages.{$pageKey}.{$locale}", []),
                    array_keys(SiteSeoManager::FIELDS)
                );
            }
        }

        $this->siteSeo->save($localeValues);

        if (app()->configurationIsCached()) {
            Artisan::call('config:clear');
        }

        return redirect()
            ->route('site-seo.edit')
            ->withSuccess('Site SEO updated.');
    }
}
