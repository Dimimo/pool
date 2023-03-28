@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Edit the players of the team <strong>{{ $team->name }}</strong></h3>
        </div>
        <div class="card-body">
            <div class="box-rounded-grey">
                <h4><i class="fa-solid fa-user-plus dark-green"></i> Add a new player</h4>
                {!! Form($new) !!}
            </div>
            <br/>
            @foreach ($forms as $form)
                <div class="box-rounded-white">
                    {!! Form($form) !!}
                    <div class="row">
                        <div class="offset-11 col-1 align-right">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['pool.player.delete', $form->getModel()->id], 'onsubmit' => 'javascript:return confirm("Are you sure you want to delete this player?");']) !!}
                            {!! Form::button('<i class="fa-solid fa-trash-can white"></i>', array('type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => "Delete this player " . $form->getModel()->name)) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <br/>
            @endforeach
        </div>
    </div>

@endsection
