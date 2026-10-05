<?php

namespace Tests\Unit;

use App\Enums\Status;
use App\Models\Event;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function test_event_rejects_a_status_outside_the_status_enum(): void
    {
        $validator = Validator::make([
            'title' => 'A gathering',
            'description' => 'Event details',
            'event_date' => '2026-10-05',
            'location' => 'Madrid',
            'status' => 999,
        ], Event::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    public function test_event_accepts_a_status_from_the_status_enum(): void
    {
        $validator = Validator::make([
            'title' => 'A gathering',
            'description' => 'Event details',
            'event_date' => '2026-10-05',
            'location' => 'Madrid',
            'status' => Status::EDIT_PUBLISHED->value,
        ], Event::rules());

        $this->assertTrue($validator->passes());
    }

    public function test_event_migration_defines_valid_status_enum_values(): void
    {
        $connection = new MySqlConnection(null, '', '', ['driver' => 'mysql']);
        $connection->useDefaultSchemaGrammar();
        $statusColumn = null;

        Schema::shouldReceive('create')
            ->once()
            ->with('events', Mockery::on(function ($callback) use ($connection, &$statusColumn): bool {
                $blueprint = new Blueprint($connection, 'events', function (Blueprint $table) use ($callback): void {
                    $table->create();
                    $callback($table);
                });
                $statusColumn = collect($blueprint->getColumns())
                    ->first(fn ($column): bool => $column->name === 'status');

                return true;
            }));

        $migration = require database_path('migrations/2025_09_04_205641_create_events_table.php');
        $migration->up();

        $this->assertNotNull($statusColumn);
        $this->assertSame(['1', '2', '3', '4', '5'], $statusColumn->allowed);
        $this->assertSame('1', $statusColumn->default);
    }
}
