<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require('connect.php');
require('regex.php');

//$username = addslashes(trim($_POST['username']));
//$email = addslashes(trim($_POST['email']));
//$password = addslashes($_POST['password']);

//$username = $_POST['username'];
//$email = $_POST['email'];
//$password = $_POST['password'];
//print_r($conn);
//
//if(isValidName($username)==true && isValidEmail($email)==true && isValidPassword($password)==true){
    //if the regex test passes , insert the new user into the database

$username = $_POST['user'];
$email = $_POST['email'];
$password = $_POST['pw'];

    $query = "INSERT INTO `users`(`username`, `email`, `password`, `TIMESTAMP` ) VALUES ('$username','$email','$password', NOW())";
    mysqli_query($conn, $query);

    //if the insertion is successful
    if(mysqli_affected_rows($conn)>0) {
        $newID = mysqli_insert_id($conn);
        $output = [
            'success'=>true,
            'newID'=> $newID
        ];

        print(json_encode($output));
    }else{
        $output = [
            'success'=>false,
            'errors'=> 'error inserting user into database'
        ];

        print(json_encode($output));
    }

//} else{  //if the regex test does not pass
//    $output['success'] = false;
//    $output['errors'] = "Error";
//    print(json_encode($output));
//}


?>
