<?php

namespace Tests\Unit;

use App\Enums\Status;
use App\Http\Controllers\HomeController;
use App\Models\News;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class NewsTest extends TestCase
{
    public function test_news_rejects_a_status_outside_the_status_enum(): void
    {
        $validator = Validator::make([
            'title' => 'A headline',
            'content' => 'News content',
            'status' => 999,
            'published_at' => '2026-10-05',
        ], News::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    public function test_news_accepts_a_status_from_the_status_enum(): void
    {
        $validator = Validator::make([
            'title' => 'A headline',
            'content' => 'News content',
            'status' => Status::EDIT_PUBLISHED->value,
            'published_at' => '2026-10-05',
        ], News::rules());

        $this->assertTrue($validator->passes());
    }

    public function test_unpublished_news_is_not_available_through_the_detail_action(): void
    {
        $news = new News(['status' => Status::EDIT_DRAFT]);

        $this->expectException(HttpException::class);

        (new HomeController())->show_news($news);
    }

    public function test_news_migration_compiles_status_enum_values_for_mysql(): void
    {
        $connection = new MySqlConnection(null, '', '', ['driver' => 'mysql']);
        $connection->useDefaultSchemaGrammar();
        $statements = [];

        Schema::shouldReceive('create')
            ->once()
            ->with('news', Mockery::on(function ($callback) use ($connection, &$statements): bool {
                $blueprint = new Blueprint($connection, 'news', function (Blueprint $table) use ($callback): void {
                    $table->create();
                    $callback($table);
                });
                $statements = $blueprint->toSql();

                return true;
            }));

        $migration = require database_path('migrations/2025_09_04_205641_create_news_table.php');
        $migration->up();

        $sql = implode(' ', $statements);
        $this->assertStringContainsString("enum('1', '2', '3', '4', '5')", $sql);
        $this->assertStringContainsString("default '1'", $sql);
    }
}
