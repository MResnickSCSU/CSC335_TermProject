<?php
session_start();
require 'functions.php';
    
    //echo "<script>console.log(".json_encode($cartItems).");</script>";

$cartItems = getCartItems();
if (empty($cartItems)) {
    global $results; 
    $results = "Cart Is Empty";
    header("Refresh: 3; url= index.php ");
}
else {addItems($cartItems);}

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
    $results .= 
    '<div id="placeOrderContainer">
            <form method="post">
                <span id="totalPrice">Total:'.$totalPrice.'</span>
                <br>
                <button type="submit" id="placeOrderButton" name="placeOrder">Place Order</button>
            </form>
    </div>';
    }

    if (isset($_POST['plus'])) {
        header("Refresh:0");
        if (amountInCart($_POST['plus']) == availableAmount($_POST['plus'])) {return;}
        else {addItemToCart($_POST['plus']);}
    }
    if (isset($_POST['minus'])) {
        header("Refresh:0");
        cartAmountSubstract($_POST['minus']);
    }

    if (isset($_POST['placeOrder'])) {
        placeOrder();
        header("Location: index.php");
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="furniture.css"> 
        <link rel="stylesheet" href="cart.css"> 
        <title>
            Cart
        </title>

    </head>
    <body>
        <div class="top">
            <a href="index.php" id="title">Furniture Store</a>
            <div class="accountButton">
                <a href="logOut.php" class="logInButton">Log Out</a>
            </div>
        </div>
        <div class="body">
            <div id="results">
                <?php echo $results ?>
            </div>
        </div>
    </body>
</html>