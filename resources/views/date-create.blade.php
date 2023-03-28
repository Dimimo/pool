@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Create a new playing date</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-8">
                    {!! Form($form) !!}
                </div>
                <div class="col-12 col-lg-4">
                    <div class="box-rounded-purple">
                        <h4>What's this?</h4>
                        <p>Here playing dates are created. This is necessary before we can create games.</p>
                        <p>
                            <strong>If it's a new season</strong>, you have to create it (only once, for example {{ date('Y/m') }}). The newest season is
                            automatically selected.
                        </p>
                        <p>
                            If you create a wrong date by accident,
                            <a href="{{ route('pool.dates.edit') }}">
                                you can delete it at <i>shift the playing dates</i>
                            </a>.
                            The calendar is build up by events, not dates.</p>
                        <p>
                            When creating a <strong>new season</strong>, a team selection page is shown <strong>once (!)</strong>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@include('pool::common.datepicker')
