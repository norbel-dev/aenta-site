<?php

namespace Tests\Unit;

use App\Enums\Status;
use App\Models\Header;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Tests\TestCase;

class HeaderTest extends TestCase
{
    public function test_header_rejects_a_status_outside_the_status_enum(): void
    {
        $validator = Validator::make([
            'title' => 'A carousel header',
            'content' => 'Header content',
            'status' => 999,
            'published_at' => '2026-10-05',
        ], Header::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    public function test_header_accepts_a_status_from_the_status_enum(): void
    {
        $validator = Validator::make([
            'title' => 'A carousel header',
            'content' => 'Header content',
            'status' => Status::EDIT_PUBLISHED->value,
            'published_at' => '2026-10-05',
        ], Header::rules());

        $this->assertTrue($validator->passes());
    }

    public function test_header_migration_defines_valid_status_enum_values(): void
    {
        $connection = new MySqlConnection(null, '', '', ['driver' => 'mysql']);
        $connection->useDefaultSchemaGrammar();
        $statusColumn = null;

        Schema::shouldReceive('create')
            ->once()
            ->with('headers', Mockery::on(function ($callback) use ($connection, &$statusColumn): bool {
                $blueprint = new Blueprint($connection, 'headers', function (Blueprint $table) use ($callback): void {
                    $table->create();
                    $callback($table);
                });
                $statusColumn = collect($blueprint->getColumns())
                    ->first(fn ($column): bool => $column->name === 'status');

                return true;
            }));

        $migration = require database_path('migrations/2025_09_25_044405_create_headers_table.php');
        $migration->up();

        $this->assertNotNull($statusColumn);
        $this->assertSame(['1', '2', '3', '4', '5'], $statusColumn->allowed);
        $this->assertSame('1', $statusColumn->default);
    }

    public function test_header_image_migration_makes_the_column_nullable(): void
    {
        $connection = new MySqlConnection(null, '', '', ['driver' => 'mysql']);
        $connection->useDefaultSchemaGrammar();
        $imageColumn = null;

        Schema::shouldReceive('table')
            ->once()
            ->with('headers', Mockery::on(function ($callback) use ($connection, &$imageColumn): bool {
                $blueprint = new Blueprint($connection, 'headers', function (Blueprint $table) use ($callback): void {
                    $callback($table);
                });
                $imageColumn = collect($blueprint->getColumns())
                    ->first(fn ($column): bool => $column->name === 'image');

                return true;
            }));

        $migration = require database_path('migrations/2026_10_05_194936_make_image_nullable_on_headers_table.php');
        $migration->up();

        $this->assertNotNull($imageColumn);
        $this->assertTrue($imageColumn->nullable);
        $this->assertTrue($imageColumn->change);
    }
}
