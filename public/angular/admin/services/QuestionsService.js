
adminApp.factory('QuestionService', function($http)
{
    return {

        getSubject : function(id)
        {
            return $http({
                method: 'GET',
                url: '/admin/subjects/' + id,
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        },

        get : function(id)
        {
            if(id == null)
            {
                return $http({
                    method: 'GET',
                    url: '/admin/subjects/' + id + '/questions',
                    headers: { 'X-CSRF-TOKEN' : csrf_token }
                });
            }
            else
            {
                return $http({
                    method: 'GET',
                    url: '/admin/questions/' + id,
                    headers: { 'X-CSRF-TOKEN' : csrf_token }
                });
            }
        },

        store : function(questionData)
        {
            return $http({
                method: 'POST',
                url: '/admin/questions',
                data: $.param(questionData),
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        update: function(questionData)
        {
            return $http({
                method: 'PUT',
                url: '/admin/questions/' + questionData.id,
                data: $.param(questionData),
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
                url: '/admin/questions/' + id,
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        }
    }
});