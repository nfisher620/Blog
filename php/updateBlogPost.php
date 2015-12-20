<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
require('connect.php');
$newTitle = trim(addslashes($_POST['title']));
$newBlog = trim(addslashes($_POST['blog']));
$newSummary = substr($newBlog, 0, 100);;
//$newTags = trim(addslashes($_POST['images']));
$newPublic = trim(addslashes($_POST['public']));
//$newUser = trim(addslashes($_POST['user']));
//print_r($_POST);
$newBlogPost = trim(addslashes($_POST['id']));   // id of the row
if (!isset($newPublic)) {
    $newPublic = 1;
}
$output['success'] = false;



//if ($token == $_POST['auth_token']) {
//print_r($newInsert);
$query = "UPDATE `blog` SET `title` = '$newTitle', `blog` = '$newBlog', `summary` = '$newSummary', `public` = $newPublic, `edited` = NOW() WHERE `id` = $newBlogPost";
$updateResult = mysqli_query($conn, $query);

if (mysqli_affected_rows($conn) > 0) {
    //then grab the most recent timestamp
    $timeStampQuery = "SELECT edited FROM blog WHERE id = $newBlogPost";
    $timeStampResult = mysqli_query($conn, $timeStampQuery);
    if(mysqli_num_rows($timeStampResult)>0){
        while($row = mysqli_fetch_assoc($timeStampResult)){
            $timeStamp = $row;
        }
    }
    $responseArray = [
      'success'=>true,
        'timeStamp'=> $timeStamp['edited']
    ];

} //}
else {
    $errors = ["I am sorry, please login again if you want to update your blog"];
    $responseArray = [
        'success'=>true,
        'errors'=> $errors
    ];
}
print(json_encode($responseArray));

?>