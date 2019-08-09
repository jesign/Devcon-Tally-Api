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
    public function getCurrentJudgeScore(Request $request, Participant $participant){
        $user = auth()->user();
        return $participant->scoreFromJudge($user);
    }

    public function tally(Request $request, Participant $participant){
        $scores = [];
        $user  = auth()->user();

        if($user->roles == 'admin'){
            return response()->json(['message' => 'Admin cannot tally'], 500);
        }

        foreach($request->scores as $score){
            $scores[$score['criteria_id']] = [
                'score' => $score['score'],
                'user_id' => $user->id
            ];
        }

        $participant->criteria()->wherePivot('user_id', $user->id)->sync($scores);

        return response()->json($participant->scores);
    }
}
