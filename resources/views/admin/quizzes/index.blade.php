@extends('layouts.admin')

@section('main_content')

<section class="container-fluid" ng-controller="quizzesController">

    <div class="toolbar">
        <div class="heading">
            <h1>Quizzes</h1>
        </div>
        <ul class="items">
            <li>
                <button id="btn-add-subject" type="button" class="btn btn-default pull-right"
                        ng-click="showModal(0)">
                    <i class="material-icons">add</i>
                    <span>Ajouter un Quiz</span>
                </button>
            </li>
        </ul>
    </div>

    {{-- loading --}}
    <div class="text-center" ng-show="loading">
        <span class="fa fa-spinner fa-2x fa-spin"></span>
    </div>

    <div class="row" ng-show="!loading" ng-cloak>

        {{-- quiz --}}
        <div class="col-sm-6 col-md-3" ng-repeat="quiz in quizzes">
            <div class="card-quiz">
                <div class="header">
                    @{{ quiz.name }}
                </div>
                <div class="body">
                    <table width="100%" class="text-center">
                        <tr>
                            <td>Activer</td>
                            <td>
                                <input id="switch-@{{ quiz.id }}" type="checkbox" class="switch"
                                       ng-checked="quiz.is_active"
                                       ng-click="quiz.is_active = !quiz.is_active;
                                       activateQuiz(quiz.id, quiz.is_active);">
                                <label for="switch-@{{ quiz.id }}"></label>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="footer">
                    <a href="/admin/quizzes/@{{ quiz.id }}"
                       data-toggle="tooltip" title="démarrer">
                        <i class="material-icons">launch</i>
                    </a>
                    <button type="button" ng-click="deleteQuiz(quiz.id)">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- bootstrap modal --}}
    <div id="modal-quiz" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">@{{ form_title }}</h4>
                </div>
                <div class="modal-body">
                    <form name="frmQuiz" novalidate>

                        <div class="form-group">
                            <label for="subject-id">Metière</label>
                            <select id="subject-id" name="subject_id" class="form-control"
                                    ng-model="quiz.subject_id" ng-required="true">
                                <option value="">Selectionner une matière</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"
                                  ng-show="frmQuiz.subject_id.$invalid && frmQuiz.subject_id.$touched">
                                Veuillez choisir une matière.
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="quiz-name">Nom</label>
                            <input type="text" id="quiz-name" name="name" class="form-control"
                                   value="@{{ quiz.name }}" ng-model="quiz.name" ng-required="true">
                            <span class="text-danger"
                                  ng-show="frmQuiz.name.$invalid && frmQuiz.name.$touched">
                                Ce champ est obligatoir.
                            </span>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success"
                            ng-disabled="frmQuiz.$invalid" ng-click="submitQuiz()">
                        Save changes
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</section>

@endsection

@push('scripts')
<script src="{{ asset('angular/admin/services/quizzesService.js') }}"></script>
<script src="{{ asset('angular/admin/controllers/quizzesController.js') }}"></script>

@endpush