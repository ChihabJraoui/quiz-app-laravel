
adminApp.controller('subjectsController', function($scope, $http, Subject)
{

    // object to hold all the data for the new comment form
    $scope.subjectData = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;


    // Show Modal
    $scope.showModal = function(id)
    {
        $scope.id = id;
        $scope.subject = null;

        if(id == 0)
        {
            $scope.type = 'add';
            $scope.form_title = 'Ajouter une matiere';
        }
        else
        {
            $scope.type = 'edit';
            $scope.form_title = 'Modifier la matiere';
            Subject.get(id).then(function(response)
            {
                $scope.subject = response.data;
            });
        }

        $('#subject-modal').modal('show');
    };


    // get all the comments first and bind it to the $scope.comments object
    Subject.get(null).then(function(response)
    {
        $scope.subjects = response.data;
        $scope.loading = false;
    });


    // function to handle submitting the form
    $scope.submitSubject = function(type, id)
    {
        $scope.loading = true;

        if(type == 'add')
        {
            Subject.store($scope.subject).then(function()
            {
                Subject.get(null).then(function(response)
                {
                    $scope.subjects = response.data;
                    $scope.loading = false;
                });

            });
        }
        else if(type == 'edit')
        {
            Subject.update($scope.subject, id).then(function()
            {
                Subject.get(null).then(function(response)
                {
                    $scope.subjects = response.data;
                    $scope.loading = false;
                });

            });
        }

        $('#subject-modal').modal('hide');
    };

    // deleting a subject
    $scope.deleteSubject = function(id)
    {
        var confirmation = confirm('Voulez-vous vraiment supprimer cette matiere ?');

        if(confirmation)
        {
            $scope.loading = true;

            // use the function we created in our service
            Subject.destroy(id).then(function()
            {
                Subject.get(null).then(function(response)
                {
                    $scope.subjects = response.data;
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