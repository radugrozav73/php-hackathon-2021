<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programmes;
use Carbon\Carbon;

class ProgrammesController extends Controller
{

    public function index(Request $request)
    {
        $programmes = $request->user()->programmes;

        return response($programmes);
    }

    public function store(Request $request){
        $this->validate($request, [
            'start_date'=>'required',
            'end_date'=>'required',
            'room_name'=>'required|max:255',
        ]);

        $nrOfOccurences = 0;
        $date1 = Carbon::createFromFormat('Y-m-d', $request->end_date);
        $date2 = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $roomInstances = $request->user()->programmes->where('room_name', $request->room_name);
        if($date2->gt($date1)){
            return response('Start date greater than end date');
        }

        for($i = 0; $i< count($roomInstances); $i++){
            if(($date1 >= $roomInstances[$i]->start_date && $date1 <= $roomInstances[$i]->end_date) || ($date2 >= $roomInstances[$i]->start_date && $date2 <= $roomInstances[$i]->end_date)){
                $nrOfOccurences++;
            }
        }

        if($nrOfOccurences >= 1){
            return response("Room is busy between $request->start_date and $request->end_date, please try some other time :)");
        }

        $request->user()->programmes()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'room_name' => $request->room_name,
        ]);

        return response('program creat');
    }

    public function show($id, Request $request)
    {
        $response = $request->user()->programmes->where('id', $id);
        return response($response);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        $request->user()->programmes()->where('id', $id)->delete();

        return response('done');
    }
}