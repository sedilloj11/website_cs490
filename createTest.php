<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
  //Check if the POST method was used
  if($_SERVER['REQUEST_METHOD'] == "POST"){
  
    //Getting all submitted scores from text boxes
    $allScores = [];
    $submittedScores = $_POST['scores'];
    foreach($submittedScores as $score){
      if(!empty($score)){
        array_push($allScores, $score);
      }
    }
    
    //Getting array of checkboxes marked
    $testName = $_POST['testName'];
    $selectedQuestions = $_POST['qSelection']; //Getting array of selected options
    if(empty($selectedQuestions)){
      echo "No questions were selected.";
    }else{
      $numOfQuestions = count($selectedQuestions); //Getting number of selected questions
      $strOfQuestions = ""; //Declaring string for option information submission
      $strOfScores = "";
      for($j=0; $j<$numOfQuestions; $j++){
        if($j == $numOfQuestions - 1){
             $strOfQuestions .= $selectedQuestions[$j];
             $strOfScores .= $allScores[$j];
          
        }else{
            $strOfQuestions .= $selectedQuestions[$j];
            $strOfQuestions .= ",";
            $strOfScores .= $allScores[$j] . ",";
        }
      }
      
      if($strOfQuestions != "" && !empty($testName)){
        //Writing query
        $query = "insert into CS490Tests (tName, tQuestions, rScores) values ('$testName', '$strOfQuestions', '$strOfScores')";
        //Running query in the database
        mysqli_query($db,$query);
        //Redirect to question bank after it is created
        header("Location: welcomeAdmin.php");//Redirecting to the login page adter registration
        die;
      }
    }
    
  }
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Creating Test</title>
</head>

<body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
  <a href="questions.php">Questions</a> | <a href="welcomeAdmin.php">Home</a>
  <h1>Select Questions</h1><br>
  
  <form method="post">
  
    <label for="testName">Test Name:</label><br>
    <input type="text" id="testName" name="testName"><br><br>
    <?php
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Questions";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
    
    if($qCheck > 0){
    echo "<br><br>";
    $i = 1;
    $info = "";
      while($row = mysqli_fetch_assoc($qResult)){
        $info .= $i;
        echo '<input type="checkbox" name="qSelection[]" value="' . $info . '" />';
        $i = $i + 1;
        $info = "";
        echo $row['question'] . ". Points: ";
        echo '<input type="text" name="scores[]" id="scores" />';
        echo "<br><br>";
      }
    }
    ?>
    
    
    
    <input type="submit" value="Submit">
  </form>
  
  
</body>
</html>