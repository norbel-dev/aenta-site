<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Article;
use App\Models\Center;
use App\Models\Event;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $superadmin = Role::where('name', 'super_admin')->get()[0];
        // User::find(1)->roles()->sync($superadmin);
        // return;

        $superadmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web', 'description' => 'Super Administrator']);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web', 'description' => 'Administrator']);
        $publisher = Role::create(['name' => 'publisher', 'guard_name' => 'web', 'description' => 'Publisher']);
        $guest = Role::create(['name' => 'guest', 'guard_name' => 'web', 'description' => 'Guest']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$superadmin, $admin, $publisher, $guest]);
        Permission::create(['name' => 'publications'])->syncRoles([$superadmin, $admin, $publisher, $guest]);
        Permission::create(['name' => 'advanced'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.articles'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.articles.create'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.articles.edit'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.articles.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.events'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.events.create'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.events.edit'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.events.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.news'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.news.create'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.news.edit'])->syncRoles([$superadmin, $admin, $publisher]);
        Permission::create(['name' => 'admin.news.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.centers'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.centers.create'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.centers.edit'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.centers.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.users'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.register'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.users.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.convocatories'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.convocatories.create'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.convocatories.edit'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.convocatories.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.headers'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.headers.create'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.headers.edit'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.headers.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.links'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.links.create'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.links.edit'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.links.destroy'])->syncRoles([$superadmin, $admin]);

        Permission::create(['name' => 'admin.logs'])->syncRoles([$superadmin]);
        Permission::create(['name' => 'admin.logs.destroy'])->syncRoles([$superadmin]);

        Permission::create(['name' => 'admin.log_access'])->syncRoles([$superadmin]);
        Permission::create(['name' => 'admin.log_access.destroy'])->syncRoles([$superadmin]);
        User::create([
            'name' => 'Norbel González Peña',
            'email' => 'norbelkots@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('L0tt3ry34*Aent@Site'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        User::create([
            'name' => 'Invitado',
            'email' => 'norbel@aenta.cu',
            'email_verified_at' => now(),
            'password' => bcrypt('L0tt3ry34*Aent@Site'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        User::find(1)->roles()->sync($superadmin);
        User::find(2)->roles()->sync($guest);

        $this->CreateArticles();
        $this->CreateCenters();
        $this->CreateEvents();
        $this->CreateNews();
    }

    function CreateNews(){
        $fact = Factory::create();
        $title1 = $fact->sentence();
        $title2 = $fact->sentence();
        $title3 = $fact->sentence();
        News::create([
            'title' => $title1,
            'slug' => Str::slug($title1),
            'content' => $fact->paragraphs(3, true),
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(2),
        ]);

        News::create([
            'title' => $title2,
            'slug' => Str::slug($title2),
            'content' => $fact->paragraphs(3, true),
            'status' => Status::EDIT_DRAFT,
        ]);

        News::create([
            'title' => $title3,
            'slug' => Str::slug($title3),
            'content' => $fact->paragraphs(3, true),
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(5),
        ]);
    }

    function CreateEvents(){
        $fact = Factory::create();
        $title1 = $fact->sentence();
        $title2 = $fact->sentence();
        $title3 = $fact->sentence();
        Event::create([
            'title' => $title1,
            'slug' => Str::slug($title1),
            'description' => $fact->paragraphs(3, true),
            'event_date' => Carbon::now()->addDays(10),
            'event_date_end' => Carbon::now()->addDays(12),
            'location' => 'New York Convention Center',
            'status' => Status::EDIT_PUBLISHED,
        ]);

        Event::create([
            'title' => $title2,
            'slug' => Str::slug($title2),
            'description' => $fact->paragraphs(3, true),
            'event_date' => Carbon::now()->addDays(20),
            'location' => 'San Francisco Tech Hub',
            'status' => Status::EDIT_DRAFT,
        ]);

        Event::create([
            'title' => $title3,
            'slug' => Str::slug($title3),
            'description' => $fact->paragraphs(3, true),
            'event_date' => Carbon::now()->subDays(5),
            'location' => 'Online',
            'status' => Status::EDIT_CANCELLED,
        ]);
    }

    function CreateArticles(){
        $fact = Factory::create();
        $title1 = $fact->sentence();
        $title3 = $fact->sentence();
        Article::create([
            'title' => $title1,
            'slug' => Str::slug($title1),
            'abstract' => $fact->paragraph(),
            'content' => $fact->paragraphs(3, true),
            'author' => 'Dr. John Smith',
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(3),
        ]);

        Article::create([
            'title' => $title3,
            'slug' => Str::slug($title3),
            'abstract' => $fact->paragraph(),
            'content' => $fact->paragraphs(3, true),
            'author' => 'Dr. Jane Doe',
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(7),
        ]);
    }

    function CreateCenters(){
        Center::create([
            'name' => 'Agencia de Energía Nuclear y Tecnologías de Avanzada',
            'mission' => 'To innovate for a sustainable future.',
            'vision' => 'To be a global leader in technology and science solutions.',
            'contact' => 'info@techscience.com',
            'address' => 'Playa, La Habana, Cuba',
        ]);
    }
}
