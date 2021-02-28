<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => "test",
            'email' => "test@test",
            'email_verified_at' => now(),
            'password' => bcrypt("test1234"),
            'remember_token' => "test12345"
        ]);
        factory(User::class, 100)->create();
    }
}
