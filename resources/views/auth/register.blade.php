@extends('layouts.auth')
@section('page_title', 'Inscription')
@section('auth_content')

    <main class="app-login">

        <h1 class="brand">QuizUp</h1>
        <h3 class="heading">The new way of testing your understandings</h3>

        <section class="overlay">

            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="wrapper">
                    <div class="heading">
                        <h3 class="text-center">Inscription</h3>
                    </div>
                    <div class="body">
                        {{-- last name--}}
                        <div class="form-group">
                            <input type="text" id="text-lastname" name="lastname" class="form-control"
                                   placeholder="Nom" autocomplete="off" />
                        </div>
                        {{-- first name --}}
                        <div class="form-group">
                            <input type="text" id="text-firstname" name="firstname" class="form-control"
                                   placeholder="Prénom" autocomplete="off" />
                        </div>
                        {{-- email --}}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" id="text-email" name="email" class="form-control"
                                   placeholder="adresse email" autocomplete="off" />
                            @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        {{-- password --}}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" id="text-password" name="password" class="form-control"
                                   placeholder="mot de passe" autocomplete="off" />
                            @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        {{-- role --}}
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="role" value="0" checked> Etudiant
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="role" value="1"> Enseigneur
                            </label>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="form-group">
                            <button id="btn-login" type="submit" class="btn btn-default btn-lg btn-block">
                                S'inscrire
                            </button>
                        </div>
                        <div class="form-group text-right">
                            Vous avez déja un compte ?
                            <a href="/login">
                                se connecter.
                            </a>
                        </div>
                    </div>
                </div>

            </form>
        </section>

    </main>

@endsection
