<div class="float-right my-4">
    @if (!$hasAccess)
        <div class="dropdown">
            <div class="btn-group dropup">
                <button class="btn btn-link dropdown-toggle" id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <span class="src-only"><em><i class="fa-solid fa-user-cog dark-grey"></i> Log in for admins</em></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-3" aria-labelledby="dropdownLogin" style="width: 350px; height: 405px;">
                    <div id="loadLogin"></div>
                </div>
            </div>
        </div>

        @push('js')
            <script src="{{ mix("/js/login.js") }}"></script>
        @endpush
    @else
        <em>Welcome {{ auth()->user()->name }}, you have administration access.</em>
        <a href="{{ route('pool.logout') }}">(<i class="fa-solid fa-right-from-bracket"></i> log out)</a>
    @endif
</div>
