<?php

use App\Post;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str as Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        for($i = 0; $i<20; $i++){
            $title = $faker->sentence;
            $content = $faker->text(3000);
            $slug = Str::slug($title);
            Post::create([
                'title' => $title,
                'content'  => $content,
                'slug'  => $slug,
            ]);
        }

    }
}
