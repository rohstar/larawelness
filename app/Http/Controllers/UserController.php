<?php

namespace App\Http\Controllers;

use App\User;
use App\WellnessRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function history($id){

        $user = User::find($id);

        //populate last 7 days as arrays
        $records = $user->getRecordsFromDate(Carbon::today()->subWeek()->toDateString());

        $hist = DB::table('user_records')
            ->whereIn('wellness_record_id', $records)
            ->get();

        dd($hist);

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
