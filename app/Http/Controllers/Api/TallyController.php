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
        return response()->json($participant->scoreSummary());
    }

    public function getScoreFromJudge(Request $request, Participant $participant){
        $user = auth()->user();
        return $participant->scoreFromJudge($user);
    }

    public function tally(Request $request, Participant $participant){
        $scores = [];
        $userId  = auth()->user()->id;

        foreach($request->scores as $score){
            $scores[$score['criteria_id']] = [
                'score' => $score['score'],
                'user_id' => $userId
            ];
        }


        $participant->criteria()->wherePivot('user_id', $userId)->sync($scores);

        return response()->json($participant->scores);
    }
}
