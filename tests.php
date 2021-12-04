<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
?>

<!DOCTYPE html>
<html>
<head>
  <title>Existing Tests</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <ul>
    <li><a href="welcomeAdmin.php">Home</a></li>
    <li><a href = "createTest.php">Create Test</a></li>
  </ul>
    
  <div class = "container">
  <h1>Existing Tests</h1><br>
  
  <div class = "listDisplay">
  <?php 
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Tests";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
  
    if($qCheck > 0){
    
      while($row = mysqli_fetch_assoc($qResult)){
        echo "• " . $row['tName'];
        echo "<br><br>";
      }
    }
    else{
      echo "<br><br>There are currently no existing tests.<br>";
    }
  ?>
  
  </div>
  </div>
  
</body>
</html>