@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1 style="font-size: 45px">Wellness Questions {{\Carbon\Carbon::now()->toDateString()}}
                    </h1>
                </div>
                <record :patient-id="{{auth()->user()->id}}" :record="{{$record}}"></record>
            </div>
        </div>
    </div>
@endsection
