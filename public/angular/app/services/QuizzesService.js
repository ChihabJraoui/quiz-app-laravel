
angularApp.service('QuizzesService', function ($http)
{
    return {

        get: function()
        {
            return $http({
                method: 'GET',
                url: '/api/quizzes/0',
                headers: { 'X-CSRF-TOKEN' : window.app.csrf_token }
            });
        }

    }
});