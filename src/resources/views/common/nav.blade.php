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
                @if (Auth::check())
                    <li class="nav-item dropdown navDropDown" id="inventoryDrop">
                        <a class="nav-link dropdown-toggle" id="shopNav" aria-haspopup="true" aria-expanded="false">
                            MY INVENTORY
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="shopNav">
                            <li>
                                <a href="{{ route('devices.index') }}" class="dropdown-item">Device List</a>
                            </li>
                            <li>
                                <a href="{{ route('devices.create') }}" class="dropdown-item">Add New Device</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown navDropDown" id="inventoryDrop">
                        <a class="nav-link dropdown-toggle" id="shopNav" aria-haspopup="true" aria-expanded="false">
                            LOCAL OBIT VIEWER
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="shopNav">
                            <li>
                                <a href="/obits" class="dropdown-item">Obit List</a>
                            </li>
                            <li>
                                <a href="/retrieve/obit" class="dropdown-item">Import From Blockchain</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"  aria-haspopup="true" aria-expanded="false">
                            Logout
                        </a>
                    </li>
                @else
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

