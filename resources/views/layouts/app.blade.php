<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'PBBG Topsite') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ $title ?? config('app.name', 'PBBG Topsite') }}
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#mainNav" aria-controls="mainNav"
                                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="mainNav">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else

                                    @if(Auth::user()->isAdmin())
                                        <li class="nav-item">
                                            <a class="nav-link"
                                               href="{{ route('admin.home') }}">{{ __('Administration') }}</a>
                                        </li>
                                    @endif

                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{ route('front.game.create') }}">{{ __('Submit Game') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{ route('front.game.index') }}">{{ __('Manage Games') }}</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('account.index') }}">
                                                {{ __('Control Panel') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest


                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('front.contact') }}">{{ __('Contact') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(($hide_sidebar ?? false) === false)<div class="col-sm-12 col-lg-3 py-4">
                <div class="card">
                    <div class="card-body">
                        <nav class="nav flex-column navbar-expand-lg nav-category navbar-light text-left">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#categoryNav" aria-controls="categoryNav"
                                    aria-expanded="false" aria-label="{{ __('Toggle categories') }}">
                                <span class="navbar-toggler-icon"></span> Categories
                            </button>
                            <div class="collapse navbar-collapse flex-column" id="categoryNav">
                                @foreach($categories as $category)
                                    <a href="{{ route('front.category.show', $category->slug) }}" class="nav-link w-100 @if($category->slug === ($currentCategory->slug ?? '')) active @endif">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            @endif
            <div class="@if(($hide_sidebar ?? false) === false) col-12 col-lg-9 @else col-12 @endif">
                <main class="py-4">
                    @if(auth()->user())
                        @if(!auth()->user()->email_verified_at && request()->route()->getName() !== 'verification.notice')
                            <div class="alert alert-danger">
                                <a href="{{ route('verification.notice') }}">Your account has not been activated yet,
                                    you cannot add any listings or comment/rate until this is done, click here to
                                    verify.</a>
                            </div>
                        @endif
                    @endif
                    @include('flash::message')
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/helpers.js') }}"></script>
@yield('javascript')
@stack('scripts')
</body>
</html>
