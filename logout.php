<?php 
include_once "db.php";

session_start();

if (isset($_SESSION["loggedInUser"])) {
    session_destroy();
    header("location: login.php");
    exit;
}