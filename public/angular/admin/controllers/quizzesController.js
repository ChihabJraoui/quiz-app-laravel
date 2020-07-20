
adminApp.controller('quizzesController', function($scope, $http, Quiz)
{

    $scope.quiz = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;


    // Show Modal
    $scope.showModal = function(id)
    {
        // $scope.id = id;
        // $scope.quiz = null;

        // if(id == 0)
        // {
            $scope.type = 'add';
            $scope.form_title = 'Ajouter un Quiz';
        // }
        // else
        // {
        //     $scope.type = 'edit';
        //     $scope.form_title = 'Modifier la matiere';
        //     Subject.get(id).then(function(response)
        //     {
        //         $scope.subject = response.data;
        //     });
        // }

        $('#modal-quiz').modal('show');
    };


    // get all the comments first and bind it to the $scope.comments object
    Quiz.get(null).then(function(response)
    {
        $scope.quizzes = response.data;
        $scope.loading = false;
    });


    // function to handle submitting the form
    $scope.submitQuiz = function()
    {
        $scope.loading = true;

        // if(type == 'add')
        // {
        Quiz.store($scope.quiz).then(function()
            {
                Quiz.get(null).then(function(response)
                {
                    $scope.quizzes = response.data;
                    $scope.loading = false;
                });
            });
        // }
        // else if(type == 'edit')
        // {
        //     Subject.update($scope.subject, id).then(function()
        //     {
        //         Subject.get(null).then(function(response)
        //         {
        //             $scope.subjects = response.data;
        //             $scope.loading = false;
        //         });
        //
        //     });
        // }

        $('#modal-quiz').modal('hide');
    };


    // Activate Quiz
    $scope.activateQuiz = function(id, is_active)
    {
        Quiz.activate(id, is_active).then(function(response)
        {
            if (response.data.error == 0)
            {
                is_active == 0 ? notice('Le Quiz a été bien désactiver.')
                    : notice('Le Quiz a été bien activer.');
            }
            else
            {
                notice('Erreur, Veuillez réessayer plus tard', 'red');
            }
        });
    };

    // deleting a subject
    $scope.deleteQuiz = function(id)
    {
        var confirmation = confirm('Voulez-vous vraiment supprimer cet Quiz ?');

        if(confirmation)
        {
            $scope.loading = true;

            // use the function we created in our service
            Quiz.destroy(id).then(function()
            {
                Quiz.get(null).then(function(response)
                {
                    $scope.quizzes = response.data;
                    $scope.loading = false;
                });

            });
        }
        else
        {
            return false;
        }
    };

});