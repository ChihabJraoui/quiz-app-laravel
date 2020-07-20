
angularApp.controller('QuizzesController', function ($scope, $interval, QuizzesService)
{

    $scope.quizzes = [];


    // get active quizzes
    $scope.getQuizzes = function()
    {
        QuizzesService.get().then(function(response)
        {
            console.log(response);
            $scope.quizzes = response.data;
        });
    };


    // check for quizzes every 10 seconds
    $scope.getQuizzes();

    $interval(function()
    {
        $scope.getQuizzes();
    }, 10000);

});