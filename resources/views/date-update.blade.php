@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Update the playing date <strong>{{ $date->date }}</strong></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-8">
                    {!! Form($form) !!}
                </div>
                <div class="col-12 col-lg-4">
                    <div class="box-rounded-purple">
                        <h4>What's this?</h4>
                        <p>Here playing dates can be updated.</p>
                        <p><strong>If you have to shift a range of dates, please start with the last date (furthest in the future) because you can't create
                                double dates.</strong></p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@include('pool::common.datepicker')
