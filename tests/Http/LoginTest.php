<?php

namespace Tests\Http;

use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    public function test_user_can_login()
    {
        $this->withExceptionHandling();
        
        $faker = \Faker\Factory::create();

        $user = create(User::class, [
            'email' => $faker->email,
            'password' => bcrypt($password = 'password') 
        ]);

        $response = $this->json('POST', '/api/login/', [
            'email' => $user->email,
            'password' => $password
        ]);
        
        $response->assertStatus(201);
    }
}