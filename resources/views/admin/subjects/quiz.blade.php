@extends('layouts.admin')

@section('main_content')

<section class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel">
                <div class="panel-body text-center">

                    <h2>Membres connectés: <span id="connected-members">0</span></h2>

                    <hr>

                    <a id="btn-start-quiz" href="javascript:" class="btn btn-success">
                        Démarrer le quiz
                    </a>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')

<script>
    $(document).ready(function()
    {

        var checkInterval;

        // Check connected members
        checkInterval = setInterval(function()
        {
            $.ajax({
                type: 'GET',
                url: '/admin/subjects/{{ $subject->id }}/check-members',
                success: function(response)
                {
                    $('#connected-members').text(response);
                }
            });

        }, 3000);

        // Start the quiz
        $('#btn-start-quiz').click(function()
        {
            clearInterval(checkInterval);

            $.ajax({
                type: 'GET',
                url: '/admin/subjects/{{ $subject->id }}/start',
                data: { },
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function(response)
                {
                    console.log(response);
                }
            });
        });

    });
</script>

@endpush