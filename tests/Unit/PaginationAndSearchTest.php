<?php

namespace Tests\Unit;

use App\Models\News;
use Tests\TestCase;

class PaginationAndSearchTest extends TestCase
{
    public function test_list_page_two_has_noindex_and_canonical_to_first_page(): void
    {
        $response = $this->get('/news?page=2');

        $response->assertStatus(200);
        $response->assertSee('name="robots" content="noindex, follow"', false);
        $this->assertMatchesRegularExpression(
            '/<link rel="canonical" href="[^"]+\/news">/',
            $response->getContent()
        );
        $response->assertDontSee('/news?page=2', false);
    }

    public function test_list_page_one_is_indexable(): void
    {
        $response = $this->get('/news');

        $response->assertStatus(200);
        $response->assertDontSee('name="robots" content="noindex, follow"', false);
    }

    public function test_search_page_is_noindex(): void
    {
        $response = $this->get('/search?q=test');

        $response->assertStatus(200);
        $response->assertSee('name="robots" content="noindex, follow"', false);
    }

    public function test_search_finds_matching_news_title(): void
    {
        $news = News::create([
            'name_ka' => 'უნიკალური Solar პროექტი',
            'name_en' => 'Unique Solar Project Launch',
            'slug_ka' => 'test-solar-ka-' . uniqid(),
            'slug_en' => 'unique-solar-project-' . uniqid(),
            'status' => 1,
            'content_ka' => '',
            'content_en' => '',
        ]);

        try {
            $response = $this->get('/search?q=Solar');

            $response->assertStatus(200);
            $response->assertSee('უნიკალური Solar პროექტი', false);
        } finally {
            $news->delete();
        }
    }
}
