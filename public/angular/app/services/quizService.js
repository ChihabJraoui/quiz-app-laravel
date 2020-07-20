
app.factory('Quiz', function ($http)
{
    return {

        check: function(id)
        {
            return $http({
                method: 'GET',
                url: '/quizzes/'+ id +'/check',
                headers: {'X-CSRF-TOKEN': csrf_token}
            });
        },

        getQuestions: function(quiz_id)
        {
            return $http({
                method: 'POST',
                url: '/questions-with-answers',
                data: { id : quiz_id },
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        save: function(quiz_id, score)
        {
            return $http({
                method: 'POST',
                url: '/quizzes/save',
                data: { quiz_id: quiz_id, score: score },
                headers: {'X-CSRF-TOKEN': csrf_token}
            });
        }

    }
});