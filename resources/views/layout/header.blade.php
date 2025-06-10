<body>
    <header>
        <div class="logo">
            <h1>Registrati<span class="logo-letter-o"><i class="fa-solid fa-o"></i></span>n <span class="logo-lower-part">F<span class="logo-letter-o"><i class="fa-solid fa-o"></i></span>rm</span></h1>
        </div>
        <div class="lang">
            <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active-lang' : '' }}">EN</a>
            <a href="{{ route('language.switch', 'ar') }}" class="{{ app()->getLocale() == 'ar' ? 'active-lang' : '' }}">AR</a>
        </div>
        <nav>
            <ul>
                <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">@lang('messages.home')</a></li>
                <li><a href="#">@lang('messages.services')</a></li>
                <li><a href="#">@lang('messages.about')</a></li>
                <li><a href="#">@lang('messages.contact')</a></li>
                <li class="{{ request()->is('register') ? 'active' : '' }}"><a href="{{ url('/register') }}">@lang('messages.register')</a></li>
            </ul>
        </nav>
    </header>
</body>