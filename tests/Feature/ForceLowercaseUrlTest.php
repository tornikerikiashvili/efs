<?php

namespace Tests\Feature;

use Tests\TestCase;

class ForceLowercaseUrlTest extends TestCase
{
    public function test_uppercase_public_path_redirects_with_301(): void
    {
        $response = $this->get('/Ka/Services/Test-Slug');

        $response->assertStatus(301);
        $response->assertRedirect('/ka/services/test-slug');
    }

    public function test_lowercase_path_is_not_redirected_by_middleware(): void
    {
        $response = $this->get('/ka/services');

        $this->assertNotEquals(301, $response->getStatusCode());
    }

    public function test_admin_paths_keep_original_casing(): void
    {
        $response = $this->get('/argon/Test-Path');

        $this->assertNotEquals(301, $response->getStatusCode());
    }
}
