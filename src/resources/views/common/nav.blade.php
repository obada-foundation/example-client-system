<nav class="navbar <?php echo $fixed?'navbar-color-on-scroll navbar-transparent fixed-top':'no-shadow' ?>  navbar-expand-lg mb-0" color-on-scroll="100" id="sectionsNav">
    <div class="container-fluid">
        <div class="navbar-translate">
            <a class="navbar-brand" href="/">
                <div>
                    <img src="https://public.tradeloopproto.com/img/tradeloop-logo.svg" alt="Tradeloop" height="20">
                    <span class="d-block text-center" style="top: 0;">Blockchain Demo Site</span>
                </div>
{{--                <p class="bold"><img alt="OBADA" src="/images/obada-logo.svg" width="112" height="35"> <small>Reference Design</small></p>--}}
{{--                <span>An inventory manager application</span>--}}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link"><small>Demo site:</small></span>
                </li>

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

