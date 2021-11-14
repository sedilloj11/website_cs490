<?php


include("config.php");
$link = mysqli_connect(($dbHost,$dbUser,$dbPass,$dbName));
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
?>