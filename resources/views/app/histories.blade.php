@extends('layouts.app')

@section('app_content')

<main class="app-content">
    <section class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel">
                    <div class="panel-body">

                        <h3>Past Tests</h3>

                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Test</th>
                                <th>Score</th>
                                <th>Date</th>
                            </tr>

                            @foreach($histories as $history)

                                <tr>
                                    <td>{{ $history->subject->name }}</td>
                                    <td>{{ $history->score }}</td>
                                    <td>{{ $history->created_at }}</td>
                                </tr>

                            @endforeach

                        </table>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

@endsection