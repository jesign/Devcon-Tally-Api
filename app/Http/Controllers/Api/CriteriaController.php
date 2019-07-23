<?php

namespace App\Http\Controllers\Api;

use App\Criteria;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index(Request $request, Event $event)
    {
        return response()->json($event->criteria);
    }

    public function save(Request $request, Event $event)
    {
        if($request->id){
            $criteria = Criteria::findOrFail($request->id);
        } else {
            $criteria = new Criteria;
        }

        $criteria->fill($request->all());

        $event->criteria()->save($criteria);

        return response()->json($criteria);
    }


    public function destroy(Event $event, $id)
    {
        $criteria = Criteria::findOrFail($id);
        $success = $criteria->delete();

        return response()->json(compact('success'));
    }
}
