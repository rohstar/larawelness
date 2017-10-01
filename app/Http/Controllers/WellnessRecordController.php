<?php

namespace App\Http\Controllers;

use App\User;
use App\WellnessQuestion;
use App\WellnessRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WellnessRecordController extends Controller
{

    public function show($id){

        $record = User::find($id)->records()->where('date', Carbon::now()->toDateString())->first()['id'];

        $answered = DB::table('user_records')->where('wellness_record_id', $record)->pluck('answer_key','wellness_question_id')->toArray();

        $data = [];

        foreach (WellnessQuestion::all() as $q){

            $data[$q->id]['question'] = $q;

            if(isset($answered[$q->id])){
                $data[$q->id]['answer'] = $answered[$q->id];
            } else {
                $data[$q->id]['answer'] = null;

            }

        }

        //returns all questions for the day and whether they were answered.
        return $data;

    }

}
