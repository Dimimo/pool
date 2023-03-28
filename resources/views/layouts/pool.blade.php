<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=3.0, user-scalable=yes">
    <meta name="author" content="Dimitri Mostrey (www.puertoparrot.com)">
    <meta name="copyright" content="&copy; &reg; {{ date("Y") }} Puerto Parrot Community Services">
    <meta name="description" content="Puerto Galera Pool League">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/roboto.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/fontawesome-all.min.css') }}">

    @stack('css')

    <link rel="apple-touch-icon" sizes="57x57" href="{{ Storage::disk('static')->url('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ Storage::disk('static')->url('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ Storage::disk('static')->url('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Storage::disk('static')->url('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ Storage::disk('static')->url('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ Storage::disk('static')->url('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ Storage::disk('static')->url('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ Storage::disk('static')->url('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::disk('static')->url('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ Storage::disk('static')->url('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ Storage::disk('static')->url('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ Storage::disk('static')->url('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ Storage::disk('static')->url('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ui" content="{{ encrypt(Auth::id()) }}">
    <meta name="robots" content="noindex,nofollow">

    <title>Puerto Galera Pool League</title>

</head>

<body>

<div class="container">

    <div class="row">
        <div class="col-12 align-center">
            <img src="{{ Storage::disk('static')->url('img/pg-pool-league-202210.jpg') }}" width="100%" alt="Pool League logo">
            @if (isset($cycles) && count($cycles) > 1)
                <div class="row mr-1 mt-n5 mb-4">
                    <div class="col-8 offset-4 offset-md-9 col-md-3 offset-lg-10 col-lg-2 align-right">
                        <label for="cycle_list"></label>
                        <select class="form-control mt-n4" id="cycle_list" title="Change the season">
                            @foreach ($cycles as $c)
                                <option value="{{ route('pool.cycle', [$c]) }}" @if ($c == $cycle) selected @endif>{{ $c }}</option>
                            @endforeach
                            @if ($c > $cycle)
                                <option value="{{ route('pool.cycle', [$c]) }}" selected>{{ $cycle }}</option>
                            @endif
                            <option value="{{ route('pool.cycle', ['0000/00']) }}">All Seasons</option>
                        </select>
                    </div>
                </div>
            @endif
            <div class="row p-2">
                <div class="col-12 col-lg-4 align-center">
                    <div class="box-rounded-grey bigger-140">
                        <a href="{{ route('pool.index') }}"><i class="fa-solid fa-list-ol blue smaller-80"></i> ##Competition Results</a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 align-center">
                    <div class="box-rounded-grey bigger-140">
                        <a href="{{ route('pool.calendar') }}"><i class="fa-solid fa-clipboard-list blue smaller-80"></i> Games Schedule</a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 align-center">
                    <div class="box-rounded-grey bigger-140">
                        <a href="{{ route('pool.teams') }}"><i class="fa-solid fa-users blue smaller-80"></i> Participating Teams</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    @if (session('success') || session('error') || session('warning') || session('info'))
        @include('pool::common.errors_notification')
    @endif

</div>
{{-- End navbar --}}

{{-- Start container --}}

<div class="container">

    @if(isset($errors) && count($errors) > 0)
        @include('pool::common.errors')
    @endif

    {{-- Start content --}}
    @yield('content')
    {{-- End content --}}

    @include('pool::_footer-admin')

    @include('pool::disclaimer')

    @include('pool::login')
</div>
<div id="snackbar" class="bg-success black"></div>

{{-- End container --}}

{{-- Start script --}}
<script src="{{ mix("/js/jquery.min.js") }}"></script>
<script src="{{ mix("/js/bootstrap.js") }}" defer></script>

@stack('js')

<script>
    const cycle_list = document.getElementById('cycle_list');
    cycle_list.addEventListener('change', (e) => {
        document.location.href = e.target.value;
    });
</script>
{{-- End script --}}

</body>
</html>
