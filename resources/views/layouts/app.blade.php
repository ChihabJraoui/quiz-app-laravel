<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Quiz App</title>

	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="copyright" content="">
	<meta name="author" content="Chihab Jraoui">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:200,400|Lato:100,400|Arizonia"
          rel="stylesheet">
	<link href="{{ asset('vendor/bootstrap.4.0.0.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
	<script src="{{ asset('angular/app/angular.js') }}"></script>
	@stack('angular_script')
</head>
<body ng-app="App">

@if(Auth::check())

{{-- header --}}
<header class="app-header">

    {{-- toggle menu button--}}
    <button class="btn-nav-toggle">
        <i class="material-icons">menu</i>
    </button>

    <ul class="items">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Auth::user()->getPicture() }}" class="rounded-circle mr-md-2"
                     height="40" width="40" alt="profile photo">
                <span class="hidden-xs">{{ Auth::user()->getFullname() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:" onclick="frmLogout.submit()">
                    Se Deconnecter
                </a>
                <form action="/logout" method="POST" name="frmLogout">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>

</header>

{{-- navigation --}}
<nav class="nav" id="navigation">
    {{-- Logo --}}
    <div class="brand">
        <a href="{{ route('app.dashboard') }}">QuizUp</a>
    </div>

    <ul class="nav-menu">
        <li class="{{ Route::CurrentRouteName() == 'app.dashboard' ? 'active' : '' }}">
            <a href="{{ route('app.dashboard') }}">Accueil</a>
        </li>
        <li class="{{ Route::CurrentRouteName() == 'app.quizzes' ? 'active' : '' }}">
            <a href="{{ route('app.quizzes') }}">Quizzes</a>
        </li>
        <li class="{{ Route::CurrentRouteName() == 'app.histories' ? 'active' : '' }}">
            <a href="{{ route('app.histories') }}">Mes Resultats</a>
        </li>
    </ul>
</nav>

<div class="cover" id="cover"></div>
@endif

{{-- App Content --}}
@yield('content')

{{-- Main Footer --}}
<footer class="layout-footer">
    <div class="container-fluid">

        <div class="copyright">
            &copy; QuizUp {{ date('Y') }}. All Rights Reserved.
        </div>

    </div>
</footer>

<script src="https://use.fontawesome.com/2670d45d53.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('vendor/tether.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap.4.0.0.min.js') }}"></script>
<script src="{{ asset('vendor/jBox.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>