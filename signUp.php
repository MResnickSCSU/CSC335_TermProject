<?php
        session_start();
        require 'functions.php';
        $creationError = '';
        if (isset($_POST['createUser'])) {
            if (!isset($_POST['fName']) || empty($_POST['fName']))
                $creationError = 'First Name not specified';
            else if (!isset($_POST['lName']) || empty($_POST['lName']))
                $creationError = 'Last Name not specified';
            else if (!isset($_POST['username']) || empty($_POST['username']))
                $creationError = 'Username not specified';
            else if (!isset($_POST['pw']) || empty($_POST['pw']))
                $creationError = 'Password not specified';
            else if (userCount($_POST['username']) > 0)
                $creationError = "User '".$_POST['username']."' already exists";
            else {
                createUser($_POST['fName'], $_POST['lName'], $_POST['username'], $_POST['pw']);
                $_SESSION['username'] = $_POST['username'];
                header( 'Location: home.php' );
                }
            }
?>

<html>
<head>
    <link rel="stylesheet" href="furniture.css">
</head>

<body> 
    <div class="top">
        <span id="title">Furniture Store</span>
    </div>
    <div class="logInBox">
        <form class="loginBox" role="form" action="" method="post">
            <label for="fName">First Name:</label>
            <br>
            <input id="fName" name="fName" type="text" class="loginInput"/>
            <br>
            <label for="lName">Last Name:</label>
            <br>
            <input id="lName" name="lName" type="text" class="loginInput"/>
            <br>
            <label for="pw">Password:</label>
            <br>
            <input id="pw" name="pw" type="password" class="loginInput"/>
            <br>
            <label for="username">Username:</label>
            <br>
            <input id="username" name="username" class="loginInput" type="text" />

            <br><br>
            <button href="" name="createUser" class="logInButton">Create new user</button>
            <br><br>
            <span class="loginError"><?php echo $creationError; ?></span>
        </form>
    </div>
</body>

</html>