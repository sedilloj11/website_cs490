<?php
//DISPLAY QUESTIONS AS BEING BUILT

session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
  //Check if the post method was used
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Assign variables with intended information
    $question = $_POST['question'];
    //$case1 = $_POST['case1'];
    
      //points per question
    $allCases = [];
    $submittedCases = $_POST['case'];
    foreach($submittedCases as $case){
    array_push($allCases, $case);
    }
    
    $allResult = [];
    $submittedResult = $_POST['result'];
    foreach($submittedResult as $result){
    array_push($allResult, $result);
    }
    
      $numOfCases = count($allCases); //Getting number of selected questions
      $strOfCases = ""; //Declaring string for option information submission
      $strOfResults = "";
      for($j=0; $j<$numOfCases; $j++){
        if($j == $numOfCases - 1){
             $strOfCases .= $allCases[$j];
             $strOfResults .= $allResult[$j];
          
        }else{
            $strOfCases .= $allCases[$j];
            $strOfCases .= ":";
            $strOfResults .= $allResult[$j] . ":";    
            }
    
    }

	$diff = $_POST['diff'];
	$type = $_POST['type'];
  $keyword = $_POST['keyword'];
    
    //Check if variables are not empty
    if(!empty($question) && !empty($allCases) && !empty($allResult)  && !empty($diff) && !empty($type)){
      //Submit the information to the database with a query
      $query = "insert into CS490Questions (question, keyword, difficulty, type, qCase1, qResult1) values ('$question','$keyword', '$diff', '$type', '$strOfCases', '$strOfResults')";
      
      //Running query in the database
      mysqli_query($db,$query);
      //Redirect to question bank after it is created
      header("Location: questions.php");//Redirecting to the login page adter registration
      die;
      
    }else{
      echo "Please enter required information";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Creating Question</title>
</head>

<body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  </style>
  <a href="questions.php">Questions</a> | <a href="welcomeAdmin.php">Home</a>
  <h1>Please Enter Desired Question</h1><br>
  
  <form method="post">
  <table border ="1">
  <tr>
    <td>
    <label for="question">Enter question:</label>
    <textarea id="question" name="question"></textarea>
    </td>
    </tr>
     <tr>
    <td>
    <label for="case1">Enter first case:</label>
    <input type="text" id="case1" name="case[]">
    </td>
    <td>
    <label for="result1">Enter first result:</label>
    <input type="text" id="result1" name="result[]">
    </td>
    </tr>
    <tr>
    <td>
    <label for="case2">Enter second case:</label>
    <input type="text" id="case2" name="case[]">
    </td>
    <td>
    <label for="result2">Enter second result:</label>
    <input type="text" id="result2" name="result[]">
    </td>
    </tr>
    <tr>
    <td>
    <label for="case3">Enter third case:</label>
    <input type="text" id="case3" name="case[]">
    </td>
    <td>
    <label for="result3">Enter third result:</label>
    <input type="text" id="result3" name="result[]">
    </td>
    </tr>
    <tr>
    <td>
    <label for="case4">Enter fourth case:</label>
    <input type="text" id="case4" name="case[]">
    </td>
    <td>
    <label for="result4">Enter fourth result:</label>
    <input type="text" id="result4" name="result[]">
    </td>
    </tr>
    <tr>
    <td>
    <label for="case5">Enter fifth case:</label>
    <input type="text" id="case5" name="case[]">
    </td>
    <td>
    <label for="result5">Enter fifth result:</label>
    <input type="text" id="result5" name="result[]">                
    </td>
    </tr>
    <tr>
    <td>
	<label for="diff">Select Question Difficulty:</label>
	<select name="diff" id="diff">
		<option value="easy">Easy</option>
		<option value="medium">Medium</option>
		<option value="hard">Hard</option>
	</select><br><br>
  </td>
  <td>
     <label for="keyword">Enter keyord result:</label>
    <input type="text" id="keyword" name="keyword">
	</td>
  <td> 
	<label for="type">Select Question Type:</label>
	<select name="type" id="type">
		<option value="for">for loop</option>
		<option value="while">while loop</option>
		<option value="strings">Strings</option>
		<option value="conditionals">Conditionals</option>
		<option value="recursion">Recursion</option>
		<option value="other">Other</option>
	</select><br><br>
    </td>
    </tr>
    </table>
    <input type="submit" value="Submit">
  </form>
  
  
 
</body>
</html>
