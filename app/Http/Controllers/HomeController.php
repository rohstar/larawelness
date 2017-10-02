<?php

namespace App\Http\Controllers;

use App\WellnessRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $record = auth()->user()
            ->records()
            ->where('date', Carbon::now()->toDateString())
            ->first();

        if($record == null){

            $record = WellnessRecord::create([

                'user_id' => auth()->user()->id,
                'date' => Carbon::now()->toDateString()

            ]);

        }

        return view('home', ['record' => $record]);

    }
}
