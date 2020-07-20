
adminApp.factory('Subject', function($http)
{
    return {

        get : function(id)
        {
            if(id == null)
            {
                return $http({
                    method: 'GET',
                    url: '/admin/subjects',
                    headers: { 'X-CSRF-TOKEN' : csrf_token }
                });
            }
            else
            {
                return $http({
                    method: 'GET',
                    url: '/admin/subjects/' + id,
                    headers: { 'X-CSRF-TOKEN' : csrf_token }
                });
            }
        },

        store : function(data)
        {
            return $http({
                method: 'POST',
                url: '/api/subjects',
                data: $.param(data),
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        update: function(data, id)
        {
            return $http({
                method: 'PUT',
                url: '/api/subjects/' + id,
                data: $.param(data),
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN' : csrf_token
                }
            });
        },

        destroy : function(id)
        {
            return $http({
                method: 'DELETE',
                url: '/api/subjects/' + id,
                headers: { 'X-CSRF-TOKEN' : csrf_token }
            });
        }
    }
});