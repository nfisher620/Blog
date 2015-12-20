<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
    require('connect.php');
    //comment out
    //print_r($conn);
    mysqli_query($conn,"SET NAMES 'utf8'");
    $query = "SELECT blog.title, blog.blog, blog.summary, blog.id, blog.image, blog.public,
    blog.published, blog.edited, blog.timestamp, users.username FROM blog JOIN users ON blog.user_id = users.id";
    //comment out
    //print_r($query);
    $result = mysqli_query($conn, $query);
//print_r($conn);
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $output[]= $row;

            //print(mb_detect_encoding($row['title']));
        }
        //print_r($output);
        //comment this out
       //print_r(json_encode($output));
    }
$result = [
    'success'=>true, 'data'=>$output
];
$result = json_encode($result);
print_r($result);
?>
