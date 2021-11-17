grading.php

<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  //echo $_POST["selected_exam"];
  $dataOfUser = isLoggedIn($db);//Assign information of the student. can retrieve id
  
  
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $st_ID = $dataOfUser['id']; //STUDENT ID

    $testID = $_POST['selected_test'];
  
  
    if(!empty($testID)){
    // test is not valid
    }



?>

<!DOCTYPE html>
<html>
    <head>
  <title>Blanck Test</title>
    </head>

    <body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
  <h1><?php echo $_POST["selected_exam"]?></h1><br>
  
 
  
    <?php
      //Retrieving from Database
      $testID = $_POST["selected_exam"];
      //echo $testName . "<br>";
      $query = "SELECT * FROM CS490Answers WHERE unique_id='$testID'";
      $qResult = mysqli_query($db,$query);
      $qCheck = mysqli_num_rows($qResult);
      while($row = mysqli_fetch_assoc($qResult)){
        
        $answer = $row['answer']
      //Questions pull from CS490Questions using Qid from ^^^ to get 
        $questQuery = "SELECT * FROM CS490Questions Where qID = $row['question id']";
        $qResult = mysqli_query($db,$questQuery);
        $Q = $qresult->fetch_assoc();

        $question = $Q[1];//question
        $c1 = $Q[2];//case1
        $r1 = $Q[3];//result1
        $c2 = $Q[4];//case2
        $c3 = $Q[5];//result2

        echo "<br>". $question ."|". $answer." <br>";
  


      }
    ?>
  
  
    </body>
    
</html>

