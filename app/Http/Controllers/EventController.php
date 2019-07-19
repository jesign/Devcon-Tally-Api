<?php

namespace App\Http\Controllers;

use App\Event;
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
        return $event;
    }


    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        return $event->delete();
    }
}
