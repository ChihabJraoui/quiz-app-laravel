
adminApp.factory('Quiz', function($http)
{
    return {

        getConnectedMembers : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/quizzes/' + id + '/users',
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        start : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/quizzes/'+ id +'/start',
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        getQuestionsCount : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/quizzes/'+ id +'/questions-count',
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        getResults : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/quizzes/'+ id +'/results',
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        close : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/quizzes/'+ id +'/close',
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        }

    }
});