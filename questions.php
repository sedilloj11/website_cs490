<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
?>

<!DOCTYPE html>
<html>
<head>
  <title>Existing Questions</title>
  <link rel="stylesheet" type="text/css" href="style.css">
<style>
  
  td{
background-color: white;
white-space: pre-wrap;

}
  table{
table-layout: auto;
margin: auto;
padding: 10px;
width: 400px;
text-align: left;
background-color: #b0aa8c;
  border-style: solid;
  border-width: 1px ;


}
    .view{
    margin: auto;
  background-color: white;
  overflow: auto;
  width: 700px;
  border-style: solid;
  border-width: 3px ;
  padding: 10px ;
 
  text-align: left;
  }
  </style>

</head>

<body>

  <ul>
    <li><a href="welcomeAdmin.php">Home</a></li>
    <li><a href="questions.php">View Questions</a></li>
    <li><a href="createQuestion.php">Create Question</a></li>
    <li><a href="tests.php">View Tests</a></li>
    <li><a href="createTest.php">Create Test</a></li>
    <li><a href="manage.php">Grade Tests</a></li>
    <li><a href = "logout.php">Sign Out</a></li>
  </ul>
  
  <div class = "container">
  <h1>Existing Questions</h1>
  </div>
  <div class = "view">
  <?php 
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Questions";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
    
    
    if($qCheck > 0){
    echo "<br>";
      while($row = mysqli_fetch_assoc($qResult)){
          $result_raw = $row['qResult1'];
          $case_raw = $row['qCase1'];
          $test_information =  $row['tID']; //Getting test id information
          $results = explode(":",$result_raw); //Splitting the questions by delimeter
          $cases = explode(":",$case_raw);
          $c = sizeof($results);
          echo "<table border = '1'>";
          echo"<tr><th>type</th><th>difficulty</th><th>keyword</th></tr>";
        echo"<tr><td>" . $row['type'] . "</td><td>". $row['difficulty'] . "</td><td>" . $row['keyword'] . "</td></tr>";
         echo "<tr><th>Question</th></tr>";
         echo "<tr><td colspan= '3'>" . $row['question'] ."</td></tr>";
        echo "<tr><th> case </th><th> result </th></tr>";
        for($x = 0;$x < $c; $x++){
        echo "<tr><td>" . $cases[$x] . "</td><td>" . $results[$x] . "</td></tr>";
        
        }
         echo "</table>"  ;      
        
        
        echo "<br><br>";
      }
    }
    else{
      echo "<br><br>There are currently no existing questions.<br>";
    }
  ?>
 
  </div>
  
  
</body>
</html>