@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Hello, {{auth()->user()->name}}</div>
                <div class="panel-body">
                    <record :patient-id="{{auth()->user()->id}}"></record>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
