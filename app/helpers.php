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

    if ($canonicalSlug !== '' && mb_strtolower($canonicalSlug) !== mb_strtolower($segment) && $routeName) {
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
        return localized_url($targetLocale);
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
                return localized_url($targetLocale, route($routeName, ['slug' => $targetSlug], false));
            }
        }

        $indexRoutes = [
            'singlenews' => 'news',
            'singleblog' => 'blog',
            'singleservice' => 'services',
        ];

        if (isset($indexRoutes[$routeName])) {
            return localized_url($targetLocale, route($indexRoutes[$routeName], [], false));
        }
    }

    if ($routeName) {
        $parameters = collect($route->parameters())->except(['locale'])->all();

        return localized_url($targetLocale, route($routeName, $parameters, false));
    }

    return localized_url($targetLocale);
}

/**
 * Build a localized absolute URL using the site's real URL structure.
 * Georgian (default) has no /ka prefix; English uses /en.
 */
function localized_url(string $locale, ?string $path = null): string
{
    $url = $path === null
        ? LaravelLocalization::getLocalizedURL($locale)
        : LaravelLocalization::getLocalizedURL($locale, $path);

    return seo_canonical_absolute_url($url);
}

/**
 * HTML lang attribute value for the active or given locale.
 */
function html_lang_attribute(?string $locale = null): string
{
    return ($locale ?? app()->getLocale()) === 'en' ? 'en-GE' : 'ka';
}

/**
 * Absolute canonical URL for a localized page.
 */
function localized_page_url(string $locale, ?Model $entity = null): string
{
    return localized_switch_url($locale, $entity);
}

/**
 * Canonical URL for the current page.
 */
function canonical_url(?Model $entity = null): string
{
    return localized_page_url(app()->getLocale(), $entity);
}

/**
 * hreflang alternate links for the current page (ka, en, x-default).
 *
 * @return list<array{hreflang: string, href: string}>
 */
function hreflang_alternates(?Model $entity = null): array
{
    return [
        ['hreflang' => 'ka', 'href' => localized_page_url('ka', $entity)],
        ['hreflang' => 'en', 'href' => localized_page_url('en', $entity)],
        ['hreflang' => 'x-default', 'href' => localized_page_url('ka', $entity)],
    ];
}

/**
 * Build an absolute URL for canonical/hreflang using the current request host.
 */
function seo_canonical_absolute_url(string $url): string
{
    if (! Str::startsWith($url, ['http://', 'https://'])) {
        $url = url($url);
    }

    if (app()->runningInConsole()) {
        return $url;
    }

    $path = parse_url($url, PHP_URL_PATH) ?: '/';

    return request()->getSchemeAndHttpHost() . $path;
}

function seo_plain_text(?string $text, int $limit = 160): ?string
{
    if ($text === null || $text === '') {
        return null;
    }

    $text = trim(preg_replace('/\s+/', ' ', strip_tags($text)));

    if ($text === '') {
        return null;
    }

    return Str::limit($text, $limit, '...');
}

function seo_absolute_url(?string $url): ?string
{
    if ($url === null || $url === '') {
        return null;
    }

    if (Str::startsWith($url, ['http://', 'https://'])) {
        return $url;
    }

    return url($url);
}

function seo_translation_value(string $page, string $field): ?string
{
    $key = "seo.{$page}.{$field}";
    $value = __($key);

    return $value === $key ? null : $value;
}

function seo_route_page_map(): array
{
    return [
        'homepagefront' => 'home',
        'about' => 'about',
        'sub-about' => 'about',
        'services' => 'services',
        'projects' => 'projects',
        'news' => 'news',
        'blog' => 'blog',
        'contact' => 'contact',
    ];
}

function seo_hardcoded_fallback(): array
{
    return [
        'title' => 'EFS - ' . __('homepage.first_text_head'),
        'description' => __('homepage.first_text'),
        'og_title' => __('homepage.first_text_head'),
        'og_description' => __('homepage.first_text'),
        'og_image' => url('/images/Logo-fb-en.png?6'),
        'og_type' => 'website',
    ];
}

function seo_site_default_title(): string
{
    return seo_translation_value('default', 'title') ?: seo_hardcoded_fallback()['title'];
}

function seo_site_default_description(): string
{
    return seo_translation_value('default', 'description') ?: seo_hardcoded_fallback()['description'];
}

