<?php

namespace App\Http\Controllers\Api;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ParticipantScore;
use App\Criteria;
use App\Participant;

class ParticipantScoreController extends Controller
{
    public function index()
    {
        return ParticipantScore::all();
    }

    public function save(Request $request)
    {
        $data = $request->only('criteria_id', 'participant_id', 'score');

        $validator = \Validator::make($data, [
            'criteria_id' => 'required',
            'participant_id' => 'required',
            'score' => 'required',
        ]);

        $validator->validate();

        if (!$criteria = Criteria::find($data['criteria_id'])) {
            abort(404, 'Criteria not found');
        }
        
        if (!$participant = Participant::find($data['participant_id'])) {
            abort(404, 'Participant');
        }

        $user = \Auth::user();

        $participantScore = $user->participantScore()->where('criteria_id', $criteria->id)
            ->where('participant_id', $participant->id);
        
        if ($participantScore->count() > 0) {
            abort(409, 'Entry already exist');
        }

        $participantScore = $user->participantScore()->create($data);

        return response()->json([
            'participant_id' => $participantScore
        ], 201);
    }

    public function getParticipantsScore(Event $event)
    {
        return Participant::where('event_id', $event->id)->with('scores')->get();
    }
}
