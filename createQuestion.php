<?php
//DISPLAY QUESTIONS AS BEING BUILT

session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  
  //Check if the post method was used
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
   <link rel="stylesheet" type="text/css" href="style.css">
  <style type="text/css">
  
  textarea{
  width: 90%;
  }
  p
  {
  background-color: white;
  }

  .split 
  {
  margin:auto;
  width: 80%;
  overflow: auto;

	
   }
   .left 
   {
   background-color: #b0aa8c;
   width: 50%;
   margin:10px;
   float: left;
    

   }
   
   .right 
   {
   background-color: #b0aa8c;
   width: 45%;
   margin:10px;
   float: left;
   
   }
  </style>
</head>

<body>

  
  <ul>
  <li><a href="welcomeAdmin.php">Home</a></li>
  <li><a href="createQuestions.php">Questions</a></li>
  </ul>
 
  <div class= "container">
    <h1>Please Enter Desired Question</h1>
      <div class = "split">
        <div class ="left">
      
        
        <form method="post">
        <table border ="1">
          <tr>
              <td>
              	<a><label for="diff">Select Question Difficulty:<br></label></a>
              	<select name="diff" id="diff">
            		<option value="easy">Easy</option>
            		<option value="medium">Medium</option>
            		<option value="hard">Hard</option>
              	</select>
              </td>
              <td>
              	<label for="type">Select Question Type:<br></label>
              	<select name="type" id="type">
            		<option value="for">for loop</option>
            		<option value="while">while loop</option>
            		<option value="strings">Strings</option>
            		<option value="conditionals">Conditionals</option>
            		<option value="recursion">Recursion</option>
            		<option value="other">Other</option>
            	  </select>
              </td>
            </tr>
            <tr>
             <td>
               <label for="keyword">Enter keyord result:<br></label>
               <input type="text" id="keyword" name="keyword">
              </td>
            </tr>
            <tr>
              <td colspan ="2">
                <label for="question">Enter question:<br></label>
                <textarea id="question" name="question"></textarea>
              </td>
            </tr>
            <tr>
              <td>
                <label for="case1">Enter first case:<br></label>
                <input type="text" id="case1" name="case[]">
              </td>
              <td>
                <label for="result1">Enter first result:<br></label>
                <input type="text" id="result1" name="result[]">
              </td>
            </tr>
            <tr>
              <td>
                <label for="case2">Enter second case:<br></label>
                <input type="text" id="case2" name="case[]">
              </td>
              <td>
                <label for="result2">Enter second result:<br></label>
                <input type="text" id="result2" name="result[]">
              </td>
            </tr>
            <tr>
              <td>
                <label for="case3">Enter third case:<br></label>
                <input type="text" id="case3" name="case[]">
              </td>
              <td>
                <label for="result3">Enter third result:<br></label>
                <input type="text" id="result3" name="result[]">
              </td>
            </tr>
            <tr>
              <td>
                <label for="case4">Enter fourth case:<br></label>
                <input type="text" id="case4" name="case[]">
              </td>
              <td>
                <label for="result4">Enter fourth result:<br></label>
                <input type="text" id="result4" name="result[]">
              </td>
            </tr>
            <tr>
              <td>
                <label for="case5">Enter fifth case:<br></label>
                <input type="text" id="case5" name="case[]">
              </td>
              <td>
                <label for="result5">Enter fifth result:<br></label>
                <input type="text" id="result5" name="result[]">                
              </td>
            </tr>
          </table>
          <input type="submit" value="Submit">
        </form>
        </div>
    
        <div class ="right">
        
        <table border = "1">
        <form method="post">
          <tr>
            <td>
          	<label for="diff">Filter Question Difficulty:</label><br>
          	<select name="diff" id="diff">
          		<option value="easy">Easy</option>
          		<option value="medium">Medium</option>
          		<option value="hard">Hard</option>
          	</select>
            </td>
            <td>
            	<label for="type">Filter Question Type:</label><br>
            	<select name="type" id="type">
         			<option value="for">for loop</option>
          		<option value="while">while loop</option>
          		<option value="strings">Strings</option>
          		<option value="conditionals">Conditionals</option>
          		<option value="recursion">Recursion</option>
          		<option value="other">Other</option>
          	  </select>
            </td>
          </tr>
        	<tr>
            <td>
        	    <input type="submit" name="search" value="Filter">
            </td>
          </tr>
         </form>
          <?php
        	
            $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query    
            if($qCheck > 0){
        
              while($row = mysqli_fetch_assoc($qResult)){
                echo "<tr> <td colspan = '2'>";
                echo "<p>".$row['question'] . "</p>";
                echo "</td> </tr>";
          
              }
            }
            ?>
          </table>
      	</div>
     </div>
   </div>
  
  
 
</body>
</html>
