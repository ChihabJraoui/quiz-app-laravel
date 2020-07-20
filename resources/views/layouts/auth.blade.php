<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>QuizUp</title>

	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="copyright" content="">
	<meta name="author" content="Chihab Jraoui" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,400|Raleway:200,400,600|Arizonia"
          rel="stylesheet">
	<link href="{{ asset('vendor/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

{{-- Auth Content --}}
@yield('auth_content')

{{-- Main Footer --}}
<footer class="layout-footer">
    <div class="container">

        <div class="copyright">
            &copy; QuizUp {{ date('Y') }}. All Rights Reserved.
        </div>

    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://use.fontawesome.com/2670d45d53.js"></script>
<script src="{{ asset('vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jBox.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')

</body>
</html>