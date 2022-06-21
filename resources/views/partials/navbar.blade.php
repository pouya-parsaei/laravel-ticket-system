<nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <a class="navbar-brand" href="#">
        @lang('public.register and login system')
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="auth-btn collapse justify-content-end navbar-collapse">

        @auth('web')
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}

                    </a>
                    <div class="dropdown-menu logout-btn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}">@lang('auth.logout')</a>
                    </div>
                </li>
            </ul>
        @endauth
        @auth('admin')
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ Auth::guard('admin')->user()->name }}

                    </a>
                    <div class="dropdown-menu logout-btn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">@lang('auth.logout')</a>
                    </div>
                </li>
            </ul>
        @endauth

        @guest('admin')
            <a class="btn btn-info  mr-2" href="{{ route('admin.login.form') }}">@lang('public.login')</a>
            <a class="btn btn-info mr-2" href="">@lang('public.register')</a>
        @endguest

    </div>
</nav>
