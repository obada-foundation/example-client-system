<nav class="navbar <?php echo $fixed?'navbar-color-on-scroll navbar-transparent fixed-top':'' ?>  navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container-lg">
        <a class="navbar-brand" href="/">
            <div>
                <img src="{{ config('frontend.logo_path') }}" alt="Tradeloop" height="20">
                <span class="d-block" style="top: 0;">{{ config('frontend.logo_text') }}</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div id="navbarNav" class="collapse navbar-collapse">
            <ul class="navbar-nav">

                @if (!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login.index') }}">Login</a>
                    </li>
                    @if (config('settings.enable_registration'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.index') }}">Register</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

