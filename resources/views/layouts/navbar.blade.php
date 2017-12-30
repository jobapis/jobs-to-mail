<nav class="navbar navbar-light navbar-expand bg-faded">
    <a class="navbar-brand" href="/">
        <img src="/img/logo.png" width="24" height="24" alt="Home">
    </a>
    <ul class="navbar-nav mr-auto">
    @if (session('user'))
        <li class="nav-item">
            <a class="nav-link" href="/searches" name="Searches">
                Your Searches
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout" name="Logout">
                Logout
            </a>
        </li>
    @else
    <li class="nav-item">
        <a class="nav-link" href="/login" name="Logout">
            Login
        </a>
    </li>
    @endif
    </ul>
</nav>
