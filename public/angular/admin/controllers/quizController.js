
adminApp.controller('quizController', function($scope, $interval, Quiz)
{
    $scope.quiz_id = null;

    $scope.connected_members = 0;

    $scope.question_time = 60;

    $scope.startScreen = true;
    $scope.timerScreen = false;
    $scope.resultScreen = false;

    // check for connected members
    var connectedMembersInterval = $interval(function()
    {
        Quiz.getConnectedMembers($scope.quiz_id).then(function(response)
        {
            $scope.connected_members = response.data;
        });

    }, 2000);

    // start the quiz
    $scope.startQuiz = function()
    {
        $interval.cancel(connectedMembersInterval);

        Quiz.start($scope.quiz_id).then(function()
        {
            Quiz.getQuestionsCount($scope.quiz_id).then(function (response)
            {
                $scope.questions_count = response.data;

                $scope.startScreen = false;
                $scope.timerScreen = true;

                $scope.startTimer();
            });
        });
    };

    // start timer
    $scope.startTimer = function()
    {
        var count = $scope.questions_count * $scope.question_time;

        var timerInterval = $interval(function()
        {
            if(count < 0)
            {
                $interval.cancel(timerInterval);

                $scope.timerScreen = false;
                $scope.resultScreen = true;

                $scope.closeQuiz();
                $scope.getResults();
            }

            $('#timer').text(count + 's');
            count--;

        }, 1000);
    };


    // get results
    $scope.getResults = function()
    {
        $interval(function()
        {
            Quiz.getResults($scope.quiz_id).then(function(response)
            {
                console.log('=> get results \n' + response.data);
                $scope.results = response.data;
            });
        }, 5000);
    };


    // close Quiz
    $scope.closeQuiz = function()
    {
        Quiz.close($scope.quiz_id).then(function (response)
        {
            console.log('=> close Quiz \n' + response.data);
        });
    };
});