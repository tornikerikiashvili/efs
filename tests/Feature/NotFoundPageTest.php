<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotFoundPageTest extends TestCase
{
    public function test_missing_page_returns_custom_404(): void
    {
        $response = $this->get('/this-page-does-not-exist');

        $response->assertStatus(404);
        $response->assertSee('404', false);
        $response->assertSee(__('other.error_404_home'), false);
        $response->assertSee('/images/Logo-', false);
        $response->assertSee('href="'.url('/').'"', false);
    }
}
