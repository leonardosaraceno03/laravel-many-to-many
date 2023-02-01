<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++){
            $new_post = new Post();
            $new_post->title = $faker->words(5, true);
            $new_post->body = $faker->words(50, true);
            $new_post->save();
        }
    }
}
