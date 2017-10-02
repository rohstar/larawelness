@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h4 style="font-size: 30px">Wellness History (past week)
            </h4>
        </div>
        <history></history>
    </div>
@endsection
@include ('footer')
