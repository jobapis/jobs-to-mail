<nav class="navbar navbar-light bg-faded">
    <div class="nav navbar-nav">
        @if (session('user'))
            <a class="nav-item nav-link" href="/">
                <img src="/img/logo.png" width="24" height="24" alt="Home">
            </a>
            <a class="nav-item nav-link" href="/searches" name="Searches">
                Your Searches
            </a>
            <a class="nav-item nav-link" href="/logout" name="Logout">
                Logout
            </a>
        @else
        <a class="nav-item nav-link" href="/" name="Home">
            <img src="/img/logo.png" width="24" height="24" alt="Home">
        </a>
        <a class="nav-item nav-link" href="/login" name="Login">
            Login
        </a>
        @endif
    </div>
</nav>
