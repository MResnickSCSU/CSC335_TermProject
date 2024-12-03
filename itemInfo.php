<?php
    session_start();
    require 'functions.php';
    $itemId = $_SESSION['itemId'];


    $item = getItem($itemId);
    $title = ucfirst($item['item_name']);
    $imagePath = $item['image_path'];
    $color = ucfirst($item['color']);
    $category = ucfirst($item['category']);
    $price = $item['price'];
    $description = ucfirst($item['description']);
    $amount_current = $item['amount_current'];


    if (isset($_POST['putHold']) && ($_POST['quantity'] !== 0)) { 
        for ($i = $_POST['quantity']; $i !== 0; $i--) {
            addItemToCart($itemId);
        }
        header( 'Location: cart.php' );
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="furniture.css"> 
        <link rel="stylesheet" href="itemInfo.css"> 
        <title>
            Info
        </title>

    </head>
    <body>
        <div class="top">
            <div id="title">Furniture Store</div>
            <div class="accountButton">
                <a href="cart.php" class="logInButton">Cart</a>
                <a href="logOut.php" class="logInButton">Log Out</a>
            </div>
        </div>
        <div class="body">
            <div class="itemInfoContainer">
                <div id="itemTitle"><?php echo $title ?></div>
                <br>
                <img id="image" src="images/<?php echo $imagePath?>">
                <div id="text">
                    <p> Color: <?php echo $color ?> </p>
                    <p> Category: <?php echo $category ?> </p>
                    <p> Description: <?php echo $description ?> </p>
                </div>  
                <div> $<?php echo $price ?> </div>
                <br>
                <form method="post">
                    Quantity:
                    <input type="number" name="quantity" id="quantity" min="0" max=<?php echo $amount_current ?>></input>

                    <input id="putHoldButton" type="submit" name="putHold" value="Add to Cart"> 
                </form>
            </div>
        </div>
    </body>
</html>