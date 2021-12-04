<?php


/////TODO: 
//ADD SPLIT VIEW DISPLAY OF SELECTED QUESTIONS 



session_start(); //Requiring session to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
  //Check if the POST method was used
  if($_SERVER['REQUEST_METHOD'] == "POST"){
	  
	$diff = $_POST['diff'];
	$type = $_POST['type'];
	
	if(isset($_POST['search'])) {
		if($_POST['diff'] != '') {
			if($_POST['type'] != '') {
				$query = "SELECT * FROM CS490Questions WHERE difficulty ='".$diff."' AND type='".$type."'";
				$qResult = mysqli_query($db,$query);
			}
			else {
				$query = "SELECT * FROM CS490Questions WHERE difficulty ='.$diff.'";
				$qResult = mysqli_query($db,$query);
			}
		}
		else if($_POST['type'] != '') {
			$query = "SELECT * FROM CS490Questions WHERE type='%".$type."%'";
			$qResult = mysqli_query($db,$query);
		}
		else {
			$query = "SELECT * FROM CS490Questions";
			$qResult = mysqli_query($db,$query);
		}
	}
	else {
		$query = "SELECT * FROM CS490Questions";
		$qResult = mysqli_query($db,$query);
	}  
		
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
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <ul>
    <li><a href="welcomeAdmin.php">Home</a></li>
    <li><a href="questions.php">Questions</a></li>
  </ul>
  
  <div class = "container">
  <h1>TEST CREATION</h1><h2>Select Questions</h2>
  </div>
  
  
  
  <form method="post" class = "takeTest">
  
	<label for="diff">Filter Question Difficulty:</label><br>
	<select name="diff" id="diff">
		<option value="easy">Easy</option>
		<option value="medium">Medium</option>
		<option value="hard">Hard</option>
	</select><br><br>
	
	<label for="type">Filter Question Type:</label><br>
	<select name="type" id="type">
			<option value="for">for loop</option>
		<option value="while">while loop</option>
		<option value="strings">Strings</option>
		<option value="conditionals">Conditionals</option>
		<option value="recursion">Recursion</option>
		<option value="other">Other</option>
	</select><br><br>
	
	<input type="submit" name="search" value="Filter"><br><br>
  
    <label for="testName">Test Name:</label><br>
    <input type="text" id="testName" name="testName"><br><br>
    <?php
	
    //Retrieve all questions from the database
    //$query = "SELECT * FROM CS490Questions";
    //$qResult = mysqli_query($db,$query);
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
