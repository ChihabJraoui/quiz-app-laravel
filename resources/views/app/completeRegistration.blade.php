@extends('layouts.app')

@section('app_content')

<main class="app-content">
    <section class="container-fluid">

        <div class="page-heading">
            <h2>Complete Registration</h2>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <form action="/complete-registration" method="post">
                    {{ csrf_field() }}
                    <div class="wrapper">
                        <div class="heading">Veuillez completer votre inscription</div>
                        <div class="body">
                            <div class="form-group">
                                <label for="select-branch">Filiere: </label>
                                <select id="select-branch" name="branch_id" class="form-control">
                                    <option disabled selected>Selectionner une filiére</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="footer text-right">
                            <button type="submit" class="btn btn-success">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section>
</main>

@endsection