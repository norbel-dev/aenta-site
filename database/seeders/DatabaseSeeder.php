<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Article;
use App\Models\Center;
use App\Models\Event;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
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

        $superadmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $publisher = Role::create(['name' => 'publisher']);
        $guest = Role::create(['name' => 'guest']);

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
        Permission::create(['name' => 'admin.users.create'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'admin.users.destroy'])->syncRoles([$superadmin, $admin]);

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
        News::create([
            'title' => 'Company launches new product line',
            'content' => 'We are proud to announce the release of our new eco-friendly products.',
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(2),
        ]);

        News::create([
            'title' => 'Partnership with global brand',
            'content' => 'Our company has partnered with a global leader to expand our reach.',
            'status' => Status::EDIT_DRAFT,
        ]);

        News::create([
            'title' => 'Award for best innovation',
            'content' => 'We received recognition at the National Innovation Awards.',
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(5),
        ]);
    }

    function CreateEvents(){
        Event::create([
            'title' => 'Annual Science Conference',
            'description' => 'A three-day event covering the latest in scientific research.',
            'event_date' => Carbon::now()->addDays(10),
            'event_date_end' => Carbon::now()->addDays(12),
            'location' => 'New York Convention Center',
            'status' => Status::EDIT_PUBLISHED,
        ]);

        Event::create([
            'title' => 'Tech Innovation Meetup',
            'description' => 'One-day meetup to showcase innovative tech solutions.',
            'event_date' => Carbon::now()->addDays(20),
            'location' => 'San Francisco Tech Hub',
            'status' => Status::EDIT_DRAFT,
        ]);

        Event::create([
            'title' => 'Health Awareness Workshop',
            'description' => 'Interactive workshop focusing on mental and physical health.',
            'event_date' => Carbon::now()->subDays(5),
            'location' => 'Online',
            'status' => Status::EDIT_CANCELLED,
        ]);
    }

    function CreateArticles(){
        Article::create([
            'title' => 'Climate Change and Renewable Energy',
            'abstract' => 'Exploring how renewable energy can help mitigate climate change.',
            'content' => 'Full scientific content goes here...',
            'author' => 'Dr. John Smith',
            'status' => Status::EDIT_PUBLISHED,
            'published_at' => Carbon::now()->subDays(3),
        ]);

        Article::create([
            'title' => 'Artificial Intelligence in Healthcare',
            'abstract' => 'AI is transforming diagnostics and patient care.',
            'content' => 'Full article body with references...',
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
