<?php
/**
 * Created by PhpStorm.
 * User: jesign
 * Date: 7/23/19
 * Time: 8:08 PM
 */

namespace Tests\Http;


use App\Criteria;
use App\Participant;
use Tests\TestCase;

class TallyTest extends TestCase
{
    public function test_tally_on_a_participant()
    {
        $criteria1 = factory(Criteria::class)->create([
            'name' => 'Relevance',
            'max_points' => 20,
            'percentage' => 30
        ]);

        $criteria2 =factory(Criteria::class)->create([
            'name' => 'Creativity',
            'max_points' => 15,
            'percentage' => 40
        ]);

        $criteria3 =factory(Criteria::class)->create([
            'name' => 'Uniqueness',
            'max_points' => 20,
            'percentage' => 30
        ]);


        $data =[
            'scores' => [
                [
                    'criteria_id' => $criteria1->id,
                    'score' => 25
                ],
                [
                    'criteria_id' => $criteria2->id,
                    'score' => 35
                ],
                [
                    'criteria_id' => $criteria3->id,
                    'score' => 28
                ],
            ]
        ];


        $participant = factory(Participant::class)->create();

        $response = $this->json('POST', '/api/participants/' . $participant->id . '/tally', $data);

        $response->assertStatus(200);
    }

    public function test_participant_get_scores()
    {
        $participant = factory(Participant::class)->create();

        $response = $this->json('GET', '/api/participants/' . $participant->id . '/scores');
        $response->assertStatus(200)->dump();
    }
}