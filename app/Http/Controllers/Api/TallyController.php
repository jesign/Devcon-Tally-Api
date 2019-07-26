<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Participant;
use App\ParticipantScore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TallyController extends Controller
{
    public function getScores(Request $request, Participant $participant){
        return response()->json($participant->scores);
    }

    public function tally(Request $request, Participant $participant){
        $scores = [];

        foreach($request->scores as $score){
            $scores[$score['criteria_id']] = [
                'score' => $score['score']
            ];
        }

        $participant->criteria()->sync($scores);
        return response()->json($participant->criteria);
    }
}
