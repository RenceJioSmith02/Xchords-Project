<?php

session_start();

require_once '../database.php';
$database = new Database();
$connection = $database->getConnection();

$query = "SELECT COUNT(DISTINCT PID) AS numItems FROM cart WHERE accountID = '".$_SESSION['UID']."'";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

echo "<span>".$row['numItems']."</span>";

?>
