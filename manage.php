<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db); //Check if the user is logged in and store its data into variable
  
  
?>

<!DOCTYPE html>
<html>
   
   <head>
      <title>Select Test to Grade</title>
      <link rel="stylesheet" type="text/css" href="style.css">
      
      <style>
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
      <h1>Choose a Test to Grade</h1>
      </div>
      
      <div  class ="view">
       <?php 
        //Retrieve all questions from the database
        
        $query = "SELECT * FROM CS490ExamRecords WHERE score is NULL";
        $qResult = mysqli_query($db,$query);
        $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
  
        if($qCheck > 0){
        echo "<br><br>";
          while($row = mysqli_fetch_assoc($qResult)){
            $t_currentID = $row["test_name"];
            $nameQuery = "SELECT * FROM CS490Tests WHERE tID=$t_currentID";
            $name_query_result = mysqli_query($db,$nameQuery);
            $name_query_check = mysqli_num_rows($name_query_result);
            if($name_query_check > 0){
              while($nameRow = mysqli_fetch_assoc($name_query_result)){
               
                echo "• ";
                echo "<a href='grading.php?selected_exam=". $row['test_id'] ."'>". $nameRow['tName'] . " - Student ID: " . $row['student_id'] ."</a>";
                }
            }
            else{
              echo "Failed to retrieve test information";
            }
            
          }
        }
        else{
          echo "<br><br>There are no tests to grade";
        }
      ?>
      
      </div>
      </div>
      
   </body>
   
</html>