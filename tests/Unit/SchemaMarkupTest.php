<?php

namespace Tests\Unit;

use App\Services\SchemaMarkup;
use Tests\TestCase;

class SchemaMarkupTest extends TestCase
{
    public function test_homepage_graph_includes_website_and_organization(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<script type="application/ld+json">', false);
        $response->assertSee('"@type":"WebSite"', false);
        $response->assertSee('"@type":"Organization"', false);
        $response->assertSee('"@type":"WebPage"', false);
        $response->assertSee('"@type":"BreadcrumbList"', false);
    }

    public function test_about_page_graph_includes_about_page_and_organization(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('"@type":"AboutPage"', false);
        $response->assertSee('"@type":"Organization"', false);
    }

    public function test_services_page_graph_includes_service_nodes(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('"@type":"Service"', false);
    }

    public function test_contact_page_graph_includes_contact_page(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('"@type":"ContactPage"', false);
    }

    public function test_schema_uses_graph_structure(): void
    {
        $this->get('/about');

        $json = app(SchemaMarkup::class)->toJson();
        $decoded = json_decode((string) $json, true);

        $this->assertSame('https://schema.org', $decoded['@context']);
        $this->assertIsArray($decoded['@graph']);
        $this->assertNotEmpty($decoded['@graph']);
    }
}
