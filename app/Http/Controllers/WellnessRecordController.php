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

        //Get the wellness record for user with $id on today's date
        $record = User::find($id)
            ->records()
            ->where('date', Carbon::now()->toDateString())
            ->first();

        //get all the answered questions for today
        $answered = DB::table('user_records')
            ->where('wellness_record_id', $record['id'])
            //we'll retrieve the wellness question id and answer as a key-val pair
            ->pluck('answer_key','wellness_question_id')
            ->toArray();

        //packet init
        $data = [];

        //loop through the available questions and add user response to question object
        foreach (WellnessQuestion::all() as $q){

            $q->answer = $answered[$q->id] ?? null;
            $data[] = $q->toArray();

        }

        //returns all questions and user's answers, if any
        return $data;

    }

    public function create(Request $request){

        $user =  User::find($request->input('user_id'));
        $date = Carbon::now()->toDateString();

        $answer_key = $request->input('answer_key');
        $question_id = $request->input('question_id');

        //determine if a daily record exists
        $record = $user->records()->where('date', $date)->first();

        if($record != null){

            //determine if question has been answered for today's record
            $user_answer = $record->questions()
                ->where('wellness_question_id', $question_id)->first();

            if($user_answer == null){

                //if not, make a many to many column on user_records
                $record->questions()->attach($question_id, ['answer_key' => $answer_key]);

            } else {

                $user_answer->pivot->answer_key = $answer_key;
                $user_answer->pivot->save();

            };


        } else {

            $record = WellnessRecord::create([

                'user_id' => $user->id,
                'date' => $date

            ]);

            $record->questions()->attach($question_id, ['answer_key' => $answer_key]);


            $record->save();
        };



    }

}
