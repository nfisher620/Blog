<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require('connect.php');
//print_r($_POST);
$id = (int)$_POST['id'];
//$newUser = trim(addslashes($_POST['username']));
//$sql = " FROM blog WHERE id='$id'";
$sql = "DELETE FROM `blog` WHERE id='$id'";
$output['success'] = false;
//$sql = "UPDATE `blog` SET `public` = FALSE, `edited` = NOW() WHERE id='$id'";
//$queryUser = "SELECT users.id FROM users JOIN blog ON users.id = blog.user_id WHERE users.username = '$newUser'";
//$result = mysqli_query($conn, $queryUser);
//if(mysqli_affected_rows($result)>0){
//    while ($row = mysqli_fetch_assoc($result)){
//        $userId[]=$row;
//        print_r($userId);
//    }
//
//}
//$queryToken = "SELECT auth_token FROM auth-token WHERE user_id = $queryUser";
//$resultToken = mysqli_query($conn, $queryToken);
//if(mysqli_affected_rows($resultToken)>0){
//    while($row = mysqli_fetch_assoc($resultToken)){
//        $token[] = $row;
//        print_r($token);
//    }
//}

//if($token == $_POST['auth_token']) {

    if (mysqli_query($conn, $sql)) {
        //$success[] = "Record deleted successfully";
        $output['success'] = true;
        $output['id'] = $id;
        $output['msg'] = "Blog $id deleted successfully";
    } else {
        $output['error'] = mysqli_error($conn);
        $output['msg'] = "error deleting post $id";
    }

print(json_encode($output));
//}else {
//    $errors=["I am sorry, please login again if you want to update your blog"];
//}

?>