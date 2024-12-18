<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    use PHPMailer\PHPMailer\PHPMailer;

    $host = 'localhost';
    $db = 'u198372255_vm_cricket';
    $user = 'u198372255_vm_user_ckt';
    $pass = 'e=md8g&u[O4G';
    

    $conn = mysqli_connect($host,$user, $pass, $db);
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


?>