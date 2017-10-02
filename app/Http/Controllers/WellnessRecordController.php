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

    public function show($userId, $wellnessRecordId, $date)
    {

        $wellness_record = WellnessRecord::find($wellnessRecordId);

        //Get the wellness record for user on date
        $record = User::find($wellness_record->user_id)
            ->records()
            ->where('date', $date)
            ->first();

        //get all the answered questions for today
        $answered = DB::table('user_records')
            ->where('wellness_record_id', $record['id'])
            //we'll retrieve the wellness question id and answer as a key-val pair
            ->pluck('answer_key', 'wellness_question_id')
            ->toArray();

        //packet init
        $data = [];

        //loop through the available questions and add user response to question object
        foreach (WellnessQuestion::all() as $q) {

            $q->answer = $answered[$q->id] ?? null;
            $data[] = $q->toArray();

        }

        //returns all questions and user's answers, if any
        return $data;

    }

    public function store(Request $request)
    {

        //assign input to variables
        $user = User::find($request->input('user_id'));

        $date = Carbon::now()->toDateString();

        //get user's record object for today
        $record = $user->records()->where('date', $date)->first();

        $question_id = $request->input('question_id');
        $answer_key = $request->input('answer_key');

        //if a daily record exists...
        if ($record == null) {

            $record = WellnessRecord::create([

                'user_id' => $user->id,
                'date' => $date

            ]);

            $record->questions()->attach($question_id, ['answer_key' => $answer_key]);


            $record->save();

            return [
                'success' => true
            ];


        }

        //if a daily record doesn't exist:

        //get today's answer for this question
        $user_answer = $record->questions()
            ->where('wellness_question_id', $question_id)
            ->first();

        //if it wasn't answered...
        if ($user_answer == null) {

            //make a many to many column on user_records
            $record->questions()
                ->attach($question_id, ['answer_key' => $answer_key]);

        } else {

            //change the answer
            $user_answer->pivot->answer_key = $answer_key;
            $user_answer->pivot->save();

        };

        return [
            'success' => true
        ];


    }

    public function destroy($userId, $wellnessRecordId, $questionId){

        DB::table('user_records')
            ->where('wellness_question_id', $questionId)
            ->where('wellness_record_id', $wellnessRecordId)
            ->delete();

        return [
            'success' => true
        ];

    }

    public function history($id, $question_id){

        //populate last 7 days as arrays
        $records = User::find($id)
            ->records()
            ->where('date', '>', Carbon::now()->subDays(7))
            ->pluck('id');

        $hist = DB::table('user_records')
            ->whereIn('wellness_record_id', $records)
            ->where('wellness_question_id', $question_id)
            ->pluck('answer_key')
            ->toArray();

        $counts = array_count_values($hist);

        $data = [

            'option_1' => $counts['option_1'] ?? 0,
            'option_2' => $counts['option_2'] ?? 0,
            'option_3' => $counts['option_3'] ?? 0,
            'option_4' => $counts['option_4'] ?? 0

        ];

        return [

            'question_keys'=> array_keys($data),
            'answer_values'=> array_values($data)

        ];

    }


}
