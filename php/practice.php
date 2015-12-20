<?php


$data = getDate();
$string = $data['weekday'].$data['month'].$data['mday'].$data['hours'].$data['minutes'].$data['seconds'];
$token = md5('chelsea');

print_r($string);

?>