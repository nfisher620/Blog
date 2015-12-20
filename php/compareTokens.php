<?php
require('connect.php');
$curToken = $_POST['token']; //token from client

$tokenQuery = "SELECT * FROM `auth_token` WHERE `auth_token` = '$curToken'";
$tokenResult = mysqli_query($conn, $tokenQuery); //result here would be an object

if(mysqli_num_rows($tokenResult)>0){  //if a row was returned it means that we have a match
    while($row = mysqli_fetch_assoc($tokenResult)){
        //if we have a match, make a query to get the username associated with the id we have from what was initially returned
        $userId = $row['user_id'];
    }

    $usernameQuery = "SELECT username FROM users WHERE id = $userId";
    $usernameResult = mysqli_query($conn, $usernameQuery);

    if(mysqli_num_rows($usernameResult)>0){
        //if we get a row back, grab the username and pass it back as a response
        while($usernameRow = mysqli_fetch_assoc($usernameResult)){
            $username = $usernameRow['username'];
        }
        $responseArray = [
            'success'=>true,
            'username'=>$username
        ];
        print(json_encode($responseArray));

    }else{
        $responseArray = [
            'success'=>false,
            'error'=>'token matches but error getting userId from server'
        ];
        print(json_encode($responseArray));

    }
}else{
    $responseArray = [
        'success'=>false,
            'error'=>'tokens don\'t match'
        ];

    print(json_encode($responseArray));
}



?>


