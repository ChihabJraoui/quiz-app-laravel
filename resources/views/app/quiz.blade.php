@extends('layouts.app')

@section('app_content')

<main id="quiz-app" class="app-content -middle" ng-controller="quizController"
      ng-init="id={{ $quiz->id }}">

    {{-- Wait Screen --}}
    <section id="screen-wait" class="container-fluid ng-cloak" ng-show="showWaitScreen">
        <h3 class="text-center text-muted">Veuillez Patienter</h3>
        <div class="loader">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40px"
                 xmlns:xlink="http://www.w3.org/1999/xlink" height="40px" viewBox="0 0 40 40"
                 enable-background="new 0 0 40 40" xml:space="preserve">
                <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,
                    8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,
                    28.455,5.169,20.201,5.169zM20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,
                    5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,
                    26.626,31.749,20.201,31.749z"></path>
                <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z">
                    <animateTransform attributeType="xml" attributeName="transform" type="rotate"
                                      from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite">
                    </animateTransform>
                </path>
            </svg>
        </div>
    </section>

    {{-- Quiz Screen --}}
    <section id="screen-quiz" class="container-fluid ng-cloak" ng-show="showQuizScreen">
        <div class="row">
            <div class="col-md-6 text-center">

                {{-- timer --}}
                <div class="quiz-timer-container">
                    <progress-bar id="quiz-timer" color="#ff5722" trail-color="#CCC" stock-width="4">
                        <label>@{{ countdown }}</label>
                    </progress-bar>
                </div>

                {{-- question --}}
                <h1 id="question">@{{ question }}</h1>

            </div>
            <div class="col-md-6">

                <h5>
                    <i class="fa fa-chevron-down"></i>&nbsp;
                    Choose the correct answer
                </h5>

                {{-- answers --}}
                <ul id="answers" class="list-answers">
                    <li ng-repeat="answer in answers">
                        <button type="button" id="btn-answer-@{{ answer.id }}"
                                class="btn btn-default btn-block"
                                ng-click="chooseAnswer(answer.id, answer.is_correct)">
                            @{{ answer.answer }}
                        </button>
                    </li>
                </ul>

            </div>
        </div>
    </section>

    {{-- Results Screen --}}
    <section id="screen-results" class="container-fluid ng-cloak" ng-show="showResultScreen">
        <div class="panel panel-info">
            <div class="panel-heading">Your Results</div>
            <div class="panel-body text-center">
                @{{ result }}
            </div>
        </div>
    </section>

    {{-- Error Screen --}}
    <section id="screen-error" class="container-fluid ng-cloak" ng-show="showErrorScreen">
        <h3 class="text-center text-danger">Le quiz a déjà commencé.</h3>
    </section>

</main>

@endsection

{{-- Script --}}
@push('scripts')
<script src="{{ asset('vendor/progressbar.min.js') }}"></script>
<script src="{{ asset('angular/app/services/quizService.js') }}"></script>
<script src="{{ asset('angular/app/controllers/quizController.js') }}"></script>
@endpush