<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programmes;
use Carbon\Carbon;
use App\Models\User;

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
        $roomInstances = Programmes::select('start_date', 'end_date')->where('room_name', $request->room_name)->get();
        if($date2->gt($date1)){
            return response('Start date greater than end date', 401);
        }

        foreach($roomInstances as $instances){
            if(($date1 >= $instances->start_date && $date1 <= $instances->end_date) || ($date2 >= $instances->start_date && $date2 <= $instances->end_date)){
                $nrOfOccurences++;
                if($nrOfOccurences >= 1){
                    return response("Room is busy between $request->start_date and $request->end_date, please try some other time :)", 401);
                }
            }
        }

        $request->user()->programmes()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'room_name' => $request->room_name,
        ]);

        return response('Program created', 200);
    }

    public function show($id, Request $request)
    {
        $response = $request->user()->programmes->where('id', $id);
        return response($response);
    }

    public function update(Request $request, $id)
    {
        $users = User::with('programmes')->get();

        $date1 = Carbon::createFromFormat('Y-m-d', $request->end_date);
        $date2 = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $planToUpdate = Programmes::where('id', $id)->get();

        if($date2->gt($date1)){
            return response('Start date greater than end date', 401);
        }

        foreach($users as $user){
            foreach($user->programmes as $programs){
                if (($date1 >= $programs->start_date && $date1 <= $programs->end_date) || ($date2 >= $programs->start_date && $date2 <= $programs->end_date)){
                    return response('Room unavailable between ' .$date1. ' and ' .$date2, 401);
                }
            }
        }

        if($request->user()->id === $planToUpdate[0]->user_id){
            $request->user()->programmes()->where('id', $id)->update([
                'start_date' => $request->start_date,
                'end_date'=>$request->end_date,
                'room_name'=>$request->room_name
            ]);
            return response("Plan Sccesfully updated", 200);
        } else {
            return response("You are not allowed to update or delete someone else plan.", 401);
        }
    }

    public function destroy($id, Request $request)
    {
        $program = Programmes::where('id', $id)->get();

        if(count($program) === 0){
            return response('No such program or it might belong to a different admin', 401);
        } else {
            $program[0]->delete();
            return response('Deleted', 200);
        }
        
    }
}