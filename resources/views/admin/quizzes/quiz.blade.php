@extends('layouts.admin')

@section('main_content')

<section class="container-fluid" ng-controller="quizController" ng-init="quiz_id={{ $quiz->id }}">

    {{-- start quiz --}}
    <div id="screen-start" class="wrapper ng-cloak" ng-show="startScreen">
        <div class="heading">{{ $quiz->name }}</div>

        <div class="text-center">
            Connected Members: <span>@{{ connected_members }}</span>
        </div>

        <div class="footer text-center">
            <button class="btn btn-success" ng-click="startQuiz()">
                Démarrer le Quiz
            </button>
        </div>
    </div>

    {{-- timer --}}
    <div id="screen-timer" class="wrapper ng-cloak" ng-show="timerScreen">
        <h2 class="text-center" id="timer"></h2>
    </div>

    {{-- results --}}
    <div id="screen-result" class="wrapper ng-cloak" ng-show="resultScreen">
        <table class="table">
            <tr>
                <th>Nom & Prenom</th>
                <th>Resultat</th>
            </tr>
            <tr ng-repeat="result in results">
                <td>@{{ result.name }}</td>
                <td>@{{ result.score }}</td>
            </tr>
        </table>
    </div>

</section>

@endsection

@push('scripts')
<script src="{{ asset('angular/admin/services/quizService.js') }}"></script>
<script src="{{ asset('angular/admin/controllers/quizController.js') }}"></script>

@endpush