<?php

namespace Tests\Unit;

use Tests\TestCase;

class SeoHeadTagsTest extends TestCase
{
    public function test_html_lang_attribute_values(): void
    {
        $this->assertSame('ka', html_lang_attribute('ka'));
        $this->assertSame('en-GE', html_lang_attribute('en'));
    }

    public function test_localized_url_structure_without_ka_prefix_for_georgian(): void
    {
        $this->assertStringEndsWith('/about', localized_url('ka', '/about'));
        $this->assertStringContainsString('/en/about', localized_url('en', '/about'));
        $this->assertStringNotContainsString('/ka/', localized_url('ka', '/about'));
    }

    public function test_georgian_about_page_includes_canonical_hreflang_and_lang(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('<html lang="ka">', false);
        $this->assertMatchesRegularExpression(
            '/<link rel="canonical" href="[^"]+\/about">/',
            $response->getContent()
        );
        $this->assertMatchesRegularExpression(
            '/<link rel="alternate" hreflang="ka" href="[^"]+\/about">/',
            $response->getContent()
        );
        $this->assertMatchesRegularExpression(
            '/<link rel="alternate" hreflang="en" href="[^"]+\/en\/about">/',
            $response->getContent()
        );
        $this->assertMatchesRegularExpression(
            '/<link rel="alternate" hreflang="x-default" href="[^"]+\/about">/',
            $response->getContent()
        );
        $response->assertDontSee('/ka/about', false);
    }

    public function test_ka_prefixed_url_redirects_to_unprefixed_georgian_url(): void
    {
        $response = $this->get('/ka/about');

        $response->assertStatus(301);
        $response->assertRedirect('/about');
    }

    public function test_page_does_not_include_noindex_robots_meta(): void
    {
        $response = $this->get('/about');

        $response->assertDontSee('name="robots" content="noindex"', false);
    }
}
