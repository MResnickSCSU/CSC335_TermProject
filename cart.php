<?php
session_start();
require 'functions.php';
    
    //echo "<script>console.log(".json_encode($cartItems).");</script>";

$cartItems = getCartItems();
addItems($cartItems); 

function addItems($cartItems) {
    global $results;
    global $totalPrice; 

    $results = '';
    $results .= '<div id="items">';
    foreach ($cartItems as $cartInfo) {
        $quantity = $cartInfo['count'];
        $item = getItem($cartInfo['item_id']);

        $totalPrice += $item['price']*$quantity;

        $results .= 
        '<div class="itemContainer">
            <img class="image" src="images/'.$item['image_path'].'">
            <div class="itemInfo">
                <span>'.$item['item_name'].' </span>
                <span> $'.$item['price'].' </span>
                <span> Color: '.ucfirst($item['color']).' </span>
                <span> Category: '.ucfirst($item['category']).' </span>
                <form method="post">
                    Quantity:
                    <button type="submit" name="minus" value='.$item['item_id'].'>-</button>
                    '.$quantity.'
                    <button type="submit" name="plus" value='.$item['item_id'].'>+</button>
                </form>
            </div>
        </div>';
        }
    }

    if (isset($_POST['plus'])) {
        header("Refresh:0");
        addItemToCart($_POST['plus']);
    }
    if (isset($_POST['minus'])) {
        header("Refresh:0");
        cartAmountSubstract($_POST['minus']);
    }

    if (isset($_POST['placeOrder'])) {
        placeOrder();
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="furniture.css"> 
        <link rel="stylesheet" href="cart.css"> 
        <title>
            Info
        </title>

    </head>
    <body>
        <div class="top">
            <div id="title">Furniture Store</div>
            <div class="accountButton">
                <a href="logOut.php" class="logInButton">Log Out</a>
            </div>
        </div>
        <div class="body">
            <div id="results">
                <?php echo $results ?>
                <div id="placeOrderContainer">
                    <form method="post">
                        <span id="totalPrice">Total: <?php echo $totalPrice ?></span>
                        <br>
                        <button type="submit" id="placeOrderButton" name="placeOrder">Place Order</button>
                    </form>
            </div>
        </div>
    </body>
</html>