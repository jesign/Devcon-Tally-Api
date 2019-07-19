<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::all();
        return response()->json($participants);
    }

    public function save(Request $request)
    {
        if($request->id){
            $participant = Participant::findOrFail($request->id);
        } else {
            $participant = new Participant;
        }

        $participant->fill($request->all());
        $participant->save();
        return $participant;
    }


    public function destroy($id)
    {
        $participant = Participant::findOrFail($id);
        return $participant->delete();
    }
}
