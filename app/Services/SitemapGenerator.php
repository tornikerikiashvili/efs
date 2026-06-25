<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\News;
use App\Models\Projects;
use App\Models\Services;
use DateTimeInterface;
use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SitemapGenerator
{
    private const SITEMAP_NAMESPACE = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    private const LOCALES = ['ka', 'en'];

    /**
     * Public front-end pages (route name => sitemap metadata).
     *
     * @var array<string, array{changefreq: string, priority: string}>
     */
    private const STATIC_ROUTES = [
        'homepagefront' => ['changefreq' => 'weekly', 'priority' => '1.0'],
        'about' => ['changefreq' => 'monthly', 'priority' => '0.8'],
        'sub-about' => ['changefreq' => 'monthly', 'priority' => '0.7'],
        'services' => ['changefreq' => 'weekly', 'priority' => '0.9'],
        'projects' => ['changefreq' => 'weekly', 'priority' => '0.8'],
        'news' => ['changefreq' => 'weekly', 'priority' => '0.8'],
        'blog' => ['changefreq' => 'weekly', 'priority' => '0.8'],
        'contact' => ['changefreq' => 'monthly', 'priority' => '0.7'],
    ];

    /**
     * Published content models with detail-page routes.
     *
     * @var array<class-string<Model>, array{route: string, changefreq: string, priority: string}>
     */
    private const CONTENT_MODELS = [
        Services::class => [
            'route' => 'singleservice',
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ],
        News::class => [
            'route' => 'singlenews',
            'changefreq' => 'weekly',
            'priority' => '0.6',
        ],
        Blog::class => [
            'route' => 'singleblog',
            'changefreq' => 'weekly',
            'priority' => '0.6',
        ],
        Projects::class => [
            'route' => 'singleproject',
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ],
    ];

    /**
     * @return list<array{loc: string, lastmod?: string, changefreq: string, priority: string}>
     */
    public function urls(): array
    {
        $urls = [];

        foreach (self::LOCALES as $locale) {
            $urls = array_merge($urls, $this->staticPageUrls($locale));
            $urls = array_merge($urls, $this->contentModelUrls($locale));
        }

        return $urls;
    }

    public function toXml(): string
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = true;

        $urlset = $document->createElement('urlset');
        $urlset->setAttribute('xmlns', self::SITEMAP_NAMESPACE);
        $document->appendChild($urlset);

        foreach ($this->urls() as $url) {
            $urlNode = $document->createElement('url');
            $urlset->appendChild($urlNode);

            $loc = $document->createElement('loc', $url['loc']);
            $urlNode->appendChild($loc);

            if (isset($url['lastmod'])) {
                $lastmod = $document->createElement('lastmod', $url['lastmod']);
                $urlNode->appendChild($lastmod);
            }

            $changefreq = $document->createElement('changefreq', $url['changefreq']);
            $urlNode->appendChild($changefreq);

            $priority = $document->createElement('priority', $url['priority']);
            $urlNode->appendChild($priority);
        }

        return $document->saveXML();
    }

    /**
     * @return list<array{loc: string, lastmod?: string, changefreq: string, priority: string}>
     */
    private function staticPageUrls(string $locale): array
    {
        $urls = [];

        foreach (self::STATIC_ROUTES as $routeName => $meta) {
            $lastmod = $routeName === 'projects' ? $this->latestModelTimestamp(Projects::class) : null;

            $urls[] = $this->entry(
                $this->localizedUrl($locale, $routeName),
                $meta['changefreq'],
                $meta['priority'],
                $lastmod
            );
        }

        return $urls;
    }

    /**
     * @return list<array{loc: string, lastmod?: string, changefreq: string, priority: string}>
     */
    private function contentModelUrls(string $locale): array
    {
        $urls = [];

        foreach (self::CONTENT_MODELS as $modelClass => $meta) {
            foreach ($modelClass::where('status', 1)->get() as $item) {
                $slug = $item->slugForLocale($locale);

                if ($slug === '') {
                    continue;
                }

                $urls[] = $this->entry(
                    $this->localizedUrl($locale, $meta['route'], ['slug' => $slug]),
                    $meta['changefreq'],
                    $meta['priority'],
                    $item->updated_at
                );
            }
        }

        return $urls;
    }

    private function localizedUrl(string $locale, string $routeName, array $params = []): string
    {
        $previousLocale = app()->getLocale();
        app()->setLocale($locale);

        try {
            return localized_url($locale, route($routeName, $params, false));
        } finally {
            app()->setLocale($previousLocale);
        }
    }

    private function entry(string $loc, string $changefreq, string $priority, $lastmod = null): array
    {
        $entry = [
            'loc' => $loc,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];

        if ($lastmod instanceof DateTimeInterface) {
            $entry['lastmod'] = $lastmod->format('Y-m-d');
        }

        return $entry;
    }

    private function latestModelTimestamp(string $modelClass): ?DateTimeInterface
    {
        return $modelClass::where('status', 1)->latest('updated_at')->value('updated_at');
    }
}
