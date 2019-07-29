<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Participant;
use App\ParticipantScore;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Passport;

class TallyController extends Controller
{
    public function getScores(Request $request, Participant $participant){
        return response()->json($participant->scores);
    }

    public function tally(Request $request, Participant $participant){
        $scores = [];

        foreach($request->scores as $score){
            $scores[$score['criteria_id']] = [
                'score' => $score['score'],
                'user_id' => auth()->user()->id
            ];
        }

        $participant->criteria()->sync($scores);

        return response()->json($participant->scores);
    }
}
