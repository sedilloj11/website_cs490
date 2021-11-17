<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db); //Check if the user is logged in and store its data into variable
  
?>

<!DOCTYPE html>
<html>
   
   <head>
      <title>Administrator Page</title>
   </head>
   
   <body>
     <style type="text/css">
      body{
        background-color: #b0aa8c;
      }
     </style>
      <h1>Welcome Instructor <?php echo $dataOfUser['username']; ?></h1>
      <h2>Admin Page - Options</h2> 
      <a href="questions.php">View Questions</a><br><br>
      <a href="createQuestion.php">Create Question</a><br><br>
      <a href="tests.php">View Tests</a><br><br>
      <a href="createTest.php">Create Test</a><br><br>
      <a href="manage.php">Grade Tests</a><br><br>
      
      <h2><a href = "logout.php">Sign Out</a></h2>
   </body>
   
</html>