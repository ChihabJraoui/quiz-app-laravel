@extends('layouts.admin')

@section('main_content')

<section class="container-fluid" ng-controller="subjectsController">

    {{-- toolbar --}}
    <div class="toolbar">
        <div class="heading">
            <h1>Matières</h1>
        </div>
        <ul class="items">
            <li>
                <button id="btn-add-subject" type="button" class="btn btn-success"
                        ng-click="showModal(0)">
                    <i class="material-icons">add</i>
                    <span>Ajouter une Matière</span>
                </button>
            </li>
        </ul>
    </div>

    <div class="text-center" ng-hide="!loading">
        <span class="fa fa-spinner fa-2x fa-spin"></span>
    </div>

    {{-- data --}}
    <div class="row ng-cloak" ng-show="!loading">
        <div class="col-md-4" ng-repeat="subject in subjects">

            <div class="wrapper">
                <div class="heading">
                    <h4>@{{ subject.name }}</h4>
                    <ul class="items">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown">
                                <i class="material-icons md-24">more_vert</i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="javascript:" ng-click="showModal(subject.id)">
                                        <i class="material-icons">edit</i>
                                        Modifier
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:" ng-click="deleteSubject(subject.id)">
                                        <i class="material-icons">clear</i>
                                        Supprimer
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                </div>
                <div class="footer">
                    <a href="/admin/dashboard/subjects/@{{ subject.id }}/questions" class="btn btn-primary
                    btn-block">
                        Questions
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- bootstrap modal --}}
    <div id="subject-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">@{{ form_title }}</h4>
                </div>
                <div class="modal-body">
                    <form name="formSubject" novalidate>
                        <div class="form-group">
                            <label for="subjectName">Nom</label>
                            <input type="text" id="subjectName" name="name" class="form-control"
                                   value="@{{ subject.name }}" ng-model="subject.name" ng-required="true">
                            <span class="text-danger"
                                    ng-show="formSubject.name.$invalid && formSubject.name.$touched">
                                Ce champ est obligatoir.
                            </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"
                            ng-disabled="formSubject.$invalid"
                            ng-click="submitSubject(type, id)">
                        Save changes
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</section>

@endsection

@push('scripts')
<script src="{{ asset('angular/admin/services/subjectService.js') }}"></script>
<script src="{{ asset('angular/admin/controllers/subjectController.js') }}"></script>

@endpush