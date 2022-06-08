<nav class="navbar <?php echo $fixed?'navbar-color-on-scroll navbar-transparent fixed-top':'no-shadow' ?>  navbar-expand-lg " color-on-scroll="100" id="sectionsNav">
    <div class="container-fluid">
        <div class="navbar-translate">
            <a class="navbar-brand" href="/">
                <p class="bold"><img alt="OBADA" src="https://www.obada.io/assets/images/obada-logo.svg" width="112" height="35"> <small>Reference Design</small></p>
                <span>An inventory manager application</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav ml-auto">
                @if (!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login.index') }}" aria-haspopup="true" aria-expanded="false">
                            Login
                        </a>
                    </li>
                    @if (config('settings.enable_registration'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.index') }}" aria-haspopup="true" aria-expanded="false">
                                Register
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>

