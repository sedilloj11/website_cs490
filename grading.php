
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
  <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    .grade{
    margin: auto;
    width: 900px;
    }
    </style>


    </head>

    <body>
 
  <ul>
    <li><a href="welcomeAdmin.php">Home</a></li>
    <li><a href="manage.php">Select Test to Grade</a></li>
  </ul>
  
  
 <div class = "container">
  
    <?php
      //Retrieving from Database Test Info
      $testID = $_POST["selected_test"];
      $rCount = 0;
      
      $query = "SELECT * FROM `CS490Answers` WHERE `unique_id` = '$testID'" ;
      echo "<br>";
      
      $result = mysqli_query($db,$query);
      

        //points from cs490 tests
        $pointsQuery = "SELECT T.`rScores` , T.`tName` FROM `CS490Tests` T, `CS490Answers` A WHERE A.test_id = T.`tID` AND A.`unique_id` = '$testID' ";
        $pointsResult = mysqli_query($db,$pointsQuery);        
        $Points = mysqli_fetch_assoc($pointsResult);

        echo "<h2>".$Points['tName']."</h2> ";
        $P = explode(",",$Points['rScores']);
        
        echo '<div class = "grade">';
        //start table
            echo "<form method = 'POST' >";
            echo "<table border='1'>";
            
            //POST test uniqueID
            echo "<input type='hidden'  name='Tid' value='". $testID ."'>";
            echo"<tr>
            
            <th>Question</th>
            
            <th>Output</th>
            
            <th>Points</th>
            
            <th>Total</th>
            
            <th>Comments</th>
            
            </tr>";
       $c = 0;
      while($row = mysqli_fetch_assoc($result)){
        
        $originalAnswer = $row['answer'];//Variable created to preserve original answer. Use in: Displaying student answer
        $answer = $originalAnswer; //EDITABLE variable to use in: 1)Name checking and overwriting, 2)Script. REASON: if we keep only one variable, then if needed to be changed, we would lose the original answer
        $Qid = $row['question_id'];
        $Tid = $row['test_id'];
        //-----------------------Test 'answer' for keyword and topic---------------------------
        $errs ="";
        $deduction = 0;

        //Questions pull from Test 
        $questQuery = "SELECT * FROM CS490Questions WHERE qID = $Qid";
        $questResult = mysqli_query($db,$questQuery);
        $Q = mysqli_fetch_assoc($questResult);
        
        //=====================REPLACING NAME IF INCORRECT================================
        $qFuncName = $Q['keyword'];//NAME OF THE FUNCTION FROM QUERY
        $sFuncName = extractFunction($answer);//NAME OF THE FUNCTION FROM STUDENT ANSWER
        //At this point you can compare
        if($sFuncName == $qFuncName){
          //$errs .= "The function names match<br>"; //Do nothing
        }else{
          //Display message
          //echo "The function names do not match";
          $errs .= "-The function names do not match<br>";
          $deduction = $deduction + .25;
          //Change the name of the function to run the code without breaking
          $answer = str_replace($sFuncName, $qFuncName, $answer); //Corrected function name / Original submission overwritten
          //echo $answer;
        }
        //==============================================================================
        
        //======================CHECKING KEYWORD IN FUNCTION==========================
        $questionType = $Q['type'];
        //We will only check for inclusion if the problem demands it. Typically in a for or while loop. Recursion should be handled differently
        //1. Check if type of question is for or while loop | 2. Compare and respond accordingly
        if(strpos("for while recursion", $questionType) !== false){
          if($questionType == "recursion"){
            //HANDLE RECURSION
            //Check if function name appears more than one time
            //$qFuncName -> original name of the function, $answer -> modified, or not, answer from the student
            if(substr_count($answer, $qFuncName) > 1){
              //Recursion found
              //$errs .= "Recursion found<br>";
            }else{
              //Recursion was not found
              $errs .= "-Recursion NOT found<br>";
              $deduction = $deduction + .25;
            }
          }else{
            //HANDLE EITHER FOR OR WHILE KEYWORD CHECKING
              if(doesItContain($answer, $questionType)){
                //$errs .= $questionType . " is in solution<br>";
              }else{
                $errs .="-No ". $questionType . " in solution<br>";
                $deduction = $deduction + .25;
              }
          }
        }

        $question = $Q['question'];//question

        $C = explode(":",$Q['qCase1']);
        $R = explode(":",$Q['qResult1']);
     
 
        
        ///script builder
        $script = "#!/usr/bin/env python\n";
        $script .= $answer;
        foreach($C as $case){
        
            $script .= "\n";
            $script .= "print(". $case .")";
            $script .= "\n";
            }

       //write to file and run script
        $answerFile = "studentCD.py";
        file_put_contents($answerFile, $script);
        $output = null;
        $retval = null;
        exec('python studentCD.py', $output, $retval);
        if(!isset($retval)){
        $err .= "- script did not run<br>";
        }
  
        
        
        //compare script results with case results
        $point = 0; 
        $caseCount = count($C);
        $PpC = (1 / $caseCount);//PointperCase
        
        //deductions
       $d = $deduction * $P[$c];
       
        $correct = 0;
        for ($x = 0; $x < $caseCount; $x++){
             
              if($output[$x] == $R[$x]){
                  $point = $point + $PpC;
                  $correct = $correct + 1;
                }
                }
        ///table contents
          
          echo "<tr>";
        
          echo "<td>" . $question . "</td>";
        
          echo "<td>" . $originalAnswer . "<br>". $correct ."/" . $caseCount . "<br>". $errs . "</td>";
          
          echo "<td><input type='text' id = 'points".$c."' name='points[]' maxlength = '3' size='3' value=" . ($point * $P[$c] - $d) ." ></td>";
          echo"<input type='hidden'  name='Qid[]' value=". $Qid .">";
 
         
          echo "<td>" . $P[$c] . "</td>";
         
          echo "<td><textarea id = 'comments".$c."' name='comments[]' > </textarea></td>";
        
          

        
          echo "</tr>";
        
          $c++;
      }
      echo"<input type='hidden'  name='counter' value=". $c .">";
      echo "</table>";
      
      echo"<br><br><input type = 'checkbox' name = 'done' id = 'done' value='on'>";
      echo "<input type='submit'value='submit'>";
      echo "</form>";
    
    
    ?>
    </div>
    </div>
    <script>
 
    var textareas = document.getElementsByTagName('textarea');
    var count = textareas.length;
    for(var i=0;i<count;i++){
        textareas[i].onkeydown = function(e){
            if(e.keyCode==9 || e.which==9){
                e.preventDefault();
                var s = this.selectionStart;
                this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
                this.selectionEnd = s+1; 
            }
        }
    }

    </script>
    
    
  
  
    </body>
    
</html>
