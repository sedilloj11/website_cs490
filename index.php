<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>After the logging page</title>
</head>

<body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
  <h1>Student Home</h1><br>
  Welcome Student <?php echo $dataOfUser['username']; ?><br><br><br>
  
  <a href="takeTest.php">Take Test</a><br><br>
  <a href="logout.php">Logout</a>
  
</body>
</html>