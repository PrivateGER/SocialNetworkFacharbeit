<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        //

        for($i = 0; $i < count(\App\User::all()); $i++) {
            $post = new \App\Post();
            $post->content = $faker->realText(300);
            $post->author_id = $i;
            $post->type = "text";
            $post->save();
        }
    }
}
