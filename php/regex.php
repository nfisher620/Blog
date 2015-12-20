<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
function isValidPassword($password){
    $regex = '/^(\w|[!@#$%^&*()]){7,50}/';
    return preg_match($regex,$password);
}
function isValidName($name)
{
    $regex = '/[A-Za-z\- ]*/';
    return preg_match($regex, $name);
}
function isValidEmail($email){
    $regex = '/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/';
    return preg_match($regex,$email);
}
?>