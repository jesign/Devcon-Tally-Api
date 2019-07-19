<?php

namespace App\Http\Controllers\Api;

use App\Criteria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::all();
        return response()->json($criteria);
    }

    public function save(Request $request)
    {
        if($request->id){
            $criterion = Criteria::findOrFail($request->id);
        } else {
            $criterion = new Criteria;
        }

        $criterion->fill($request->all());
        $criterion->save();
        return $criterion;
    }


    public function destroy($id)
    {
        $criterion = Criteria::findOrFail($id);
        return $criterion->delete();
    }
}
