<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function save(Request $request)
    {
        if($request->id){
            $event = Event::findOrFail($request->id);
        } else {
            $event = new Event;
        }

        $event->fill($request->all());
        $event->save();
        return response()->json($event);
    }

    public function participantsScores(Event $event){
        $participants = $event->participants()->with('scores.criteria')->get();

        foreach($participants as $participant){
            $overAllScore = $participant->overAllScore();
            $participant->totalScore = $overAllScore['overall'];
        }

        return $participants->sortByDesc("totalScore");
    }

    public function assignJudges(Request $request, Event $event){
        $judgeIds = $request->judge_ids;

        $event->users()->syncWithoutDetaching($judgeIds);
        return $event->judges()->get();
    }

    public function removeJudge(Request $request, Event $event){
        $event->users()->detach($request->id);
        return $event->judges()->get();
    }

    public function destroy(Event $event)
    {
        $success = $event->delete();
        return response()->json(compact('success'));
    }
}
