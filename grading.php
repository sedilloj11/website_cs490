
<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  //echo $_POST["selected_exam"];
  $dataOfUser = isLoggedIn($db);//Assign information of the student. can retrieve id
  
  
  ///HANDLING POST FROM FORM
  $check = ($_POST['done']);
  if(isset($check)){
    
    $tID = $_POST['Tid'];
    $counter = $_POST['counter'];
  
  //points per question
    $allScores = [];
    $submittedScores = $_POST['points'];
    foreach($submittedScores as $score){
        array_push($allScores, $score);
      
    }
   
    //comments per question
        $allComments = [];
    $submittedComments = $_POST['comments'];
    foreach($submittedComments as $comment){
        array_push($allComments, $comment);
    }
    //questions
    $questID = [];
    $submittedQuestions = $_POST['Qid'];
    foreach($submittedQuestions as $Question){
             array_push($questID, $Question);
    }
    
    $pointTotal = 0;
    for($x = 0;$x < $counter;$x++){
    $queryA = "UPDATE `CS490Answers` SET `comments`='". $allComments[$x] ."',`qScore`= '" . $allScores[$x] . "' WHERE `unique_id` = '". $tID ."' AND `question_id` = '". $questID[$x] ."' ";
          mysqli_query($db,$queryA);
          $pointTotal = $pointTotal + $allScores[$x];
    }
    $queryT = "UPDATE `CS490ExamRecords` SET `score`= '". $pointTotal . "' WHERE `test_id` = '". $tID ."' ";
    mysqli_query($db,$queryT);
  
    header("Location: welcomeAdmin.php");
    die;
  }
  
  

?>

<!DOCTYPE html>
<html>
<head>
  <title>Grade Test</title>
    </head>

    <body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
 
  
 <a href="manage.php">Manage</a> | <a href="welcomeAdmin.php">Home</a>
  
  
  
 
  
    <?php
      //Retrieving from Database Test Info
      $testID = $_POST["selected_test"];
      $rCount = 0;
      
      
      
      
      
      
      
      $query = "SELECT * FROM `CS490Answers` WHERE `unique_id` = '$testID'" ;
      echo "<br>";
      
      $result = mysqli_query($db,$query);
      
        
        //Need to do: 
        //1.Grab Student name
        //2.submit grade and test to db
        
        
        
        //points from cs490 tests
        $pointsQuery = "SELECT T.`rScores` , T.`tName` FROM `CS490Tests` T, `CS490Answers` A WHERE A.test_id = T.`tID` AND A.`unique_id` = '$testID' ";
        $pointsResult = mysqli_query($db,$pointsQuery);        
        $Points = mysqli_fetch_assoc($pointsResult);

        echo "<h2>".$Points['tName']."</h2><br> ";
        $P = explode(",",$Points['rScores']);
        
        
        //start table
            echo "<form method = 'POST'>";
            echo "<table border='1'>";
            
            //POST test uniqueID
            echo "<input type='hidden'  name='Tid' value='". $testID ."'>";
          echo"<tr>
            
            <th>Question</th>
            
            <th>Answer</th>
            
            <th>Points</th>
            
            <th>Total</th>
            
            <th>Comments</th>
            
            </tr>";
       $c = 0;
      while($row = mysqli_fetch_assoc($result)){
        
        $answer = $row['answer'];
        $Qid = $row['question_id'];
        $Tid = $row['test_id'];
        //echo "<br>";
        //echo $Qid;
      //Questions pull from Test 
        $questQuery = "SELECT * FROM CS490Questions WHERE qID = $Qid";
        $questResult = mysqli_query($db,$questQuery);
        $Q = mysqli_fetch_assoc($questResult);

        $question = $Q['question'];//question
        $c1 = $Q['qCase1'];//case1
        $r1 = $Q['qResult1'];//result1
        $c2 = $Q['qCase2'];//case2
        $r2 = $Q['qResult2'];//result2
        $cr =array($r1, $r2);

        
        
        ///script
        $script = "#!/usr/bin/env python\n";
        $script .= $answer;
        $script .= "\n";
        $script .= "print(".$c1.")";
        $script .= "\n";
        $script .= "print(".$c2.")";
        $script .= "\n";
        
        
       //write to file and run script
        $answerFile = "studentCD.py";
        file_put_contents($answerFile, $script);
        $output = null;
        $retval = null;
        exec('python studentCD.py', $output, $retval);
        
        
        //compare script results with case results
        $point = 0; 
        for ($x = 0; $x <2; $x++){
              if($output[$x] == $cr[$x]){
                  $point = $point + .5;
                }
        ///table contents
        }
          echo "<tr>";
        
          echo "<td>" . $question . "</td>";
        
          echo "<td>" . $answer . "</td>";
          
          echo "<td><input type='text' id = 'points".$c."' name='points[]' maxlength = '3' size='3' value=" . $point * $P[$c] ." ></td>";
          echo"<input type='hidden'  name='Qid[]' value=". $Qid .">";
 
          
         
          echo "<td>" . $P[$c] . "</td>";
          
          echo "<td><input type='text' id = 'comments".$c."' name='comments[]' ></td>";
          

        
          echo "</tr>";
        
          $c++;
      }
      echo"<input type='hidden'  name='counter' value=". $c .">";
      echo "</table>";
    echo"<input type = 'checkbox' name = 'done' id = 'done' value='on'>";
     echo "<input type='submit'value='submit'>";
    echo "</form>";
    
    
    ?>
  
  
    </body>
    
</html>

