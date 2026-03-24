<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(15)->create();
        }

        $users->each(function (User $user) {
            Post::factory(rand(3, 7))->create(['user_id' => $user->id]);
        });
    }
}
