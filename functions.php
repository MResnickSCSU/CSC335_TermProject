<?php
//connection functions
function getConnection() {
	$conn = new mysqli("localhost", "root","password","projectdata");
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

//get all items 
function getAllItems() {
    $sql = "Select * from items;";
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