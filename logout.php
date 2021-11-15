<?php
session_start();
//If the session id is set
if(isset($_SESSION['user_id']))
{
  //Unset the session id
  unset($_SESSION['user_id']);
}

header("Location: login.php");//Redirect to login page
die;

?>