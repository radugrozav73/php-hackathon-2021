<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveProgrammes;
use App\Models\Programmes;
use Carbon\Carbon;

class ActivePrograms extends Controller
{

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'cnp'  => 'required|size:13',
        ]);

        $programmes = Programmes::where('id', $id)->with(['activeprograms'])->get();
        if(count($programmes) == 0){
            return response('Wrong plan id, it does not exist');
        }
        $date1 = Carbon::createFromFormat('Y-m-d', $programmes[0]->end_date);
        $date2 = Carbon::createFromFormat('Y-m-d', $programmes[0]->start_date);
        $roomInstances = $programmes[0]->activeprograms;

        // return response()->json([
        //     's' =>$programmes[0]->start_date,
        //     'e' =>$programmes[0]->end_date,
        //     's1' => $roomInstances[0]->start_date,
        //     's2' =>$roomInstances[0]->end_date,
        // ]);
        if($date2->gt($date1)){
            return response('Start date greater than end date');
        }
        if(count($roomInstances) == 0 ){
            1 == 1;
        }
        else if (($date1 >= $roomInstances[0]->start_date || $date1 <= $roomInstances[0]->end_date) && ($date2 >= $roomInstances[0]->start_date || $date2 <= $roomInstances[0]->end_date)){
            return response('Well Mate, you dont have time for that, you are already registered in a different room.');
        }
        ActiveProgrammes::create([
            'programmes_id' => $programmes[0]->id,
            'room_name' => $programmes[0]->room_name,
            'cnp' => $request->cnp,
            'start_date'=>$programmes[0]->start_date,
            'end_date'=>$programmes[0]->end_date,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'user_id'=> $programmes[0]->user_id
        ]);

        return response('Person Added to List');
    }

    public function destroy($id)
    {
        //
    }
}
