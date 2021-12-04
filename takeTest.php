<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    header("Location: test_builder.php");//Redirecting to the login page adter registration
    die;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Selecting Tests</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <style type="text/css">
  body{
  \
  }
  </style>
  
      <ul>
  <li><a href="takeTest.php">Take Test</a></li>
  <li><a href="viewTests.php">View Tests</a></li>
  <li><a href="logout.php">Logout</a></li>
  </ul>
  <h1>Select Tests</h1><br>
 
  
 
  <?php 
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Tests";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
  
    if($qCheck > 0){
    echo "<br><br>";
      while($row = mysqli_fetch_assoc($qResult)){
        echo '<input type="radio" id="'. $row['tName'] . '" name="selected_exam" value="'. $row['tName'] . '"/>';
        echo "<a href='test_builder.php?selected_exam=". $row['tName'] ."'>". $row['tName'] ."</a>";
        echo $row['tName'];
        echo "<br><br>";
      }
    }
    else{
      echo "<br><br>There are currently no existing tests.<br>";
    }
  ?>
  
 
  
  
</body>
</html>



  


