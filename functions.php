<?php
//connection functions
function getConnection() {
	$conn = new mysqli("localhost", "root","password", "furniture");
	if ($conn->connect_errno) {
        printf("Connection failed: %s\n", $conn->connect_error);
        exit();
        }
    return $conn;
}

function execSingleResult($sql) {
    $conn = getConnection();
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Database Error [{$conn->errno}] {$conn->error}");
    }
    $data = $result->fetch_assoc();
    $conn->close();
    return $data;
}

function execResults($sql) {
    $conn = getConnection();
    $data = array();
    $result = $conn->query($sql);

    while($row =$result->fetch_assoc()) {
    array_push($data, $row);
    }
    $conn->close();
    return $data;
}

function execNoResult($sql) {
    $conn = getConnection();
    $result = $conn->query($sql);
    if ($conn->error) {
    throw new Exception("Database Error [{$conn->errno}] {$conn->error}");
    }
    $conn->close();
    return;
}

//user functions
function createUser($fName, $lName, $username, $pw) {
    $sql = "insert into users (fName, lName, username, pw) VALUES ('".$fName."','".$lName."','".$username."','".$pw."')";
    execNoResult($sql);
}

function userCount($username) {
    $sql = "Select count(*) as cnt from users where username='".$username."'";
    return (int) execSingleResult($sql)["cnt"];
}

function checkLogin($username, $pw) {
    $sql = "Select username from users where username='".$username."' and pw='".$pw."'";
    return execResults($sql);
}

//get user id 

function getUserId($username){
    return execSingleResult("select user_id from users where username = '".$username."'")['user_id'];
}
//get all items 
function getAllItems() {
    $sql = "Select * from items where amount_current != 0";
    return execResults($sql);
}

//get single item
function getItem($itemId) {
    $sql = "Select * from items where item_id = ".$itemId;
    return execSingleResult($sql);
}

//filter functions
function categoryFilter($filterArray) {
    $count = 0;
    $sql = "Select * from items where";
    foreach ($filterArray as $filter => $value) {
        if (!empty($value)) {
            if ($count > 0) $sql .= "AND";
            if ($filter == "minPrice") {
                $sql .= " price >= {$value} ";
            }
            else if ($filter == "maxPrice") {
                $sql .= " price <= {$value} ";
            }
            else {
                $sql .= " {$filter} = '{$value}' ";
            }
            $count ++;
        }
    }
    echo "<script>console.log(".json_encode($sql).")</script>";
    return execResults($sql);
}

//put item on hold
function addItemToCart($itemId) {
    $userId = getUserId($_SESSION['username']);
    execNoResult("insert into cart (item_id, user_id) values (".$itemId.", ".$userId.")");
}
//get amount in cart from id 
function amountInCart($itemId) {
    return execSingleResult("select count(*) as count from cart where item_id = ".$itemId)['count'];
}
//get all items in cart 
function getCartItems() {
    $userId = getUserId($_SESSION['username']);
    $itemIdsQuery = execResults("select item_id from cart where user_id = ".$userId);

    //array of itemIds only one
    $itemIds = [];
    foreach ($itemIdsQuery as $itemId) {
        if (!in_array($itemId['item_id'], $itemIds)) {
            $itemIds[] = $itemId['item_id'];
        }
    }

    //get count of how many times itemId in cart 
    $results = [];
    foreach ($itemIds as $itemId) {
        $count = amountInCart($itemId);
        $results[] = ["item_id" => $itemId,
                      "count" => $count];
    }

    return $results;
}

//change cart amount 
function cartAmountSubstract($itemId) {
    $userId = getUserId($_SESSION['username']);
    $cartId = execSingleResult("select cart_id from cart where user_id = ".$userId." and item_id = ".$itemId." limit 1")['cart_id'];
    execNoResult("delete from cart where cart_id = ".$cartId);
}

//get available amount of item 
function availableAmount($itemId) {
    return execSingleResult("select amount_current from items where item_id = ".$itemId)['amount_current'];
}


//place full order
function placeOrder() {
    $userId = getUserId($_SESSION['username']);
    $items = execResults("select item_id from cart where user_id = ".$userId);

    foreach ($items as $item) {
        $itemId = $item['item_id'];
        execNoResult("insert into layaway values (".$userId.", ".$itemId.")");
        $amount = execSingleResult("select amount_current from items where item_id = ".$itemId)['amount_current'];
        $amount--;
        execNoResult("update items set amount_current = ".$amount." where item_id = ".$itemId);
    }

    execNoResult("delete from cart where user_id = ".$userId);
}

