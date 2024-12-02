<?php   
        session_start();
        require "functions.php";
        session_destroy();
?>

<html>
<head>
    <link rel="stylesheet" href="furniture.css">
    <title>Log Out</title>
</head>

<body> 
    <div class="top">
        <span id="title">Furniture Store</span>
    </div>
    <div class="body">
        <p>You're Logged Out! &nbsp Log Back In? &nbsp</p>
        <a href="logIn.php" class="logInButton" style="margin-top: auto;">Click Here</a>
    </div>
</body>

</html>