
<?php


/////TODO: 


session_start(); //Requiring session to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  //$_SESSION['QuestionBank']  = array();
  //Check if the POST method was used

	  
//---------------------QUESTION FILTER SEARCH----------------
	
	if(isset($_POST['search'])) {
 	$diff = $_POST['diff'];
	$type = $_POST['type'];
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
//------CLEAR QUESTION BANK------------------- 
 
 
if(isset($_POST['clear'])){

    $_SESSION['QuestionBank']  = array();
}

//--------------REMOVE QUESTIONS------------------------
if(isset($_POST['remove'])){
   $selectedQuestions = $_POST['tSelection'];
    $x = sizeof($selectedQuestions);
    for($y =0; $y < $x; $y++){
      $id = $selectedQuestions[$y];
      echo $id;
      unset($_SESSION['QuestionBank'][$id]);
      $_SESSION['QuestionBank'] = array_values($_SESSION['QuestionBank']);
      
      }
  }
    
//---------------------ADD QUESTIONS----------------

 if(isset($_POST['add'])){
 
		
    //Getting all submitted scores from text boxes
    //Getting array of selected options
    $selectedQuestions = $_POST['qSelection']; 
    $submittedScores = $_POST['scores'];
    $submittedText = $_POST['qText'];
    $x = count($selectedQuestions);
    for($y =0; $y < $x; $y++){
    $QP = array("question"=> $selectedQuestions[$y], "points"=> $submittedScores[$y], "text"=> "$submittedText[$y]");
    print_r($QP);
    array_push($_SESSION['QuestionBank'], $QP);
 
    }
    $_POST = array();
    }
    
    //Getting array of checkboxes marked
//---------------------TEST SUBMISSION----------------
      if(isset($_POST['submit'])){
      $testName = $_POST['testName'];
      $strOfQuestions = ""; //Declaring string for option information submission
      $strOfScores = "";
      $max= sizeof($_SESSION['QuestionBank']); 
        for($i=0; $i<$max; $i++) {
           $case = ($_SESSION['QuestionBank'][$i]); 
           if($j == $numOfQuestions - 1){
             $strOfQuestions .= $case['question'];
             $strOfScores .= $case['points'];
          
        }else{
            $strOfQuestions .= $case['question'];
            $strOfQuestions .= ",";
            $strOfScores .= $case['points'] . ",";
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
    
  
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Creating Test</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
  
  .split 
  {
  margin:auto;
  width: 80%;
  overflow: auto;

	
   }
   .left 
   {
   background-color: #b0aa8c;
   border-style: inset;
   border-width: 3px ;
   width: 50%;
   margin:10px;
   float: left;
   
    

   }
   
   .right 
   {
   background-color: #b0aa8c;
   border-style: inset;
   border-width: 3px ;
   margin-top:10px;
   width: 45%;

   float: left;
  }
  </style>
</head>

<body>

  <ul>
    <li><a href="welcomeAdmin.php">Home</a></li>
    <li><a href="questions.php">Questions</a></li>
  </ul>
  
    <div class= "container">
  <h1>Select Questions</h1><br>
  <div class ="split">
  <div class ="left">
  <table border = "1">
  <form method="post">
  <tr>
	<label for="diff">Difficulty:</label>
	<select name="diff" id="diff">
		<option value="easy">Easy</option>
		<option value="medium">Medium</option>
		<option value="hard">Hard</option>
	</select>
	
	<label for="type">Type:</label>
	<select name="type" id="type">
			<option value="for">for loop</option>
		<option value="while">while loop</option>
		<option value="strings">Strings</option>
		<option value="conditionals">Conditionals</option>
		<option value="recursion">Recursion</option>
		<option value="other">Other</option>
	</select>
 </tr>
 <tr><td>
	
	<input type="submit" name="search" value="Filter">
  <input type="submit" name="add" value="add">
  
</td></tr>
    <?php
	
    //Retrieve all questions from the database
    //$query = "SELECT * FROM CS490Questions";
    //$qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
    
    if($qCheck > 0){
 
      while($row = mysqli_fetch_assoc($qResult)){
        echo"<tr>
           <td>";
        echo '<input type="checkbox" name="qSelection[]" value="' . $row['qID'] . '" ><br>'. $row['question'] .'<br></input>';
        echo '<label for="scores">Points:</label><br>';
        echo '<input type="text" name="scores[]" id="scores" />';
        echo '<input type= "hidden" name = "qText[]" value ="'. $row['question'] .'" />';
        echo"</td>
             </tr>";
        }
    }
    
    ?>

  </form>
  </table>
  </div>
  <div class = "right">
    <table>
    <form method = "POST">  
    <tr>
    <td> 
    <label for="testName">Test Name:</label><br>
    <input type="text" id="testName" name="testName">
    </tr>
    </td> 
    <?php
    $max= sizeof($_SESSION['QuestionBank']); 
    for($i=0; $i<$max; $i++) {
    echo"<tr>
     <td>";
    $case = ($_SESSION['QuestionBank'][$i]);
    echo '<input type="checkbox" name="tSelection[]" value= ' . $i . ' />'; 
    $case = ($_SESSION['QuestionBank'][$i]);
    echo $case['text'];
    echo ": ";
    echo $case['points'];
    echo "<br>";
    echo"</td>
     </tr>";
    }

     ?>
     <tr>
     <td>
     <input type="submit" name="remove" value="remove">
     <input type="submit" name="clear" value="clear">
     <input type="submit" name="submit" value="submit">
     </tr>
     </td>
  </form>
  </table>
  
</div>
</div>
</div>
  
</body>
</html>
