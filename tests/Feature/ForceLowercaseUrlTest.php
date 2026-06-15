<?php

namespace Tests\Feature;

use Tests\TestCase;

class ForceLowercaseUrlTest extends TestCase
{
    public function test_uppercase_public_path_redirects_with_301(): void
    {
        $response = $this->get('/About');

        $response->assertStatus(301);
        $response->assertRedirect('/about');
    }

    public function test_lowercase_path_is_not_redirected_by_middleware(): void
    {
        $response = $this->get('/about');

        $this->assertNotEquals(301, $response->status());
    }

    public function test_admin_paths_keep_original_casing(): void
    {
        $response = $this->get('/argon/Test-Path');

        $this->assertNotEquals(301, $response->getStatusCode());
    }
}
