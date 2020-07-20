
app.controller('quizController', function ($scope, $interval, Quiz)
{
    var checkInterval, timerInterval;

    $scope.id = null;
    $scope.questions = [];
    $scope.answers = [];

    // h
    $scope.current_question = 0;
    $scope.correct_answers = 0;
    $scope.question_time = 60;

    $scope.showWaitScreen = true;
    $scope.showQuizScreen = false;
    $scope.showResultScreen = false;
    $scope.showErrorScreen = false;

    $scope.disableButtons = false;

    // check Quiz if ready
    checkInterval = $interval(function()
    {
        Quiz.check($scope.id).then(function(response)
        {
            if(response.data.quiz.is_started == 1)
            {
                $interval.cancel(checkInterval);

                if(response.data.user.is_started == 1)
                {
                    $scope.getQuestions();
                }
                else
                {
                    $scope.showWaitScreen = false;
                    $scope.showErrorScreen = true;
                }
            }
        });
    }, 2000);

    // get questions
    $scope.getQuestions = function()
    {
        Quiz.getQuestions($scope.id).then(function(response)
        {
            $scope.questions = response.data;
            $scope.showWaitScreen = false;
            $scope.showQuizScreen = true;
            $scope.showNextQuestion();
        });
    };

    // show next question
    $scope.showNextQuestion = function()
    {
        if($scope.questions[$scope.current_question] != undefined)
        {
            // progress current question
            // $('#quiz-progress-' + current_question).addClass('current');

            // load current question
            $scope.question = $scope.questions[$scope.current_question].question;

            // load current answers
            $scope.answers = $scope.questions[$scope.current_question].answers;

            // start quiz timer
            $scope.startTimer();
        }
        else
        {
            $interval.cancel(timerInterval);

            $scope.showQuizScreen = false;
            $scope.showResultScreen = true;

            $scope.result = $scope.correct_answers + ' / ' + $scope.questions.length;

            $scope.sendResults();
        }
    };

    // start timer
    $scope.startTimer = function()
    {
        $scope.countdown = $scope.question_time;

        timerInterval = $interval(function ()
        {
            if($scope.countdown < 0)
            {
                $interval.cancel(timerInterval);
                $scope.countdown = $scope.question_time;
                $scope.current_question++;
                $scope.showNextQuestion();
            }

            $scope.timer.set($scope.countdown / $scope.question_time);
            $scope.countdown--;

        }, 1000);
    };

    // choose answer
    $scope.chooseAnswer = function(id, is_correct)
    {
        $('#answers').find('button').prop('disabled', true);

        var btn = $('#btn-answer-'+ id);
        btn.removeClass('btn-default');

        if(is_correct == 1)
        {
            btn.addClass('btn-success');
            $scope.correct_answers++;
        }
        else
        {
            btn.addClass('btn-danger');
        }
    };

    // send results
    $scope.sendResults = function()
    {
        Quiz.save($scope.id, $scope.correct_answers).then(function(response)
        {
            console.log('=> send results \n' + response.data);
        });
    };

})
    .directive('progressBar', function()
    {
        return {

            restrict: 'E',
            link: function(scope, element, attrs)
            {
                scope.timer = new ProgressBar.Circle('#' + attrs.id, {
                    color: attrs.color,
                    trailColor: attrs.trailColor,
                    strokeWidth: attrs.stockWidth,
                    duration: 1000,
                    easing: 'easeInOut'
                });

                scope.timer.set(1);
            }
        }
    });
