<?php 
    session_start();
    require 'functions.php';

    $allItems = getAllItems();
    addItems($allItems);

    function addItems($items) {
        global $results;
        $results = '';
        $results .= '<div id="items">';
        foreach ($items as $item) {
            $results .=   '<div class="itemContainer">
                                <form method="post">
                                    <img src="images/'.$item['image_path'].'" class="itemImage">
                                    <button type="submit" name="item" value="'.$item['item_id'].'" class="itemButton">'
                                        .$item['item_name'].'
                                        <br>
                                        $'.$item['price'].'
                                    </button>
                                </form>
                            </div>';
        }
        $results .= '</div>';
    }

    if (isset($_POST['item'])) {
        $_SESSION['itemId'] = $_POST['item'];
        header( 'Location: itemInfo.php' );
    }

    if (isset($_POST['filterButton'])) {
        if (!empty($_POST['category']) || !empty($_POST['color']) || !empty($_POST['minPrice']) || !empty($_POST['maxPrice'])) {
            $filterArray = array(
                "category"=> $_POST['category'],
                "color"=> $_POST['color'],
                "minPrice"=> $_POST['minPrice'],
                "maxPrice"=> $_POST['maxPrice'],
            );
            echo "<script>console.log(".json_encode($filterArray).")</script>";
            $items = categoryFilter($filterArray);
            if (empty($items)) {$results = "No Items Fitting Criteria";}
            else {addItems($items);}
        }
    }
?>


<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="furniture.css"> 
        <link rel="stylesheet" href="shopItems.css"> 
        <title>
            Homepage
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
            <div class="filter">
                <form role="form" action="" method="post">

                Category:
                <select id="select" name="category">
                    <option value="">-----</option>
                    <option value="sittings">Sittings</option>
                    <option value="chairs">Chairs</option>
                    <option value="tables">Tables</option>
                    <option value="lighting">Lighting</option>
                    <option value="decorations">Decorations</option>
                </select>
                <br><br>

                Color:
                <select id="select" name="color" value="sittings">
                    <option value="">-----</option>
                    <option value="white">White</option>
                    <option value="black">Black</option>
                    <option value="brown">Brown</option>
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="yellow">Yellow</option>
                    <option value="blue">Blue</option>
                    <option value="orange">Orange</option>
                    <option value="purple">Purple</option>
                    <option value="pink">Pink</option>
                </select>
                <br><br>

                Price: 
                <br>
                <input id="filterInput" type="number" min="0" name="minPrice" placeholder="Min">
                <input id="filterInput" type="number" min="0" name="maxPrice" placeholder="Max">
            
                <br><br>
                <button type="submit" name="filterButton">Filter</button>

                </form>
            </div>
            <div class="itemsContainer">
                <?php echo $results ?>
            </div>
        </div>
    </body>
</html>
