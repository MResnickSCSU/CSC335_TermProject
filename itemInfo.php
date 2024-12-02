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

    //echo "<script>console.log(".json_encode($quantity).")</script>";


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
                <a href="logOut.php" name="logOut" class="logInButton">Log Out</a>
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
                Quantity
                <div id="quantityButtons">
                    <button onclick="quantityMinus()">-</button>
                    <span id="quantity">0</span>
                    <button onclick="quantityPlus()">+</button>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    let quantity = 0;
    let quantityDisplay = document.getElementById("quantity");

    function quantityMinus() {
        if (quantity == 0) {return}
        quantity--;
        quantityDisplay.innerText = ""+quantity;
    }
    function quantityPlus() {
        quantity++;
        quantityDisplay.innerText = ""+quantity;
    }

</script>