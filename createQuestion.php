<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
  //Check if the post method was used
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Assign variables with intended information
    $question = $_POST['question'];
    $case1 = $_POST['case1'];
    $result1 = $_POST['result1'];
    $case2 = $_POST['case2'];
    $result2 = $_POST['result2'];
    
    //Check if variables are not empty
    if(!empty($question) && !empty($case1) && !empty($result1) && !empty($case2) && !empty($result2)){
      //Submit the information to the database with a query
      $query = "insert into CS490Questions (question, qCase1, qResult1, qCase2, qResult2) values ('$question', '$case1', '$result1', '$case2','$result2')";
      
      //Running query in the database
      mysqli_query($db,$query);
      //Redirect to question bank after it is created
      header("Location: questions.php");//Redirecting to the login page adter registration
      die;
      
    }else{
      echo "Please enter required information";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Creating Question</title>
</head>

<body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
  <a href="questions.php">Questions</a> | <a href="welcomeAdmin.php">Home</a>
  <h1>Please Enter Desired Question</h1><br>
  
  <form method="post">
    <label for="question">Enter question:</label><br>
    <input type="text" id="question" name="question"><br><br>
    
    <label for="case1">Enter first case:</label><br>
    <input type="text" id="case1" name="case1"><br><br>
    
    <label for="result1">Enter first result:</label><br>
    <input type="text" id="result1" name="result1"><br><br>
    
    <label for="case2">Enter second case:</label><br>
    <input type="text" id="case2" name="case2"><br><br>
    
    <label for="result2">Enter first result:</label><br>
    <input type="text" id="result2" name="result2"><br><br>
    
    <input type="submit" value="Submit">
  </form>
  
  
</body>
</html>