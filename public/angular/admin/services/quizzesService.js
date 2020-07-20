
adminApp.factory('Quiz', function($http)
{
    return {

        get : function(id)
        {
            if(id == null)
            {
                return $http({
                    method: 'GET',
                    url: '/api/quizzes/1',
                    headers: { 'X-CSRF-TOKEN' : csrf_token }
                });
            }
            else
            {
                return $http({
                    method: 'GET',
                    url: '/api/quizzes/' + id,
                    headers: { 'X-CSRF-TOKEN' : csrf_token }
                });
            }
        },

        store : function(data)
        {
            return $http({
                method: 'POST',
                url: '/api/quizzes',
                data: $.param(data),
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        activate: function(id, is_active)
        {
            return $http({
                method: 'POST',
                url: '/api/quizzes/' + id + '/activate',
                data: { is_active : is_active },
                headers: {
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        destroy : function(id)
        {
            return $http({
                method: 'DELETE',
                url: '/api/quizzes/' + id,
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        }
    }
});