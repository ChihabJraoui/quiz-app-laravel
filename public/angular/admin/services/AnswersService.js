
adminApp.factory('AnswerService', function($http)
{
    return {

        get : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/answers/' + id,
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        store : function(data)
        {
            return $http({
                method: 'POST',
                url: '/admin/answers',
                data: $.param(data),
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        update: function(answerData)
        {
            return $http({
                method: 'PUT',
                url: '/admin/answers/' + answerData.id,
                data: $.param(answerData),
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        delete : function(id)
        {
            return $http({
                method: 'DELETE',
                url: '/admin/answers/' + id,
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        }
    }
});