



 
<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable

?>

<!DOCTYPE html>
<html>
<head>
  <title>Selecting Tests</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <style type="text/css">
  .view{
    margin: auto;
  background-color: white;
  overflow: auto;
  width: 900px;
  border-style: solid;
  border-width: 3px ;
  padding: 10px ;
 
  text-align: center;
  }
  body{
  
  }
  </style>
  
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="takeTest.php">Take Test</a></li>
        <li><a href="viewTests.php">View Tests</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>

  <?php 
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Tests";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
  
    if($qCheck > 0){
    
    echo "<div class = 'container'>";
    echo "<h1>Available Tests</h1>";
    echo "</div>";
    echo "<div class = 'view'>";
    
      while($row = mysqli_fetch_assoc($qResult)){
        
        echo "<a href='test_builder.php?selected_exam=". $row['tName'] ."'>• ". $row['tName'] ."</a><br>";

      }
      

    echo "</div>";
    }
    else{
      echo "<br><br>There are currently no existing tests.<br>";
    }
  ?>
  
</body>
</html>


