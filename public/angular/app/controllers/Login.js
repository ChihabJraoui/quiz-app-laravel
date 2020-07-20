
angularApp.controller('LoginController', function($scope, $http)
{

    $scope.data = {
        remember: null
    };

    /* Login */

    $scope.login = function($event)
    {
        $($event.srcElement).prepend('<i class="fa fa-spinner fa-spin"></i>&nbsp;');
        $($event.srcElement).prop('disabled', true);

        $http({
            method : 'POST',
            url : '/login',
            data : $.param($scope.data),
            headers : {
                'Content-Type' : 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN' : window.app.csrf_token
            }
        })
            .then(function(response)
        {

            if(response.data.error == 0)
            {
                location.href = '/';
            }
            else
            {
                $($event.srcElement).find('i').remove();
                $($event.srcElement).prop('disabled', false);

                console.log('error : ', response.data.message);

                swal({
                    title: '',
                    text: response.data.message,
                    type: 'error'
                });
            }
        });
    };

});