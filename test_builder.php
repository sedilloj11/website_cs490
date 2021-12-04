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
    $done = false;
    
    if(!empty($questions_counter)){
      $done = true;
      $unique_test_id = random_str_generator();
      $test_info_query = "insert into CS490ExamRecords (test_id, student_id, test_name) values ('$unique_test_id', '$st_ID', '$test_ID')";
      mysqli_query($db,$test_info_query);
    }
    //Traverse through each answer and evaluate them individually
    for($i = 0; $i < $q_counter - 1; $i++){
      //Look at current answer
      $answer_ID = "answer" . strval($i + 1);
      $currentAnswer = $_POST[$answer_ID];
      $currentQuestion = $question_IDs[$i];
     
      //Insert entry into CS490 Answers
      if(!empty($st_ID) && !empty($test_ID) && !empty($currentQuestion) && !empty($currentAnswer)){
        
        //Query to put answers into CS490Answers
        $query = "insert into CS490Answers (student_id, test_id, unique_id, question_id, answer) values ('$st_ID', '$test_ID', '$unique_test_id', '$currentQuestion', '$currentAnswer')";
        //Running query
        mysqli_query($db,$query);
      }else{
        echo "Failed to insert entry.";
      }
      
    }
    if($done){
      header("Location: index.php");//Redirecting to the login page adter registration
      die;
    }
  }
  else{
    echo "ERROR POSTING INFORMATION";
  }
  

?>

<!DOCTYPE html>
<html>
<head>
  <title>Blanck Test</title>
  
<style>

body{
 
  
}
</style>
 <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
  <ul>
  <li><a href="takeTest.php">Take Test</a></li>
  <li><a href="viewTests.php">View Tests</a></li>
  <li><a href="logout.php">Logout</a></li>
  </ul>

  
 <br>
  
  <form method="post" class = "exam">
  
    <?php
      //Retrieving from Database
      $testName = $_GET["selected_exam"];
      echo"<h2>" . $testName . "</h2>";
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

            echo $counter . ") " . $qRow['question'] . "<br>";
            echo '<textarea id="answer' . $counter . '" name="answer' . $counter . '"  rows="5" cols="50"></textarea>';

            
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