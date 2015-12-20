blog.service('loginRegisterService', function($http, $log){
    var me = this;
    me.token = null;

    me.compareTokens = function (token){
        return $http({
            data: "token="+token,
            url: 'http://localhost:8888/lfz/Blog/php/compareTokens.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST'
        }).success(function (response) {
        }).error(function (response) {
            $log.error('Error loading data', response);
        });
    };




    me.logOutFromDb = function(token){
        return $http({
            data: "token="+token,
            url: 'http://localhost:8888/lfz/Blog/php/logout.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST'
        }).success(function (response) {
           console.log(response);
        }).error(function (response) {
            $log.error('Error loading data', response);
        });
    };

    me.loginToDb = function(username, password) {
        return $http({
            data: 'username=' + username + '&password=' + password,
            url: 'http://localhost:8888/lfz/Blog/php/login.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST'
        }).success(function (response) {
            // $log.info('load data successful: ', response);
        }).error(function (response) {
            $log.error('Error loading data', response);
        });
    };


    
    me.registerToDb = function(user, email, pw, confirmPw){
        return $http({
                data: 'user=' + user + '&email=' + email + '&pw=' + pw + '&confirmPw=' + confirmPw,
                url: 'http://localhost:8888/lfz/Blog/php/register.php',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                method: 'POST'
            }).success(function(response){
                    $log.info('load data successful: ', response)
                }).error(function(response){
                    $log.error('Error loading data', response);
                });
    };

});