function seo_compound_title(?string $primary): string
{
    $siteDefault = seo_site_default_title();
    $primary = trim((string) $primary);

    if ($primary === '' || $primary === $siteDefault) {
        return $siteDefault;
    }

    return $primary.' | '.$siteDefault;
}

function seo_from_translation_page(string $page, array $fallback): array
{
    $pageTitle = seo_translation_value($page, 'title');
    $description = seo_translation_value($page, 'description');
    $ogTitle = seo_translation_value($page, 'og_title');
    $ogDescription = seo_translation_value($page, 'og_description');
    $ogImage = seo_translation_value($page, 'og_image');

    if ($page === 'default') {
        $title = $pageTitle ?: $fallback['title'];
    } elseif ($pageTitle) {
        $title = seo_compound_title($pageTitle);
    } else {
        $title = $fallback['title'];
    }

    return [
        'title' => $title,
        'description' => $description ?: $fallback['description'],
        'og_title' => $ogTitle ?: $pageTitle ?: $fallback['og_title'],
        'og_description' => $ogDescription ?: $description ?: $fallback['og_description'],
        'og_image' => seo_absolute_url($ogImage) ?: $fallback['og_image'],
        'og_type' => 'website',
    ];
}

function seo_for_route(?string $routeName): ?array
{
    $page = seo_route_page_map()[$routeName] ?? null;

    if ($page === null) {
        return null;
    }

    return seo_from_translation_page($page, default_page_seo());
}

function default_page_seo(): array
{
    return seo_from_translation_page('default', seo_hardcoded_fallback());
}

function seo_from_entity(Model $entity): array
{
    $locale = app()->getLocale();
    $metaTitle = $entity->{'meta_title_' . $locale} ?? null;
    $metaDescription = $entity->{'meta_description_' . $locale} ?? null;
    $ogTitle = $entity->{'og_title_' . $locale} ?? null;
    $ogDescription = $entity->{'og_description_' . $locale} ?? null;
    $name = $entity->{'name_' . $locale} ?? null;

    $contentFallback = null;

    if (method_exists($entity, 'trixRender')) {
        $contentFallback = $entity->trixRender('short_content_' . $locale)
            ?: $entity->trixRender('content_' . $locale);
    }

    $description = seo_plain_text($metaDescription)
        ?: seo_plain_text($ogDescription)
        ?: seo_plain_text($contentFallback);

    $ogImage = null;

    if (method_exists($entity, 'getFirstMediaUrl')) {
        $ogImage = seo_absolute_url($entity->getFirstMediaUrl('main') ?: null);
    }

    $defaults = default_page_seo();
    $primaryTitle = trim($metaTitle ?: $name ?: '');

    return [
        'title' => $primaryTitle !== '' ? seo_compound_title($primaryTitle) : $defaults['title'],
        'description' => $description ?: $defaults['description'],
        'og_title' => $ogTitle ?: $metaTitle ?: $name ?: $defaults['og_title'],
        'og_description' => seo_plain_text($ogDescription)
            ?: seo_plain_text($metaDescription)
            ?: $description
            ?: $defaults['og_description'],
        'og_image' => $ogImage ?: $defaults['og_image'],
        'og_type' => 'article',
    ];
}

/**
 * Resolve page SEO/OG tags from a content entity, explicit overrides, or site defaults.
 *
 * Usage:
 *   page_seo($newsItem)
 *   page_seo(null, ['title' => 'Contact', 'description' => '...'])
 *   page_seo($entity, ['og_type' => 'website'])
 */
function page_seo(?Model $entity = null, array $overrides = []): array
{
    if ($entity) {
        $seo = seo_from_entity($entity);
    } elseif ($overrides !== []) {
        $seo = default_page_seo();
    } else {
        $seo = seo_for_route(request()->route()?->getName()) ?? default_page_seo();
    }

    foreach ($overrides as $key => $value) {
        if ($value !== null && $value !== '') {
            $seo[$key] = $value;
        }
    }

    if (isset($seo['og_image'])) {
        $seo['og_image'] = seo_absolute_url($seo['og_image']) ?: default_page_seo()['og_image'];
    }

    return $seo;
}

/**
 * JSON-LD schema markup for the current page.
 */
function schema_json_ld(?Model $entity = null, ?array $pageSeo = null): ?string
{
    return app(\App\Services\SchemaMarkup::class)->toJson($entity, $pageSeo);
}
