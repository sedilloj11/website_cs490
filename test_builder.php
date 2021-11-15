<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  //echo $_POST["selected_exam"];
  $dataOfUser = isLoggedIn($db);//Assign information of the student. can retrieve id
  
  
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Get student_id, test_id, and questions
    $st_ID = $dataOfUser['id']; //STUDENT ID
    $test_ID = $_POST['s_test_id']; //TEST ID
    $questions_counter = $_POST['sub_answers_counter']; //COUNTER FOR SUBMITTED ANSWERS
    $q_counter = intval($questions_counter);
    $current_test_questions = $_POST['s_questions']; //STRING OF QUESTIONS USED
    $question_IDs = explode(",",$current_test_questions);
    
    
    //Traverse through each answer and evaluate them individually
    for($i = 0; $i < $q_counter - 1; $i++){
      //Look at current answer
      $answer_ID = "answer" . strval($i + 1);
      $currentAnswer = $_POST[$answer_ID];
     
      //Run exec here here and push into CS490Answers
      
      
      
    }
    
    
    //This, so far, has displahyed successfully
    echo "Student ID: " . $st_ID;
    echo "<br>";
    echo "Test ID: " . $test_ID;
    echo "<br>";
    echo "Current Test Questions: " . $current_test_questions;
    echo "<br>";
    
    
    /*
    //FIRST - Retrieve student_id============================================
    $st_id = $dataOfUser['id'];
    
    
    //SECOND - Retrieve test_id==============================================
    $test_name = $_POST["selected_exam"];
    $query = "SELECT * FROM CS490Tests WHERE tName='$test_name'";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);
    
    
    if($qCheck > 0){
      while($row = mysqli_fetch_assoc($qResult)){
        $t_id = $row['tID']; //Getting the current test ID
        $rawQ = $row['tQuestions']; //Getting all the questions
        $questions = explode(",", $rawQ);
        //Traverse questions to get corresponding IDs, and record answers as we are traversing.
        $test_q_number = 1;
        foreach($questions as $question_ID){
          //Get student answer
          $current_stdn_answer = $_POST['answer' . $test_q_number];
          //Check if the answer is not empty
          if(!empty($current_stdn_answer)){
            //Form code with student answer
            $answer = "#!/usr/bin/env python\n";
            $answer .= $current_stdn_answer;
            $answer .= "\n";
            
            //Get state cases
            $query = "SELECT * FROM CS490Questions WHERE qID = '$question_ID' ";
            $resultQ =  mysqli_query($db,$query);
            $checkQ = mysqli_num_rows($qResult);
            if($checkQ > 0){
              $qRow = mysqli_fetch_assoc($resultQ);
              $test_case_1 = $qRow['qCase1'];
              $test_case_2 = $qRow['qCase2'];
              $case_1_result = $qRow['qResult1'];
              $case_2_result = $qRow['qResult2'];
            }
            
            //Putting cases into array
            $allCases = array($case_1_result, $case_2_result);
            
            //Append function calls to the code
            $answer .= $test_case_1;
            $answer .= "\n";
            $answer .= $test_case_2; //At this point code is fully formed
            
            //Put code into python file
            file_put_contents("studentCD.py", $answer);
            
            //Execute python file and return answers
            $output = null;
            $retval = null;
            exec('python studentCD.py', $output, $retval);
            
            //Now evaluate with provided answers
            $q_answered_correctly = false;
            if(($output[0] == $allCases[0]) && ($output[1] == $allCases[1])){
              $q_answer_correctly = true;
            }
            
            $madeScore = 100;
            //insert information into the table
            if(!empty($st_id) && !empty($t_id) && !empty($question_ID) && !empty($current_stdn_answer)){
              if($q_answer_correctly == true){
                $final_query = "insert into CS490Answers (student_id, test_id, question_id, answer, qScore) values ('$st_id', '$t_id', '$question_ID', '$current_stdn_answer','$madeScore')";
              }
              else{
                $final_query = "insert into CS490Answers (student_id, test_id, question_id, answer, qScore) values ('$st_id', '$t_id', '$question_ID', '$current_stdn_answer','0')";
              }
              
              //Run query
              mysqli_query($db,$final_query);
              header("Location: index.php");//Redirecting to the login page adter registration
              die;
            }
            else{
              echo "One field of required information empty";
            }
            
            
          }
        }////////////////////////////////
      }
      
    }else{
      echo "Failed to retrieve test information";
    }
    //=======================================================================
    
    //THIRD - Retrieve Question ID===========================================
    //Traverse the submitted questions
    //Acquire answer per question
    //=======================================================================
    
  */
  }
  else{
    echo "ERROR POSTING INFORMATION";
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
  
  <form method="post">
  
    <?php
      //Retrieving from Database
      $testName = $_POST["selected_exam"];
      //echo $testName . "<br>";
      $query = "SELECT * FROM CS490Tests WHERE tName='$testName'";
      $qResult = mysqli_query($db,$query);
      $qCheck = mysqli_num_rows($qResult);
      
      
      //If the retrieval results in at least one row
      if($qCheck > 0){
        //echo $testName . "<br>";
        while($row = mysqli_fetch_assoc($qResult)){
          $questions_raw = $row['tQuestions']; //Getting question string from database | Should only be 1 entry at this point
          $test_information =  $row['tID']; //Getting test id information
        }
        $questions = explode(",",$questions_raw); //Splitting the questions by delimeter
        //echo $questions[0];
        //Retrieve the questions from database
        $counter = 1;
        foreach($questions as $question){
          //echo $question;
          $query = "SELECT * FROM CS490Questions WHERE qID = '$question' ";
          $resultQ =  mysqli_query($db,$query);
          $checkQ = mysqli_num_rows($qResult);
          if ($checkQ > 0){
            //If the query has returned an entries
            $qRow = mysqli_fetch_assoc($resultQ);
           // $qcase = "qCase" . strval($counter);
            //$qanswer = "qResult" . strval($counter);
            //$b1 = $qRow[$qcase];
            //$b2 = $qRow[$qanswer];
            //$t_case_and_answer = $b1 . "#" . $b2;
            echo $counter . ") " . $qRow['question'] . "<br>";
            echo '<textarea id="answer' . $counter . '" name="answer' . $counter . '"  rows="5" cols="50"></textarea>';
            //echo '<input type="hidden" id="t_case_2_2' . strval($counter) . '" name="t_case_a_' . strval($counter) . '" value="' . $t_case_and_answer . '">';
            
            echo "<br><br>";
            
            $counter++;
            
          }else{
            echo "Failed to retrieve question information";
          }
          
        }
      
      echo '<input type="hidden" id="s_questions" name="s_questions" value="' . $questions_raw . '">';
      echo '<input type="hidden" id="s_test_id" name="s_test_id" value="' . $test_information . '">';
      echo '<input type="hidden" id="sub_answers_counter" name="sub_answers_counter" value="' . $counter . '">';
      echo '<input type="submit" value="Submit">';
      
      } else{
        echo "There were no questions in this tests";
      }
      
      
      
    ?>
    
  </form>
  
  
</body>
</html>