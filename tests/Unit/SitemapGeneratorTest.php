<?php

namespace Tests\Unit;

use App\Services\SitemapGenerator;
use Tests\TestCase;

class SitemapGeneratorTest extends TestCase
{
    public function test_xml_matches_sitemap_protocol_structure(): void
    {
        $xml = (new SitemapGenerator())->toXml();

        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $this->assertStringContainsString(
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
            $xml
        );
        $this->assertStringContainsString('<loc>', $xml);
        $this->assertStringContainsString('<changefreq>', $xml);
        $this->assertStringContainsString('<priority>', $xml);
    }

    public function test_includes_static_pages_and_content_models(): void
    {
        $urls = collect((new SitemapGenerator())->urls())->pluck('loc')->all();
        $combined = implode("\n", $urls);

        $this->assertStringContainsString(route('homepagefront', [], false), $combined);
        $this->assertStringContainsString(route('projects', [], false), $combined);
        $this->assertStringContainsString(route('services', [], false), $combined);
        $this->assertStringContainsString(route('news', [], false), $combined);
        $this->assertStringContainsString(route('blog', [], false), $combined);
    }
}
