@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Update the playing dates
                <br/><span class="smaller-80 light-grey">Season {{ $date->cycle }}</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="box-rounded-info">
                <p>
                    <strong>Hint:</strong> please make sure, if you move a series of dates (due to a typhoon for example) <strong>start with the latest date
                        first!</strong>
                </p>
                <p>Duplicates are not allowed. If you make a mistake, it will ignore your request and give a warning.</p>
            </div>
            <div class="m-3">
                @foreach ($forms as $form)
                    {!! Form($form) !!}
                @endforeach
            </div>
        </div>
    </div>

@endsection

@include('pool::common.datepicker')
