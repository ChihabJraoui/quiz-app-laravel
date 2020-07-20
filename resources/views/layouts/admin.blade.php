<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Quiz App</title>

	<meta charset="UTF-8" />
	<meta name="description" content="" />
	<meta name="copyright" content="" />
	<meta name="author" content="Chihab Jraoui" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,400|Raleway:200,400,600|Lobster"
          rel="stylesheet">
	<link href="{{ asset('vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/jBox.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body ng-app="adminApp" ng-controller="mainController">

{{-- header --}}
<header class="admin-header">

    {{-- Button toggle SideBar --}}
    <button id="btn-toggle-sidebar" class="btn-toggle" type="button" ng-click="toggleNav = true">
        <i class="material-icons">menu</i>
    </button>

    {{-- items --}}
    <ul class="items">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown">
                <img src="{{ Auth::user()->getPicture() }}" height="40" width="40" class="img-circle">
                {{ Auth::user()->getFullname() }}
                <i class="material-icons">arrow_drop_down</i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li>
                    <a href="javascript:" onclick="$('#formLogout').submit()">Se Deconnecter</a>
                    <form action="/logout" method="post" id="formLogout">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</header>

{{-- navigation --}}
<nav id="navigation" class="sidebar" ng-class="{'is-open': toggleNav}">

    {{-- brand --}}
    <div id="brand" class="brand">
        <a href="{{ route('admin.dashboard') }}">QuizUp</a>
    </div>

    {{-- sidebar menu --}}
    <ul class="menu">
        <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">Tableau de Bord</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'admin.quizzes.index' ? 'active' : '' }}">
            <a href="{{ route('admin.quizzes.index') }}">Quizzes</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'admin.subjects.index' ? 'active' : '' }}">
            <a href="{{ route('admin.subjects.index') }}">Matières</a>
        </li>
    </ul>

</nav>

{{-- overlay --}}
<div class="admin-overlay" ng-click="toggleNav = false" ng-class="{'is-open': toggleNav}"></div>

{{-- Content --}}
<main class="admin-content">
    @yield('main_content')
</main>

{{-- Footer --}}
<footer class="admin-footer">
    <div class="container-fluid">

        <div class="copyright">
            <span>
                &copy; {{ date('Y') }} All Rights Reserved.
            </span>
        </div>

    </div>
</footer>

{{-- Scripts --}}
<script src="https://use.fontawesome.com/2670d45d53.js"></script>
<script src="{{ asset('lib/jquery.1.11.2.min.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.4/angular-material.min.js"></script>

<script src="{{ asset('vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jBox.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('angular/admin/controllers/mainController.js') }}"></script>
@stack('scripts')

</body>
</html>