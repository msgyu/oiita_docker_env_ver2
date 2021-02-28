<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['PHP', 'Laravel', 'Ruby', 'Ruby on Rails'];
        foreach ($tags as $tag) Tag::create(['name' => $tag]);
    }
}
