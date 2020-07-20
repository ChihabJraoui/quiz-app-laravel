@extends('layouts.admin')

@section('main_content')

<section class="container-fluid" ng-controller="QuestionsController" ng-init="id={{ $subject->id }}">

    {{-- toolbar --}}
    <div class="toolbar">
        <div class="back">
            <a href="{{ URL::previous() }}">
                <i class="material-icons">arrow_back</i>
            </a>
        </div>
        <div class="heading">
            <h1>Questions</h1>
        </div>
        <ul class="items">
            <li>
                <button class="btn btn-success" ng-click="showQuestionModal(null)">
                    <i class="material-icons md-24">add</i>
                    Ajouter Une Question
                </button>
            </li>
        </ul>
    </div>

    <div class="text-center" ng-hide="!loading">
        <span class="fa fa-spinner fa-2x fa-spin"></span>
    </div>

    {{-- data --}}
    <div class="ng-cloak" ng-show="!loading">

        <div class="wrapper" ng-repeat="question in subject.questions">
            <div class="heading">
                <h4><strong>@{{ question.question }}</strong></h4>
                <ul class="items">
                    <li>
                        <a href="javascript:" class="pull-right"
                           ng-click="showAnswerModal(null, question.id)">
                            <i class="material-icons">add</i>
                            Ajouter une reponse
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown"><i class="material-icons">more_vert</i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="javascript:" ng-click="showQuestionModal(question)">
                                    <i class="material-icons">edit</i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:" ng-click="deleteSubject(question.id)">
                                    <i class="material-icons">clear</i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <table class="table">
                    {{-- answers --}}
                    <tr ng-repeat="answer in question.answers">
                        <td>@{{ answer.answer }}</td>
                        <td class="text-right">
                            <a href="javascript:" ng-click="showAnswerModal(answer, null)">
                                <i class="material-icons md-24">edit</i>
                            </a>
                            &nbsp;
                            <a href="javascript:" ng-click="deleteAnswer(answer)">
                                <i class="material-icons md-24">clear</i>
                            </a>
                        </td>
                    </tr>
                    <tr ng-if="!question.answers.length">
                        <td class="text-center text-muted">
                            Aucune reponse a été trouver.
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    {{-- Question Modal --}}
    <div id="question-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">@{{ questionFormTitle }}</h4>
                </div>
                <div class="modal-body">
                    <form name="frmQuestion" novalidate>
                        <div class="form-group">
                            <label for="txt-question">Question</label>
                            <input type="text" id="txt-question" name="question" class="form-control"
                                   value="@{{ questionData.question }}"
                                   ng-model="questionData.question" ng-required="true">
                            <span class="text-danger"
                                  ng-show="frmQuestion.question.$invalid && frmSubject.question.$touched">
                            Ce champ est obligatoir.
                        </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"
                            ng-disabled="frmQuestion.$invalid"
                            ng-click="submitQuestion()">
                        Save changes
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Answer Modal --}}
    <div id="answer-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">@{{ answerFormTitle }}</h4>
                </div>
                <div class="modal-body">
                    <form name="frmAnswer" novalidate>
                        <div class="form-group">
                            <label for="txt-answer">Reponse</label>
                            <input type="text" id="txt-answer" name="answer" class="form-control"
                                   value="@{{ selectedAnswer.answer }}" ng-model="selectedAnswer.answer"
                                   ng-required="true">
                            <span class="text-danger"
                                  ng-show="frmAnswer.answer.$invalid && frmAnswer.answer.$touched">
                                Ce champ est obligatoir.
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Correct</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"
                            ng-disabled="frmAnswer.$invalid"
                            ng-click="submitAnswer(type, id)">
                        Save changes
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</section>

@endsection

@push('scripts')
<script src="{{ asset('angular/admin/services/AnswersService.js') }}"></script>
<script src="{{ asset('angular/admin/services/QuestionsService.js') }}"></script>
<script src="{{ asset('angular/admin/controllers/QuestionsController.js') }}"></script>

@endpush