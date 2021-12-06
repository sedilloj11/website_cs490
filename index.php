<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Index</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <style type="text/css">
  
  
  </style>
  
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="takeTest.php">Take Test</a></li>
      <li><a href="viewTests.php">View Tests</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  <div class = "container">
  <h1>Student Home<br><br>Welcome Student: <?php echo $dataOfUser['username']; ?></h1><br>
  </div>

</body>
</html>
