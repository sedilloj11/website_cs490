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
</head>

<body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
  <h1>Select Tests</h1><br>
  <a href="index.php">Home</a>
  
  <form action="test_builder.php" method="post">
  <?php 
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Tests";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
  
    if($qCheck > 0){
    echo "<br><br>";
      while($row = mysqli_fetch_assoc($qResult)){
        echo '<input type="radio" id="'. $row['tName'] . '" name="selected_exam" value="'. $row['tName'] . '"/>';
        echo $row['tName'];
        echo "<br><br>";
      }
    }
    else{
      echo "<br><br>There are currently no existing tests.<br>";
    }
  ?>
  
  <input type="submit" value="Submit">
  </form>
  
  
</body>
</html>


