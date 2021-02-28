<?php

use Illuminate\Database\Seeder;
use App\Models\Post_tag;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post_tag::class, 200)->create();
    }
}
