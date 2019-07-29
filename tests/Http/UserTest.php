<?php

namespace Tests\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    use WithFaker;
    
    protected $faker;

    public function setUp() : void
    {
        parent::setUp();
        
        $this->faker = $this->makeFaker();
        
    }

    public function test_validation_fails()
    {
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'desc' => $this->faker->sentence(3), 
        ];

        $response = $this->json('POST', '/api/register/', $data);
        
        unset($data['password']);

        $response->assertStatus(422); 
    }

    public function test_register_succeeded()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'name' => $this->faker->name,
            'role' => 'judge', // judge, admin
            'desc' => $this->faker->sentence(3), 
        ];

        $response = $this->json('POST', '/api/register/', $data);
        
        unset($data['password']);

        $response->assertJsonFragment($data);

        $response->assertStatus(201); 
    }

    public function test_logout()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);

        Passport::actingAs($user);

        $user->generateToken();

        $response = $this->json('POST', '/api/logout/');
        
        $response->assertStatus(200); 
    }
}
