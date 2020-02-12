<?php

use App\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker\Factory::create();
    	$posts = Post::all();

    	foreach ($posts as $post) {
    		for($i = 0; $i < random_int(2, 8); $i++) {
				$newComment = new \App\Comment();
				$newComment->parent_post = $post->id;
				$newComment->author_id = random_int(1, 99);
				$newComment->content = $faker->text(240);
				$newComment->save();
			}
		}
    }
}
