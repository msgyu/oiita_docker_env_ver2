<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginView()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $this->assertGuest();
    }

    // public function testLogin()
    // {
    //     $user = factory(User::class)->create([
    //         'email' => 'taylor@laravel.com',
    //     ]);

    //     $this->browse(function ($browser) use ($user) {
    //         $browser->visit('/login')
    //             ->type('email', $user->email)
    //             ->type('password', 'password')
    //             ->press('Login')
    //             ->assertPathIs('/home');
    //     });
    // }

    // private function dummyLogin()
    // {
    //     $user = factory(User::class, 'default')->create();
    //     return $this->actingAs($user);
    // }
}
