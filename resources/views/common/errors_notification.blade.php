@if (session('success'))
    <div class="alert alert-success  alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa-solid fa-circle-check green"></span> {!! session('success') !!}
    </div>
    {{ session(['success' => null]) }}

@elseif (session('error'))
    <div class="alert alert-danger  alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa-solid fa-circle-exclamation red"></span> {!! session('error') !!}
    </div>
    {{ session(['error' => null]) }}

@elseif (session('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa-solid fa-circle-exclamation orange"></span> {!! session('warning') !!}
    </div>

@elseif (session('info'))
    <div class="alert alert-info alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa-solid fa-triangle-exclamation-triangle blue"></span> {!! session('info') !!}
    </div>
@endif
