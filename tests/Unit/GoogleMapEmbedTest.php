<?php

namespace Tests\Unit;

use Tests\TestCase;

class GoogleMapEmbedTest extends TestCase
{
    public function test_accepts_embed_url_directly(): void
    {
        $url = 'https://www.google.com/maps/embed?pb=example';

        $this->assertSame($url, google_maps_embed_src_from_input($url));
    }

    public function test_extracts_src_from_iframe_html(): void
    {
        $input = '<iframe src="https://www.google.com/maps/embed?pb=example" width="600"></iframe>';

        $this->assertSame(
            'https://www.google.com/maps/embed?pb=example',
            google_maps_embed_src_from_input($input)
        );
    }

    public function test_rejects_non_google_map_input(): void
    {
        $this->assertNull(google_maps_embed_src_from_input('<iframe src="https://evil.test/map"></iframe>'));
    }

    public function test_parses_iframe_saved_with_escaped_quotes(): void
    {
        $input = '<iframe src=\\"https://www.google.com/maps/embed?pb=example\\" width=\\"100%\\"></iframe>';

        $this->assertSame(
            'https://www.google.com/maps/embed?pb=example',
            google_maps_embed_src_from_input($input)
        );
    }

    public function test_contact_page_renders_map_iframe(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('https://www.google.com/maps/embed', false);
        $response->assertSee('<iframe', false);
    }
}
