<?php

require('../assets/config/db.php');

session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Hash the input password using MD5
        $hashed_password = md5($password);

        

        // Prepare SQL statement
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed_password'";
        $result = $conn->query($sql);

        // Check if user exists in the database
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            // User found, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $row['email'];
            echo $username;
            // Redirect to dashboard or any other page
            header("Location: index.php");
            exit();
        } else {
            // Invalid username or password
            $error = "Invalid username or password";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>VM Campaigns Checker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c2def52ca0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        body {
            background-color: #080710;
            font-family: 'Montserrat', 'sans-serif';
            background-image: url(assets/image/bg-dark-desktop.png);
        }
    </style>
    <link rel="icon" type="image/x-icon" href="images/logo-medusa.jpg">
</head>

<body class="relative flex items-center justify-center min-h-screen">
    
    <form action="login.php" method="post"
        class="relative w-[550px] h-[620px] lg:w-[400px] lg:h-[520px] p-[20px_35px] bg-[rgba(255,255,255,0.13)] rounded-[10px] backdrop-blur-[10px] border-[2px] border-[rgba(255,255,255,0.1)] shadow-[0_0_40px_rgba(8,7,16,0.6)]">
        <img src="images/logo.webp" class="mx-auto" style="width: 60%;" alt="">
        <p class="text-4xl text-yellow-400 font-bold text-center mt-3">VM Campaigns Checker</p>
            

        <?php if(isset($error)): ?>
            <div class="alert bg-red-500 border-t-4 border-red-500 rounded-b text-white text-center block"><?php echo $error; ?></div>
            <?php unset($error);
        endif; ?>
            
        <label for="username" class="block mt-[30px] text-[16px] font-medium text-white">Username</label>
        <input type="text" placeholder="Enter Email" id="username" name="username"
            class="block w-full h-[50px] mt-2 p-[0_10px] bg-[rgba(255,255,255,0.07)] rounded-[3px] text-[14px] font-light text-white placeholder-[#e5e5e5]">
        <label for="password" class="block mt-[23px] lg:mt-[10px] text-[16px] font-medium text-white">Password</label>
        <input type="password" placeholder="Password" id="password" name="password"
            class="block w-full h-[50px] mt-2 p-[0_10px] bg-[rgba(255,255,255,0.07)] rounded-[3px] text-[14px] font-light text-white placeholder-[#e5e5e5]">
        <button id="btn-clickuser" type="submit"
            class="block w-full mt-[50px] lg:mt-[30px] py-[15px] lg:py-[12px] bg-yellow-400 text-[#080710] text-[18px] font-bold rounded-[5px] cursor-pointer hover:bg-yellow-500">
            <i class="fa-solid fa-right-to-bracket mr-2"></i>Log In</button>
        <div class="flex mt-[20px] lg:mt-[20px]">
        </div>

    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            if($('.alert').hasClass('block')){
                setTimeout(function(){
                    $('.alert').addClass('hidden');
                }, 2000);
            }
            
        });
    </script>
    <script src="script.js"></script>
</body>

</html>