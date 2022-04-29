<nav class="navbar navbar-expand-md navbar-light shadow-sm samazon-header-container">
    <a class="navbar-brand" href="{{ url('/dashboard') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
    <!-- Right Side Of Navbar -->
    @auth
    <ul class="navbar-nav ml-auto mr-5 mt-2">
        <li class="nav-item mr-5">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-user mr-1"> ログアウト</i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
    @endguest
</nav> 