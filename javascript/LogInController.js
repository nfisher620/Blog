

blog.controller('loginController', function($http, $log, loginRegisterService){
    var self = this;
    self.username = null;
    self.bool = true;
    self.badusername = false;
    self.login = {};
    self.register = {};
    self.loggedInBool = false;
    self.registerusernameMessage = null;
    self.registeremailMessage = null;
    self.registerpasswordMessage = null;
    self.registrationSuccessMessage = null;


    self.registerUser = function(user, email, pw, confirmPw){
        console.log(user, email, pw, confirmPw);
        //form validation
        registerForm = {
            username: user,
            email: email,
            password: pw,
            confirmPassword: confirmPw
        };
        var bool = true;

        for(var i in registerForm){
            var property = 'register' + i + 'Message';
            if(typeof registerForm[i] == 'undefined' || registerForm[i] == ''){
                bool = false;
                console.log('property ' + property);
                self[property] = 'Please enter a valid ' + i;
            }else{
                self[property] = null;
            }
        }

        if(bool){
            //if none of the field are empty, check that the passwords match, also need to check passwords match on the backend
            if(registerForm.password === registerForm.confirmPassword){
                console.log('passwords match');
                //clear the error messages
                self.registerusernameMessage = null;
                self.registeremailMessage = null;
                self.registerpasswordMessage = null;

                self.register = {};
                loginRegisterService.registerToDb(user, email, pw, confirmPw).then(function(response){
                    if(response.data.success){
                        self.registrationSuccessMessage = 'Registration Successful! Return to Login tab to sign in';
                    }
                });
            }
        }

    };

    self.changeBool = function(){
        self.bool = (self.bool) ? !(self.bool) : true;
    };

    self.checkIfLoggedIn = function(){
        //update current token on page load
        var token = localStorage.getItem("token");
        console.log(' token ' + ' ' + token);
        if(token){
            loginRegisterService.compareTokens(token).then(function(response){
               if(response.data.success){
                   console.log('true', response);
                   loginRegisterService.token = token;
                   //this means the tokens match and we are still logged in
                   self.username = response.data.username;
                   self.loggedInBool = true;
                   //we need to grab the name of the id and stick it up there as well
               }else{
                   console.log('false', response);
                   //either tokens did not match, or the token was deleted on the server but not the client
               }
            });
        }
    };

    self.checkIfLoggedIn();

    self.logOut = function(){
        loginRegisterService.logOutFromDb(loginRegisterService.token).then(function(response){
           if(response.data.success){
               console.log(response);
               self.loggedInBool = false;
               console.log('logged in bool ' + self.loggedInBool);
               localStorage.removeItem('token');
           }else{
               console.log(response);
           }
        });
    };

    self.loginUser = function(username, password){
        self.login = {};
        loginRegisterService.loginToDb(username, password).then(function(response){
            // if a token property exists in response, place in browser
            // if there is not a token, is there a response.data.data
            if(response.data.token) {
                loginRegisterService.token = response.data.token; //update the current token of the service on response.success
                console.log('login token ' + ' ' + loginRegisterService.token);
                self.loggedInBool = true;
                self.username = response.data.username;
                    //update the current token in local storage
                localStorage.setItem("token", response.data.token);
                console.log("token ", response.data.token);
                self.badusername = false;
                return;

            }
            if (response.data.data) {
                self.datamessage = response.data.data;
                self.badusername = true;
                console.log("data ", response.data.data);
            }
        });
    };




});