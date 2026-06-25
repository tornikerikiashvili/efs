<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\News;
use App\Models\Projects;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $locale = app()->getLocale();
        $nameColumn = 'name_' . $locale;

        $results = collect();

        if ($query !== '') {
            $like = '%' . addcslashes($query, '%_\\') . '%';

            $sources = [
                ['model' => News::class, 'route' => 'singlenews', 'type' => 'menu.news'],
                ['model' => Blog::class, 'route' => 'singleblog', 'type' => 'menu.blog'],
                ['model' => Services::class, 'route' => 'singleservice', 'type' => 'menu.services'],
                ['model' => Projects::class, 'route' => 'singleproject', 'type' => 'menu.projects'],
            ];

            foreach ($sources as $source) {
                $items = $source['model']::query()
                    ->where('status', 1)
                    ->where($nameColumn, 'LIKE', $like)
                    ->orderByDesc('id')
                    ->get();

                foreach ($items as $item) {
                    $results->push((object) [
                        'title' => $item->{$nameColumn},
                        'url' => route($source['route'], ['slug' => $item->slugForLocale()]),
                        'type' => __($source['type']),
                        'image' => $item->getFirstMediaUrl('main'),
                        'alt' => method_exists($item, 'imageAltForLocale') ? $item->imageAltForLocale() : $item->{$nameColumn},
                    ]);
                }
            }
        }

        $page = current_list_page();
        $perPage = list_page_size();
        $paginated = new LengthAwarePaginator(
            $results->forPage($page, $perPage)->values(),
            $results->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $seoTitle = $query !== ''
            ? __('other.search_results_for', ['query' => $query])
            : __('other.search');

        return view('search', [
            'q' => $query,
            'results' => $paginated,
            'seo' => [
                'title' => $seoTitle,
                'description' => $query !== ''
                    ? __('other.search_results_description', ['query' => $query])
                    : __('other.search_description'),
            ],
        ]);
    }
}
