<?php
include_once "db.php";
session_start();

if (!isset($_SESSION["loggedInUser"]) || $_SESSION["loggedInUser"]["role"] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $idDelete = $_POST['delete_id'];
    
    $deleteSql = "DELETE FROM campaigns WHERE id = :id";
    $delete = $conn->prepare($deleteSql);
    $delete->bindParam(':id', $idDelete);
    $delete->execute();
}

header("Location: index.php");
exit;
?>
