
adminApp.controller('QuestionsController', function($scope, $interval, QuestionService, AnswerService)
{
    $scope.id = null;
    $scope.selectedAnswer = {};
    $scope.questionData = {};


    // loading variable to show the spinning loading icon
    $scope.loading = true;


    // get the current subject with questions and answers
    var getInt = $interval(function()
    {
        QuestionService.getSubject($scope.id).then(function(response)
        {
            $scope.subject = response.data;
            $scope.loading = false;

            $interval.cancel(getInt);
        });
    }, 2000);


    // Show Answer Modal
    $scope.showAnswerModal = function(answer, question_id)
    {
        $scope.selectedAnswer = {};

        if(answer == null)
        {
            $scope.answerModalType = 'new';
            $scope.answerFormTitle = 'Ajouter une reponse';

            $scope.selectedAnswer.question_id = question_id;
        }
        else
        {
            $scope.answerModalType = 'edit';
            $scope.answerFormTitle = 'Modifier la reponse';

            $scope.selectedAnswer.id = answer.id;
            $scope.selectedAnswer.question_id = answer.question_id;
            $scope.selectedAnswer.answer = answer.answer;
            $scope.selectedAnswer.is_correct = answer.is_correct;
            $scope.selectedAnswer.created_at = answer.created_at;
            $scope.selectedAnswer.updated_at = answer.updated_at;
        }

        $('#answer-modal').modal('show');
    };


    // function to handle submitting the form
    $scope.submitAnswer = function()
    {
        // $scope.loading = true;

        if($scope.answerModalType == 'new')
        {
            AnswerService.store($scope.selectedAnswer).then(function(response)
            {
                if(response.data.error == 0)
                {
                    $scope.refreshAnswers(response.data.answer);
                }

                $('#answer-modal').modal('hide');
            });
        }
        else if($scope.answerModalType == 'edit')
        {
            AnswerService.update($scope.selectedAnswer).then(function(response)
            {
                if(response.data.error == 0)
                {
                    $scope.refreshAnswers(response.data.answer);
                }

                $('#answer-modal').modal('hide');
            });
        }
    };

    // Delete Answer
    $scope.deleteAnswer = function(answer)
    {
        var confirmation = confirm('Voulez-vous vraiment supprimer cette reponse ?');

        if(confirmation)
        {
            // $scope.loading = true;

            // use the function we created in our service
            AnswerService.delete(answer.id).then(function(response)
            {
                if(response.data.error == 0)
                {
                    for(var i = 0; i < $scope.subject.questions.length; i++)
                    {
                        if($scope.subject.questions[i].id == answer.question_id)
                        {
                            for(var j = 0; j < $scope.subject.questions[i].answers.length; j++)
                            {
                                if($scope.subject.questions[i].answers[j].id == answer.id)
                                {
                                    $scope.subject.questions[i].answers.splice(j, 1);
                                }
                            }
                        }
                    }
                }
            });
        }
        else
        {
            return false;
        }
    };


    // Show Question Modal
    $scope.showQuestionModal = function(question)
    {
        $scope.questionData = {};

        if(question == null)
        {
            $scope.questionModalType = 'new';
            $scope.questionFormTitle = 'Ajouter une question';

            $scope.questionData.subject_id = $scope.id;
        }
        else
        {
            $scope.questionModalType = 'edit';
            $scope.questionFormTitle = 'Modifier la question';

            $scope.questionData.id = question.id;
            $scope.questionData.subject_id = question.subject_id;
            $scope.questionData.question = question.question;
            $scope.questionData.created_at = question.created_at;
            $scope.questionData.updated_at = question.updated_at;
        }

        $('#question-modal').modal('show');
    };


    // function to handle submitting the form
    $scope.submitQuestion = function()
    {
        // $scope.loading = true;

        if($scope.questionModalType == 'new')
        {
            QuestionService.store($scope.questionData).then(function(response)
            {
                if(response.data.error == 0)
                {
                    $scope.subject.questions.unshift(response.data.question);
                }

                $('#question-modal').modal('hide');
            });
        }
        else if($scope.questionModalType == 'edit')
        {
            QuestionService.update($scope.questionData).then(function(response)
            {
                if(response.data.error == 0)
                {
                    for(var uq = 0; uq < $scope.subject.questions.length; uq++)
                    {
                        if($scope.subject.questions[uq].id == $scope.questionData.id)
                        {
                            $scope.subject.questions[uq] = response.data.question;
                        }
                    }
                }

                $('#question-modal').modal('hide');
            });
        }
    };

    // deleting a subject
    // $scope.deleteSubject = function(id)
    // {
    //     var confirmation = confirm('Voulez-vous vraiment supprimer cette matiere ?');
    //
    //     if(confirmation)
    //     {
    //         $scope.loading = true;
    //
    //         // use the function we created in our service
    //         Subject.destroy(id).then(function()
    //         {
    //             Subject.get(null).then(function(response)
    //             {
    //                 $scope.subjects = response.data;
    //                 $scope.loading = false;
    //             });
    //
    //         });
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // };



    // created answer
    $scope.refreshAnswers = function(newAnswer)
    {
        var i;

        if($scope.answerModalType == 'new')
        {
            for(i = 0; i < $scope.subject.questions.length; i++)
            {
                if($scope.subject.questions[i].id == $scope.selectedAnswer.question_id)
                {
                    if($scope.subject.questions[i].answers == undefined)
                        $scope.subject.questions[i].answers = [];

                    $scope.subject.questions[i].answers.unshift(newAnswer);
                }
            }
        }
        else
        {
            for(i = 0; i < $scope.subject.questions.length; i++)
            {
                if($scope.subject.questions[i].id == $scope.selectedAnswer.question_id)
                {
                    for(var j = 0; j < $scope.subject.questions[i].answers.length; j++)
                    {
                        if($scope.subject.questions[i].answers[j].id ==
                            $scope.selectedAnswer.id)
                        {
                            $scope.subject.questions[i].answers[j] = newAnswer;
                        }
                    }
                }
            }
        }
    };

});