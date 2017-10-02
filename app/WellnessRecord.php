<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $user
 */
class WellnessRecord extends Model
{
    protected $guarded = [];

    public function user(){

        return $this->belongsTo('App\User');

    }

    public function questions(){

        return $this->belongsToMany('App\WellnessQuestion', 'user_records')->withPivot('answer_key');;

    }

    public static function getAnswersForRecord($record){

        $answered = DB::table('user_records')
            ->where('wellness_record_id', $record['id'])
            //we'll retrieve the wellness question id and answer as a key-val pair
            ->pluck('answer_key', 'wellness_question_id')
            ->toArray();

        $data = [];

        //loop through the available questions and add user response to question object
        foreach (WellnessQuestion::all() as $q) {

            $q->answer = $answered[$q->id] ?? null;
            $data[] = $q->toArray();

        }

        return $data;

    }

    public static function storeAnswerForRecord($user, $question_id, $answer_key, $date){

        $record = $user->records()->where('date', $date)->first();

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
    }

}
