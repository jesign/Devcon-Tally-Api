<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Participant;
use App\User;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request, Event $event)
    {
        return response()->json($event->participants);
    }

    public function save(Request $request, Event $event)
    {
        if($request->id){
            $participant = Participant::findOrFail($request->id);
        } else {
            $participant = new Participant;
        }

        $participant->fill($request->all());

        $event->participants()->save($participant);

        return response()->json($participant);
    }


    public function destroy(Event $event, $id)
    {
        $participant = Participant::findOrFail($id);
        $success = $participant->delete();

        return response()->json(compact('success'));
    }

    public function getScoreFromJudge(Request $request, Participant $participant, User $user){
        return $participant->scoreFromJudge($user);
    }

    public function getScores(Request $request, Participant $participant){
        return response()->json($participant->scoreSummary());
    }
}
