<body>
    <header>
        <div class="logo">
            <h1>Registrati<span class="logo-letter-o"><i class="fa-solid fa-o"></i></span>n <span class="logo-lower-part">F<span class="logo-letter-o"><i class="fa-solid fa-o"></i></span>rm</span></h1>
        </div>
        <nav>
            <ul>
                <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li class="{{ request()->is('register') ? 'active' : '' }}"><a href="{{ url('/register') }}">Register</a></li>
            </ul>
        </nav>
    </header>
</body>