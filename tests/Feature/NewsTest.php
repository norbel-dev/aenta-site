<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_news_index_only_shows_published_news(): void
    {
        $author = User::factory()->create();
        $this->createNews('Published headline', Status::EDIT_PUBLISHED, $author);
        $this->createNews('Draft headline', Status::EDIT_DRAFT, $author);

        $this->get(route('news'))
            ->assertOk()
            ->assertSee('Published headline')
            ->assertDontSee('Draft headline');
    }

    public function test_public_news_index_paginates_nine_items(): void
    {
        $author = User::factory()->create();

        foreach (range(1, 10) as $number) {
            $this->createNews("Headline {$number}", Status::EDIT_PUBLISHED, $author);
        }

        $this->get(route('news'))
            ->assertOk()
            ->assertViewHas('news', function ($news): bool {
                return $news->count() === 9
                    && $news->total() === 10
                    && $news->hasMorePages();
            });
    }

    public function test_unpublished_news_cannot_be_opened_publicly(): void
    {
        $news = $this->createNews('Private draft', Status::EDIT_DRAFT, User::factory()->create());

        $this->get(route('show_news', $news))->assertNotFound();
    }

    public function test_published_news_with_a_deleted_author_still_renders(): void
    {
        $author = User::factory()->create();
        $news = $this->createNews('Orphaned published news', Status::EDIT_PUBLISHED, $author);
        $author->delete();

        $this->get(route('news'))
            ->assertOk()
            ->assertSee('Autor no disponible');

        $this->get(route('show_news', $news))
            ->assertOk()
            ->assertSee('Orphaned published news')
            ->assertSee('Autor no disponible');
    }

    private function createNews(string $title, Status $status, User $author): News
    {
        return News::create([
            'title' => $title,
            'slug' => str($title)->slug(),
            'content' => 'News content',
            'status' => $status,
            'published_at' => now(),
            'user_id' => $author->id,
        ]);
    }
}
