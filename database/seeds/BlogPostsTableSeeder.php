<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $BlogCount = (int)$this->command->ask('How many BlogPosts would you like?', 20);
        $users = App\User::all();

        factory(App\BlogPost::class, $BlogCount)->make()->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
