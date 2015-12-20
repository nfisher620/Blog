<?php
//select from user table where username = username..
//if there's no username return a response doesn't exist
//if it does exist.. check if the password matches..if password doesn't match return username or password is invalid
//if both exist and match, create the authentication token
//Insert the authentication token into the data base.. upon success.. pass that back as a response and the front end will store that in a cookie

//TODO need to do form validation on this
require('connect.php');
$username = $_POST['username'];
$password = $_POST['password'];
$usernameQuery = "SELECT username FROM users WHERE username = '$username' ";  //username query to test
$userResult = mysqli_query($conn, $usernameQuery);

if(mysqli_num_rows($userResult)>0){
    //if true.. then we have a match.. check password
    $passwordQuery = "SELECT * FROM users WHERE username = '$username' AND password = '$password' "; //password query to test
    $passwordResult = mysqli_query($conn, $passwordQuery);
    if(mysqli_num_rows($passwordResult)>0){
        //if we have a match for password based on the username create the token
        while($row = mysqli_fetch_assoc($passwordResult)){
            $userId = $row['id'];
            //at this point we have the user id and the token below
        }
        $data = getDate();
        $string = $data['weekday'].$data['month'].$data['mday'].$data['hours'].$data['minutes'].$data['seconds'];
        $token = md5($string);
        $tokenQuery = "INSERT INTO `auth_token`(`user_id`, `auth_token`, `timestamp`) VALUES ($userId, '$token', NOW())";
        $tokenResult = mysqli_query($conn, $tokenQuery);
        //if row insertion of token is successful
        if(mysqli_affected_rows($conn)){
            $responseArray = [
                'success'=>true,
                'token'=> $token,  //alkajsdhfsdakjlhd223487392472
                'username'=>$username
            ];

            print(json_encode($responseArray));
        }
    }
    else{
        //if usename matches but not pasword
        $responseArray = [
            'success'=>true,
            'data'=> 'username or password is not valid'
        ];
        print(json_encode($responseArray));
    }

}
else{
    $responseArray = [
      'success'=>true,
        'data'=> 'username or password is not valid'
    ];
    print(json_encode($responseArray));
}


?>