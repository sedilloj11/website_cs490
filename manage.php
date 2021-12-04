<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db); //Check if the user is logged in and store its data into variable
  
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    header("Location: grading.php");//Redirecting to the login page adter registration
    die;
  }
  
?>

<!DOCTYPE html>
<html>
   
   <head>
      <title>Select Test to Grade</title>
      <link rel="stylesheet" type="text/css" href="style.css">
   </head>
   
   <body>
     
      <ul>
        <li><a href="welcomeAdmin.php">Home</a></li>
      </ul>
      
      <div class = "container">
      <h1>Choose a Test to Grade</h1>
      </div>
      
      <form action="grading.php" method="post" class = "takeTest">
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
                echo '<input type="radio" id="'. $nameRow['tName'] . '" name="selected_test" value="'. $row['test_id'] . '"/>';
                echo $nameRow['tName'] . " - Student ID: " . $row['student_id'];
                echo "<br><br>";
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
      
      <div style="text-align:center">
      <input type="submit" value="Submit">
      </div>
      </form>
      
   </body>
   
</html>