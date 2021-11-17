
<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  //echo $_POST["selected_exam"];
  $dataOfUser = isLoggedIn($db);//Assign information of the student. can retrieve id
  
  

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
  <h1><?php echo $_POST["selected_test"]?></h1><br>
  

  
 
  
    <?php
      //Retrieving from Database
      $testID = $_POST["selected_test"];
      
      $query = "SELECT * FROM CS490Answers WHERE unique_id = $testID";
      $qResult = mysqli_query($db,$query);
      $qCheck = mysqli_num_rows($qResult);
      echo $qCheck;
    
      while($row = mysqli_fetch_assoc($qResult)){
        
        $answer = $row['answer'];
        $Qid = $row['question id'];
        echo $row["answer"];
        echo "<br>";
        echo $Qid;
      //Questions pull from CS490Questions using Qid from ^^^ to get 
        $questQuery = "SELECT * FROM CS490Questions WHERE qID = $Qid";
        $questResult = mysqli_query($db,$questQuery);
        $Q = mysqli_fetch_assoc($questResult);

        $question = $Q['question'];//question
        $c1 = $Q['qCase1'];//case1
        $r1 = $Q['qResult1'];//result1
        $c2 = $Q['qCase2'];//case2
        $c3 = $Q['qResult2'];//result2

        echo "<br>". $question ."|". $answer." <br>";
  


      }
    ?>
  
  
    </body>
    
</html>

