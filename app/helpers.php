<?php

use App\Models\Blog;
use App\Models\News;
use App\Models\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function test()
{
   return 'A Global Function with ';
}

function takeText($collection, $textcode)
{
   return $collection->where('text_code', $textcode)->first()['text_'.app()->getLocale()];
}

function make_localized_slug(string $text): string
{
    $slug = Str::slug($text);

    if ($slug !== '') {
        return $slug;
    }

    $slug = mb_strtolower(trim(preg_replace('/[^\p{L}\p{N}]+/u', '-', $text), '-'));

    return $slug !== '' ? $slug : '';
}

function unique_localized_slug(string $table, string $column, string $text, ?int $exceptId = null): string
{
    $base = make_localized_slug($text) ?: 'item';
    $slug = $base;
    $i = 1;

    while (DB::table($table)->where($column, $slug)->when($exceptId, function ($query) use ($exceptId) {
        $query->where('id', '!=', $exceptId);
    })->exists()) {
        $slug = $base . '-' . $i++;
    }

    return $slug;
}

function slugs_from_request(Request $request, string $table, ?int $exceptId = null): array
{
    return [
        'slug_ka' => $request->filled('slug_ka')
            ? make_localized_slug($request->slug_ka)
            : unique_localized_slug($table, 'slug_ka', $request->name_ka, $exceptId),
        'slug_en' => $request->filled('slug_en')
            ? make_localized_slug($request->slug_en)
            : unique_localized_slug($table, 'slug_en', $request->name_en, $exceptId),
    ];
}

function find_by_localized_slug(string $modelClass, string $slug)
{
    $column = 'slug_' . app()->getLocale();

    return $modelClass::where('status', 1)->where($column, $slug)->firstOrFail();
}

/**
 * Resolve a news/blog-style record by localized slug, with legacy numeric ID support.
 *
 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
 */
function resolve_localized_content(string $modelClass, string $segment)
{
    $routeMap = [
        Blog::class => 'singleblog',
        News::class => 'singlenews',
        Services::class => 'singleservice',
    ];

    $routeName = $routeMap[$modelClass] ?? null;

    if (ctype_digit($segment)) {
        $byId = $modelClass::where('status', 1)->find($segment);

        if ($byId && $routeName) {
            return redirect()->route($routeName, ['slug' => $byId->slugForLocale()], 301);
        }
    }

    $locale = app()->getLocale();
    $column = 'slug_' . $locale;

    $item = $modelClass::where('status', 1)->where($column, $segment)->first();

    if (! $item) {
        $item = $modelClass::where('status', 1)
            ->where(function ($query) use ($segment) {
                $query->where('slug_ka', $segment)->orWhere('slug_en', $segment);
            })
            ->first();
    }

    if (! $item) {
        abort(404);
    }

    $canonicalSlug = $item->slugForLocale($locale);

    if ($canonicalSlug !== '' && $canonicalSlug !== $segment && $routeName) {
        return redirect()->route($routeName, ['slug' => $canonicalSlug], 301);
    }

    return $item;
}

/**
 * Build a language-switch URL that respects different slugs per locale.
 */
function localized_switch_url(string $targetLocale, ?Model $entity = null): string
{
    $route = request()->route();

    if (! $route) {
        return LaravelLocalization::getLocalizedURL($targetLocale);
    }

    $slugRoutes = [
        'singlenews' => News::class,
        'singleblog' => Blog::class,
        'singleservice' => Services::class,
    ];

    $routeName = $route->getName();

    if (isset($slugRoutes[$routeName])) {
        $modelClass = $slugRoutes[$routeName];
        $item = ($entity instanceof Model && $entity instanceof $modelClass) ? $entity : null;

        if (! $item) {
            $currentSlug = $route->parameter('slug');
            $currentColumn = 'slug_' . app()->getLocale();

            $item = $modelClass::where('status', 1)
                ->where($currentColumn, $currentSlug)
                ->first();

            if (! $item) {
                $item = $modelClass::where('status', 1)
                    ->where(function ($query) use ($currentSlug) {
                        $query->where('slug_ka', $currentSlug)->orWhere('slug_en', $currentSlug);
                    })
                    ->first();
            }
        }

        if ($item instanceof Model) {
            $targetSlug = $item->slugForLocale($targetLocale);

            if ($targetSlug !== '') {
                $url = route($routeName, ['slug' => $targetSlug], false);

                return LaravelLocalization::getLocalizedURL($targetLocale, $url);
            }
        }

        $indexRoutes = [
            'singlenews' => 'news',
            'singleblog' => 'blog',
            'singleservice' => 'services',
        ];

        if (isset($indexRoutes[$routeName])) {
            return LaravelLocalization::getLocalizedURL($targetLocale, route($indexRoutes[$routeName], [], false));
        }
    }

    return LaravelLocalization::getLocalizedURL($targetLocale);
}
