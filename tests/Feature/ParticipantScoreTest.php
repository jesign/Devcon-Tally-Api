<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use App\User;
use App\Participant;
use App\Criteria;
use App\ParticipantScore;

class ParticipantScoreTest extends TestCase
{
    use WithFaker;

    protected $faker;

    public function setUp() : void
    {
        parent::setUp();

        $this->faker = $this->makeFaker();

        $user = create(User::class);

        Passport::actingAs($user);
    }

    public function test_get_unauthenticated()
    {
        $response = $this->json('GET','/api/participant-scores/');

        $response->assertStatus(401);
    }

    public function test_register_validation_fails()
    {
        $user = create(User::class);

        Passport::actingAs($user);

        $token = $user->generateToken();

        $response = $this->withHeaders([
            "Authorization" => "Bearer ".$token,
        ])->json('POST','api/participant-scores/');

        $response->assertStatus(422);
    }

    public function test_register_validation_fails_criteria_not_found()
    {
        $user = create(User::class);
        $participant = create(Participant::class);

        Passport::actingAs($user);

        $token = $user->generateToken();

        $data = [
            'participant_id' => $participant->id,
            'criteria_id' => 35,
            'score' => 9,
        ];

        $response = $this->withHeaders([
            "Authorization" => "Bearer ".$token,
        ])->json('POST','api/participant-scores/', $data);

        $response->assertStatus(404);
    }

    public function test_register_validation_fails_participant_not_found()
    {
        $criteria = create(Criteria::class);
        $user = create(User::class);

        Passport::actingAs($user);

        $token = $user->generateToken();

        $data = [
            'participant_id' => 24,
            'criteria_id' => $criteria->id,
            'score' => 9,
        ];

        $response = $this->withHeaders([
            "Authorization" => "Bearer ".$token,
        ])->json('POST','api/participant-scores/', $data);

        $response->assertStatus(404);
    }

    public function test_register_duplicate_entry()
    {
        $user = create(User::class);

        Passport::actingAs($user);

        $token = $user->generateToken();

        $participant = create(Participant::class);
        $criteria = create(Criteria::class);

        $participantScore = create(ParticipantScore::class, [
            'participant_id' => $participant->id,
            'criteria_id' => $criteria->id,
            'score' => 49,
            'user_id' => $user->id,
        ]);

        $data = [
            'participant_id' =>  $participantScore,
            'criteria_id' => $criteria->id,
            'score' => 49,
        ];

        $response = $this->withHeaders([
            "Authorization" => "Bearer ".$token,
        ])->json('POST','api/participant-scores/', $data);

        $response->dump()->assertStatus(409);
    }

    public function test_register_succeeded()
    {
        $user = create(User::class);
        $participant = create(Participant::class);
        $criteria = create(Criteria::class);

        Passport::actingAs($user);

        $token = $user->generateToken();

        $data = [
            'participant_id' => $participant->id,
            'criteria_id' => $criteria->id,
            'score' => 9,
        ];

        $response = $this->withHeaders([
            "Authorization" => "Bearer ".$token,
        ])->json('POST','api/participant-scores/', $data);

        $response->assertJsonFragment($data);
        $response->assertStatus(201);
    }
}
