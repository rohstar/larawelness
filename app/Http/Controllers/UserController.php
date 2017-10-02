<?php

namespace App\Http\Controllers;

use App\User;
use App\WellnessQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JavaScript;

class UserController extends Controller
{

    public function history($id){

        $user = User::find($id);

        //populate last 7 days as arrays
        $records = $user->getRecordsFromDate(Carbon::today()->subWeek()->toDateString());

        $hist = DB::table('user_records')
            ->whereIn('wellness_record_id', $records)
            ->get();

        $data = [];

        foreach ($hist as $record){

            $q = WellnessQuestion::find($record->wellness_question_id);

            $option = $record->answer_key;

            if(isset($data[$q->question][$q->$option])){

                $data[$q->question][$q->$option]++;

            } else {

                $data[$q->question][$q->$option] = 1;

            }

        }

        JavaScript::put([
            'data' => $data
        ]);

        return view('history');

    }

}
