<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
