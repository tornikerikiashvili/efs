<?php

namespace App\Services;

use App\Models\News;
use App\Models\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SchemaMarkup
{
    public function toJson(?Model $entity = null, ?array $pageSeo = null): ?string
    {
        $graph = $this->graph($entity, $pageSeo);

        if ($graph === null) {
            return null;
        }

        return json_encode([
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return list<array<string, mixed>>|null
     */
    public function graph(?Model $entity = null, ?array $pageSeo = null): ?array
    {
        $pageSeo ??= page_seo($entity);
        $routeName = request()->route()?->getName();

        return match ($routeName) {
            'homepagefront' => $this->homeGraph($pageSeo),
            'about' => $this->aboutGraph($pageSeo),
            'services' => $this->servicesGraph($pageSeo),
            'singlenews' => $entity instanceof News ? $this->newsArticleGraph($entity, $pageSeo) : null,
            'contact' => $this->contactGraph($pageSeo),
            default => null,
        };
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function homeGraph(array $pageSeo): array
    {
        $locale = app()->getLocale();
        $homeUrl = $this->pageUrl('/');
        $pageUrl = $this->currentPageUrl();
        $pageName = $this->pageName($pageSeo, __('seo.home.title'));

        return [
            $this->webSiteNode($locale, $homeUrl),
            $this->organizationNode($locale, $homeUrl),
            [
                '@type' => 'WebPage',
                '@id' => $pageUrl.'#webpage',
                'url' => $pageUrl,
                'name' => $pageName,
                'description' => $pageSeo['description'] ?? null,
                'inLanguage' => $locale,
                'isPartOf' => ['@id' => $this->entityId($homeUrl, 'website')],
                'about' => ['@id' => $this->entityId($homeUrl, 'organization')],
                'breadcrumb' => $this->breadcrumb([
                    ['name' => $this->homeLabel(), 'url' => $homeUrl],
                ]),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function aboutGraph(array $pageSeo): array
    {
        $locale = app()->getLocale();
        $homeUrl = $this->pageUrl('/');
        $pageUrl = $this->currentPageUrl();
        $aboutLabel = __('menu.about.about_us');
        $pageName = $this->pageName($pageSeo, $aboutLabel);

        return [
            [
                '@type' => 'AboutPage',
                '@id' => $pageUrl.'#webpage',
                'url' => $pageUrl,
                'name' => $pageName,
                'description' => $pageSeo['description'] ?? null,
                'inLanguage' => $locale,
                'isPartOf' => ['@id' => $this->entityId($homeUrl, 'website')],
                'about' => ['@id' => $this->entityId($homeUrl, 'organization')],
                'breadcrumb' => $this->breadcrumb([
                    ['name' => $this->homeLabel(), 'url' => $homeUrl],
                    ['name' => $aboutLabel, 'url' => $pageUrl],
                ]),
            ],
            $this->organizationNode($locale, $homeUrl),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function servicesGraph(array $pageSeo): array
    {
        $locale = app()->getLocale();
        $homeUrl = $this->pageUrl('/');
        $pageUrl = $this->currentPageUrl();
        $servicesLabel = __('menu.services');
        $pageName = $this->pageName($pageSeo, $servicesLabel);

        $graph = [
            [
                '@type' => 'WebPage',
                '@id' => $pageUrl.'#webpage',
                'url' => $pageUrl,
                'name' => $pageName,
                'description' => $pageSeo['description'] ?? null,
                'inLanguage' => $locale,
                'isPartOf' => ['@id' => $this->entityId($homeUrl, 'website')],
                'breadcrumb' => $this->breadcrumb([
                    ['name' => $this->homeLabel(), 'url' => $homeUrl],
                    ['name' => $servicesLabel, 'url' => $pageUrl],
                ]),
            ],
        ];

        foreach (Services::where('status', 1)->get() as $service) {
            $graph[] = $this->serviceNode($service, $pageUrl, $homeUrl, $locale);
        }

        return $graph;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function newsArticleGraph(News $article, array $pageSeo): array
    {
        $locale = app()->getLocale();
        $homeUrl = $this->pageUrl('/');
        $pageUrl = $this->currentPageUrl($article);
        $newsIndexUrl = $this->pageUrl(route('news', [], false));
        $newsLabel = __('menu.news');
        $headline = $article->{'name_'.$locale};
        $description = $pageSeo['description'] ?? seo_plain_text($article->{'short_content_'.$locale})
            ?? seo_plain_text($article->trixRender('content_'.$locale));
        $imageUrl = $article->getFirstMediaUrl('main') ?: ($pageSeo['og_image'] ?? null);
        $imageUrl = $imageUrl ? seo_absolute_url($imageUrl) : null;

        $articleNode = [
            '@type' => 'Article',
            '@id' => $pageUrl.'#article',
            'headline' => $headline,
            'description' => $description,
            'datePublished' => $this->isoDate($article->created_at),
            'dateModified' => $this->isoDate($article->updated_at),
            'author' => [
                '@type' => 'Organization',
                'name' => 'EFS',
                'url' => $homeUrl,
            ],
            'publisher' => ['@id' => $this->entityId($homeUrl, 'organization')],
            'inLanguage' => $locale,
            'isPartOf' => ['@id' => $this->entityId($homeUrl, 'website')],
            'url' => $pageUrl,
            'articleSection' => $newsLabel,
            'mainEntityOfPage' => ['@id' => $pageUrl.'#webpage'],
        ];

        if ($imageUrl) {
            $articleNode['image'] = [
                '@type' => 'ImageObject',
                'url' => $imageUrl,
            ];
        }

        $webPageNode = [
            '@type' => 'WebPage',
            '@id' => $pageUrl.'#webpage',
            'url' => $pageUrl,
            'name' => $this->pageName($pageSeo, $headline),
            'inLanguage' => $locale,
            'isPartOf' => ['@id' => $this->entityId($homeUrl, 'website')],
            'breadcrumb' => $this->breadcrumb([
                ['name' => $this->homeLabel(), 'url' => $homeUrl],
                ['name' => $newsLabel, 'url' => $newsIndexUrl],
                ['name' => $headline, 'url' => $pageUrl],
            ]),
        ];

        if ($imageUrl) {
            $webPageNode['primaryImageOfPage'] = $imageUrl;
        }

        return [$articleNode, $webPageNode];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function contactGraph(array $pageSeo): array
    {
        $locale = app()->getLocale();
        $homeUrl = $this->pageUrl('/');
        $pageUrl = $this->currentPageUrl();
        $contactLabel = __('menu.contact');
        $pageName = $this->pageName($pageSeo, $contactLabel);

        return [
            [
                '@type' => 'ContactPage',
                '@id' => $pageUrl.'#webpage',
                'url' => $pageUrl,
                'name' => $pageName,
                'description' => $pageSeo['description'] ?? null,
                'inLanguage' => $locale,
                'isPartOf' => ['@id' => $this->entityId($homeUrl, 'website')],
                'breadcrumb' => $this->breadcrumb([
                    ['name' => $this->homeLabel(), 'url' => $homeUrl],
                    ['name' => $contactLabel, 'url' => $pageUrl],
                ]),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function webSiteNode(string $locale, string $homeUrl): array
    {
        $searchUrl = rtrim($homeUrl, '/').'?s={search_term_string}';

        return [
            '@type' => 'WebSite',
            '@id' => $this->entityId($homeUrl, 'website'),
            'name' => 'EFS',
            'url' => $homeUrl,
            'inLanguage' => $locale,
            'publisher' => ['@id' => $this->entityId($homeUrl, 'organization')],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $searchUrl,
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function organizationNode(string $locale, string $homeUrl): array
    {
        $logoUrl = seo_absolute_url('/images/Logo-'.$locale.'.png?2');

        return [
            '@type' => 'Organization',
            '@id' => $this->entityId($homeUrl, 'organization'),
            'name' => 'EFS',
            'url' => $homeUrl,
            'logo' => [
                '@type' => 'ImageObject',
                '@id' => $this->entityId($homeUrl, 'logo'),
                'url' => $logoUrl,
                'contentUrl' => $logoUrl,
            ],
            'description' => seo_site_default_description(),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => __('other.contact_address'),
                'addressLocality' => 'Tbilisi',
                'addressCountry' => 'GE',
            ],
            'telephone' => '+995591516183',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+995591516183',
                'contactType' => 'customer service',
                'areaServed' => 'GE',
                'availableLanguage' => ['Georgian', 'English'],
            ],
            'sameAs' => [
                'https://www.facebook.com/HSSEQmanagement',
                'https://www.linkedin.com/company/81786613',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function serviceNode(Services $service, string $servicesPageUrl, string $homeUrl, string $locale): array
    {
        $slug = $service->slugForLocale($locale);
        $serviceUrl = $slug !== ''
            ? $this->pageUrl(route('singleservice', ['slug' => $slug], false))
            : $servicesPageUrl;
        $description = seo_plain_text($service->{'meta_description_'.$locale})
            ?? seo_plain_text($service->trixRender('content_'.$locale));

        return array_filter([
            '@type' => 'Service',
            '@id' => $servicesPageUrl.'#service-'.$slug.'/'.$service->id,
            'name' => $service->{'name_'.$locale},
            'description' => $description,
            'provider' => ['@id' => $this->entityId($homeUrl, 'organization')],
            'serviceType' => $service->name_en ?: $service->name_ka,
            'areaServed' => 'GE',
            'url' => $serviceUrl,
        ], fn ($value) => $value !== null && $value !== '');
    }

    /**
     * @param  list<array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    private function breadcrumb(array $items): array
    {
        $elements = [];

        foreach ($items as $index => $item) {
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => $elements,
        ];
    }

    private function entityId(string $homeUrl, string $fragment): string
    {
        return rtrim($homeUrl, '/').'#'.ltrim($fragment, '#');
    }

    private function pageUrl(string $path): string
    {
        return localized_url(app()->getLocale(), $path);
    }

    private function currentPageUrl(?Model $entity = null): string
    {
        return canonical_url($entity);
    }

    private function homeLabel(): string
    {
        $label = __('seo.home.title');

        return $label === 'seo.home.title' ? 'Home' : $label;
    }

    private function pageName(array $pageSeo, string $fallback): string
    {
        $title = trim((string) ($pageSeo['title'] ?? ''));

        return $title !== '' ? $title : $fallback.' — EFS';
    }

    private function isoDate($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return Carbon::parse($value)->toIso8601String();
    }
}
