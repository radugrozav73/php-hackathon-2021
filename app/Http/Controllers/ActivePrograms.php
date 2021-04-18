<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveProgrammes;
use App\Models\Programmes;
use Carbon\Carbon;

class ActivePrograms extends Controller
{
    public function index($cnp){
        $dbInstance = ActiveProgrammes::where('cnp', $cnp)->get();

        return response($dbInstance);
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'cnp'  => 'required|size:13',
        ]);

        $programmes = Programmes::where('id', $id)->with(['activeprograms'])->get();
        $programs = Programmes::with(['activeprograms'])->get();
        $open_spots = Programmes::select('max_attenders')->where('id', $id)->get();

        if(count($programmes) == 0){
            return response('Wrong plan id, it does not exist');
        }
        $date1 = Carbon::createFromFormat('Y-m-d', $programmes[0]->end_date);
        $date2 = Carbon::createFromFormat('Y-m-d', $programmes[0]->start_date);
        $roomInstances = $programmes[0]->activeprograms;

        
        if($date2->gt($date1)){
            return response('Start date greater than end date', 401);
        }

        foreach($programs as $program){
            foreach($roomInstances as $activities){
                if (($date1->gte($program->start_date) || $date1->lte($program->end_date)) && ($date2->gte($program->start_date) || $date2->lte($program->end_date)) && $request->cnp == $activities->cnp){
                    return response('Already registered in a differend activity', 401);
                }
            }
        }

        if($open_spots[0]->max_attenders === 0){
            return response('Sorry, the room is full', 401);
        }
        else{
            $open_spots[0]->max_attenders = $open_spots[0]->max_attenders - 1;
            Programmes::where('id', $id)->update(array('max_attenders'=> $open_spots[0]->max_attenders));
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

    public function destroy($id, $cnp)
    {
        $activeInstance = ActiveProgrammes::where('id', $id)->get();

        if($cnp === $activeInstance[0]->cnp){
            $activeInstance[0]->delete();
            return response('Application deleted');
        } else {
            return response('Wrong Numerical Code');
        }
    }
}
