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
      <link rel="stylesheet" type="text/css" href="style.css">
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
      <h1>Welcome Instructor <?php echo $dataOfUser['username']; ?></h1>
      <h2>Administrator View</h2> 
      </div>
      
   </body>
   
</html>