<?php
//session_start();

include("config.php");
if(!$db = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName))
{
  //If connection is not established with the database
  die("Connection failed");
}
?>