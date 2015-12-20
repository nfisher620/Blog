<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
//we need a blog_id as well, not just an id for the row

require('connect.php');
//print_r($_POST);
if (empty($_POST['username'])) {
    $responsArray = ['success' => false,
        'error' => 'username does not exist'];
    print(json_encode($responseArray));
}
$username = $_POST['username'];
$userId = null;
//TODO need to do form validation and data cleansing on this as well
//we need to grab the user id from the username provided
$idQuery = "SELECT users.id FROM users WHERE username = '$username'";
$idResult = mysqli_query($conn, $idQuery);
if (mysqli_num_rows($idResult)) {
    //if a response was returned
    $rowArray = [];
    while ($row = mysqli_fetch_assoc($idResult)) {
        //grab the id
        $userId = $row['id'];
    }

    $blogTitle = $_POST['title'];
    $blogPost = $_POST['blog'];

    $subPost = substr($blogPost, 0, 7);
//    $pattern = '/(.+)?[ ]/';
//    preg_match($pattern, $subPost, $match);
// $match will be our summary, $string will be the blog post in full
//    $summary = $match;
//first we check if the user has sent a correct authentication token.. if yes..
//grab the user id associated with the authentication token
//insert user_id, title, blog post, summary,

    $insertBlogPostQuery = "INSERT INTO `blog`(`user_id`, `title`, `blog`, `summary`, `public`, `timestamp`) VALUES ('$userId', '$blogTitle', '$blogPost', '$subPost', true, NOW())";
    $result = mysqli_query($conn, $insertBlogPostQuery);

    if (mysqli_affected_rows($conn) > 0) {
        $responseArray['success'] = true;
        $newId=mysqli_insert_id($conn);  //last row inserted in to blog table
        //make query for time stamp
        $timeStampQuery = "SELECT timestamp FROM blog WHERE id = '$newId'";
        $timeStampResult = mysqli_query($conn, $timeStampQuery);
        if(mysqli_num_rows($timeStampResult)>0){
            while($row = mysqli_fetch_assoc($timeStampResult)){
                $timeStamp = $row;
            }
        }


        $responseArray = [
            'success'=> true,
            'data'=>[
                'id'=>$newId,
                'summary'=>$subPost,
                'timeStamp' => $timeStamp['timestamp']
            ],
        ];


    } else {
        $responseArray = [
            'success' => false,
            'error' => 'userID valid, update failed'
        ];
    }

    print(json_encode($responseArray));


} else {
    $responseArray = [
        'success' => false,
        'error' => 'userId not found'
    ];

    print(json_encode($responseArray));
}

//
//regex for everything up to the last space but not including that last space
//     (.+)?[ ]


?>