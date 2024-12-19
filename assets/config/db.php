<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    use PHPMailer\PHPMailer\PHPMailer;

    $host = 'localhost';
    $db = 'dy_cricket';
    $user = 'root';
    $pass = '';
    

    $conn = mysqli_connect($host,$user, $pass, $db);
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


?>