<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_event_index_only_shows_published_events(): void
    {
        $author = User::factory()->create();
        $this->createEvent('Published event', Status::EDIT_PUBLISHED, $author);
        $this->createEvent('Draft event', Status::EDIT_DRAFT, $author);

        $this->get(route('events'))
            ->assertOk()
            ->assertSee('Published event')
            ->assertDontSee('Draft event');
    }

    public function test_public_event_index_paginates_nine_items(): void
    {
        $author = User::factory()->create();

        foreach (range(1, 10) as $number) {
            $this->createEvent("Event {$number}", Status::EDIT_PUBLISHED, $author);
        }

        $this->get(route('events'))
            ->assertOk()
            ->assertViewHas('events', function ($events): bool {
                return $events->count() === 9
                    && $events->total() === 10
                    && $events->hasMorePages();
            });
    }

    public function test_unpublished_event_cannot_be_opened_publicly(): void
    {
        $event = $this->createEvent('Private event', Status::EDIT_DRAFT, User::factory()->create());

        $this->get(route('show_event', $event))->assertNotFound();
    }

    public function test_published_event_with_a_deleted_author_still_renders(): void
    {
        $author = User::factory()->create();
        $event = $this->createEvent('Orphaned published event', Status::EDIT_PUBLISHED, $author);
        $author->delete();

        $this->get(route('events'))
            ->assertOk()
            ->assertSee('Autor no disponible');

        $this->get(route('show_event', $event))
            ->assertOk()
            ->assertSee('Orphaned published event')
            ->assertSee('Autor no disponible');
    }

    private function createEvent(string $title, Status $status, User $author): Event
    {
        return Event::create([
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => 'Event description',
            'event_date' => now()->toDateString(),
            'location' => 'Madrid',
            'status' => $status,
            'user_id' => $author->id,
        ]);
    }
}
