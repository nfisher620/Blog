<?php
require('connect.php');
$token = $_POST['token'];


$logOutQuery = "DELETE FROM `auth_token` WHERE auth_token = '$token'";
$logOutResult = mysqli_query($conn, $logOutQuery);
if(mysqli_affected_rows($conn)>0){
    $responseArray = [
      'success'=> true,
        'data' => 'loggedOut!'
    ];
}else{
    $responseArray = [
        'success'=> false,
        'data' => 'logout failed!'
    ];
}

print(json_encode($responseArray));


?>