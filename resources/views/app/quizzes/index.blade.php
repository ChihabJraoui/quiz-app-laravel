@extends('layouts.app')


@push('angular_script')
<script src="{{ asset('angular/app/services/QuizzesService.js') }}"></script>
<script src="{{ asset('angular/app/controllers/QuizzesController.js') }}"></script>
@endpush


@section('content')

<main class="app-content" ng-controller="QuizzesController">
    <div class="container-fluid">

        <div class="text-center" ng-hide="quizzes.length">
            <h2 class="text-muted">No Quiz has been found</h2>
        </div>

        <div class="row ng-cloak" ng-show="quizzes.length">

            <div class="col-md-4" ng-repeat="quiz in quizzes">
                <a href="/quizzes/@{{ quiz.slug }}">
                    <div class="wrapper">
                        <div class="heading">@{{ quiz.name }}</div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</main>

@endsection