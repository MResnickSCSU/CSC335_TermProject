<?php
			session_start();
            require 'functions.php';
            $logInError = '';
            if (isset($_SESSION['username'])) {
                header( 'Location: ./home.php' ); 
            }
			if (isset($_POST['logIn']) && isset($_POST['username']) && !empty($_POST['username']) && !empty($_POST['pw'])) {
			    $loginData = checkLogin($_POST['username'], $_POST['pw']);

			    if (count($loginData)==0) {
			        $logInError = 'Invalid username or password';
			    }
				else {
                    $_SESSION['username'] = $_POST['username'];
					header( 'Location: home.php' );
				}
			} else {
				$logInError = '';
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
            <label for="username">Username:</label>
            <br>
            <input id="username" name="username" class="loginInput" type="text" />
            <br>
            <label for="pw">Password:</label>
            <br>
            <input id="pw" name="pw" type="password" class="loginInput"/>

            <br><br>
            <button name="logIn" class="logInButton">Log In</button>
            <button href="signUp.php" name="createUser" class="logInButton">Sign Up</button>
            <br><br>
            <span class="logInError"><?php echo $logInError; ?></span>
        </form>
    </div>
</body>

</html>