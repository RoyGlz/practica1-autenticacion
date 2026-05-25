<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $this->call(RoleSeeder::class);

        // Crear usuario admin
        $admin = \App\Models\User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole);

        // Crear 10 usuarios con rol editor
        $users = \App\Models\User::factory(10)->create();
        $editorRole = \App\Models\Role::where('name', 'editor')->first();
        $users->random(5)->each(function ($user) use ($editorRole) {
            $user->roles()->attach($editorRole);
        });

        // Crear categorías y tags
        $categories = \App\Models\Category::factory(5)->create();
        $tags = \App\Models\Tag::factory(10)->create();

        // Crear 50 posts con comentarios y tags
        \App\Models\Post::factory(50)
            ->create([
                'user_id'     => $users->random()->id,
                'category_id' => $categories->random()->id,
            ])
            ->each(function ($post) use ($tags) {
                // Tags aleatorios
                $post->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );

                // 5 comentarios por post
                \App\Models\Comment::factory(5)->create([
                    'post_id' => $post->id,
                    'user_id' => \App\Models\User::inRandomOrder()->first()->id,
                ]);
            });
    }
}