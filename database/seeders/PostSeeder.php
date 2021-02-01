<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Provider\Lorem;
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
        Post::create([
            'user_id'=>1,
            'title'=>'Dummy Title',
            'desc'=>'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
        ]);
    }
}
