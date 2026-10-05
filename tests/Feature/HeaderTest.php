<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Header;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_header_index_only_shows_published_headers(): void
    {
        $author = User::factory()->create();
        $this->createHeader('Published header', Status::EDIT_PUBLISHED, $author);
        $this->createHeader('Draft header', Status::EDIT_DRAFT, $author);

        $this->get(route('headers'))
            ->assertOk()
            ->assertSee('Published header')
            ->assertDontSee('Draft header');
    }

    public function test_public_header_index_paginates_nine_items(): void
    {
        $author = User::factory()->create();

        foreach (range(1, 10) as $number) {
            $this->createHeader("Header {$number}", Status::EDIT_PUBLISHED, $author);
        }

        $this->get(route('headers'))
            ->assertOk()
            ->assertViewHas('headers', function ($headers): bool {
                return $headers->count() === 9
                    && $headers->total() === 10
                    && $headers->hasMorePages();
            });
    }

    public function test_unpublished_header_cannot_be_opened_publicly(): void
    {
        $header = $this->createHeader('Private header', Status::EDIT_DRAFT, User::factory()->create());

        $this->get(route('show_header', $header))->assertNotFound();
    }

    public function test_landing_carousel_only_contains_published_headers(): void
    {
        $author = User::factory()->create();
        $this->createHeader('Carousel header', Status::EDIT_PUBLISHED, $author);
        $this->createHeader('Hidden carousel header', Status::EDIT_DRAFT, $author);

        $this->get(route('index'))
            ->assertOk()
            ->assertSee('Carousel header')
            ->assertDontSee('Hidden carousel header');
    }

    public function test_published_header_with_a_deleted_author_still_renders(): void
    {
        $author = User::factory()->create();
        $header = $this->createHeader('Orphaned published header', Status::EDIT_PUBLISHED, $author);
        $author->delete();

        $this->get(route('headers'))
            ->assertOk()
            ->assertSee('Autor no disponible');

        $this->get(route('show_header', $header))
            ->assertOk()
            ->assertSee('Orphaned published header')
            ->assertSee('Autor no disponible');
    }

    private function createHeader(string $title, Status $status, User $author): Header
    {
        return Header::create([
            'title' => $title,
            'slug' => str($title)->slug(),
            'content' => 'Header content',
            'status' => $status,
            'published_at' => now(),
            'user_id' => $author->id,
        ]);
    }
}
