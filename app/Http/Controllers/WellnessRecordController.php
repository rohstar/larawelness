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

            $data[$q->id]['info'] = $q;

            if(isset($answered[$q->id])){
                $data[$q->id]['answer'] = $answered[$q->id];
                $data[$q->id]['answer'] = $answered[$q->id];
            } else {
                $data[$q->id]['answer'] = null;

            }

        }

        //returns all questions for the day and whether they were answered.
        return $data;

    }

    public function create(Request $request){

        $user =  User::find($request->input('user_id'));
        $date = Carbon::now()->toDateString();

        $answer_key = $request->input('answer_key');
        $question_id = $request->input('question_id');

        //determine if a daily record exists
        $record = $user->records()->where('date', $date)->first();

        if($record->exists()){

            //determine if question has been answered for today's record
            $user_answer = $record->questions()
                ->where('wellness_question_id', $question_id)->first();

            if($user_answer == null){

                //if not, make a many to many column on user_records
                $record->questions()->attach($question_id, ['answer_key' => $answer_key]);
                dd();

            } else {

                $user_answer->pivot->answer_key = $answer_key;
                $user_answer->pivot->save();

            };


        } else {

            $record = WellnessRecord::create([

                'user_id' => $user->id,
                'date' => $date

            ]);

        };



    }

}
