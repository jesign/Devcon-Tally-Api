<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::all();
        return response()->json($participants);
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
}
