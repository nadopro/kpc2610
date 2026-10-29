<?php

include "db.php";

$conn = connectDB();

$id = $_GET['id'] ?? '';

$id = trim($id);

if(strlen($id) < 4)
{
    echo "SHORT";
    closeDB($conn);
    exit;
}

$sql = "SELECT idx
        FROM users
        WHERE id='$id'";

$result = mysqli_query($conn, $sql);

if(mysqli_fetch_array($result))
{
    echo "EXIST";
}
else
{
    echo "OK";
}

closeDB($conn);

?>