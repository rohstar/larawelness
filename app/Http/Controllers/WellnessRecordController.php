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

        //get all the answered questions
        $data = WellnessRecord::getAnswersForRecord($record);

        //returns all questions and user's answers, if any
        return $data;

    }

    public function store(Request $request)
    {

        //assign input to variables
        $user = User::find($request->input('user_id'));

        $date = Carbon::now()->toDateString();

        $question_id = $request->input('question_id');
        $answer_key = $request->input('answer_key');

        WellnessRecord::storeAnswerForRecord($user, $question_id, $answer_key, $date);

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


}
