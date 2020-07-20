@extends('layouts.app')


@push('angular_script')
<script src="{{ asset('angular/app/controllers/Login.js') }}"></script>
@endpush


@section('content')

<section class="app-login" data-ng-controller="LoginController">

    <h1 class="brand">QuizUp</h1>
    <h3 class="heading">The new way of testing your understandings</h3>

    <div class="overlay">

        <form name="frmLogin" role="form" method="POST" action="/login">

	        {{ csrf_field() }}

            <div class="wrapper">
                <div class="heading">
                    <h3 class="text-center">Connexion</h3>
                </div>
                <div class="body">
                    <div class="form-group">
                        <input name="email" type="email" class="form-control"
                               placeholder="Adresse email" autocomplete="off"
                               data-ng-model="data.email" data-ng-required="true">
                        <small class="text-danger" data-ng-cloak
                               data-ng-show="frmLogin.email.$invalid && frmLogin.email.$touched">
                            Champ obligatoire
                        </small>
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control"
                               placeholder="Mot de passe" autocomplete="off"
                               data-ng-model="data.password" data-ng-required="true">
                        <small class="text-danger" data-ng-cloak
                              data-ng-show="frmLogin.password.$invalid && frmLogin.password.$touched">
                            Champ obligatoire
                        </small>
                    </div>
                    <div class="text-right">
                        <a href="/password/reset">Mot de passe oublié ?</a>
                    </div>
                </div>
                <div class="footer">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" value="1" class="form-check-input"
                                   data-ng-model="data.remember" checked>
                            Enregistrer mes infos
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block"
                                data-ng-click="login($event)" data-ng-disabled="frmLogin.$invalid">
                            Se Connecter
                        </button>
                    </div>
                    <div class="form-group text-right">
                        Vous n'avez pas un compte ?
                        <a href="/register">
                            s'inscrire maintenant.
                        </a>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

@endsection
