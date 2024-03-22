<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $scheduled = now()->addMinutes(mt_rand(-4, 4));
        $published = now() >= $scheduled;


        for ($i = 0; $i < 4; $i++) {

            Post::create([
                'title' => $faker->name,
                'content' => $faker->text,
                'scheduled' => $scheduled,
                'published' => $published
            ]);
        }
    }
}
