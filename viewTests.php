<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
  $id = $dataOfUser['id'];
  $name = $dataOfUser['username'];
?>


<!DOCTYPE html>
<html>
<head>
  <title>View Tests</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <style type="text/css">


th,td{
background-color: white;
white-space: pre-wrap;

}
  table{
  table-layout: fixed;
margin: auto;
padding: 10px;
width: 700px;
text-align: left;
overflow: auto;
background-color: #b0aa8c;


}
  .view{
    margin: auto;
  background-color: white;
  overflow: auto;
  width: 900px;
  border-style: solid;
  border-width: 3px ;
  padding: 10px ;
 
  text-align: left;
  }
  body{
  background-color: #b0aa8c;
  //add Style and formatting to tables
   
  }
  </style>
 
    <ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="takeTest.php">Take Test</a></li>
  <li><a href="viewTests.php">View Tests</a></li>
  <li><a href="logout.php">Logout</a></li>
  </ul>

 <div class = "container">
<?php
echo "<h1>" . strtoupper($name) . " Test Records</h1>";
echo "</div>";
echo '<div class = "view">';
$query = "SELECT * FROM `CS490ExamRecords`  where student_id = '$id'";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
    //group by test Unique ID
    
      
      foreach($qResult as $test){
          $test_id  = $test['test_id'];
          $test_name  = $test['test_name'];
          
          //Queries
          $tQuery = "SELECT * FROM `CS490Answers`  where unique_id = '$test_id'";//Query for answer acquisition | A
          $tNameQuery = "SELECT * FROM `CS490Tests` WHERE tID='$test_name'";//Query for test name acquisition | B
          $tTotal = "SELECT * FROM `CS490ExamRecords` WHERE test_id = '$test_id'"; //Query for earned score acquisition | C
          
          //Running Queries
          $tResult = mysqli_query($db,$tQuery); //Assigning result: ANSWER INFORMATION | A
          $tNameResult = mysqli_query($db,$tNameQuery); //Assigning result: NAME OF TEST INFORMATION | B
          $tTotalResult = mysqli_query($db,$tTotal); //Assigning result: TOTAL SCORE INFORMATION | C
          
          //Checking Queries
          $tCheck = mysqli_num_rows($tResult); //CHECK THE ROWS OF QUERY RETRIEVED
          
          //Fetching Results from Queries
          $testFinalNameInfo = mysqli_fetch_assoc($tNameResult);//Gets row that has NAME OF TEST INFO | B
          $testTotalScoreInfo = mysqli_fetch_assoc($tTotalResult); //Gets row that has TOTAL SCORE INFO | C
          
          //Calculating Percentage Before Showcase
          $percentageEarned = ((float)$testTotalScoreInfo['score'] / (float)$testFinalNameInfo['possiblePoints']) * 100;
          
          echo "<table border='1'>
          <tablehead>
          <th>". $testFinalNameInfo['tName'] ." </th>
          <th>Score: ". number_format($percentageEarned,2,'.',',') . "% </th>
          <th>Points: ". $testTotalScoreInfo['score'] . " / ". $testFinalNameInfo['possiblePoints'] . " </th>
          </tablehead>
          
            <tr>
            
            <th>Question</th>
            
            <th>Answer</th>
            
            <th>Points</th>
            
            <th>Comments</th>
            
            </tr>";

          while($row = mysqli_fetch_assoc($tResult)){
          
          $questQuery = "SELECT * FROM CS490Questions WHERE qID =  " . $row['question_id'] ." ";
          $questResult = mysqli_query($db,$questQuery);
          $Q = mysqli_fetch_assoc($questResult);
          
          $question = $Q['question'];//question
          
          
            $totalPoints += (float)$row['qScore'];
            echo  "<tr>";
            echo  "<td>" . $question . "</td>"; 
            echo  "<td>" . $row['answer'] . "</td>";
            echo  "<td>" . $row['qScore'] . "</td>";
            echo  "<td>" . $row['comments'] . "</td>";
            echo   "</tr>";
       }
       
   
    
   echo "</table>";
   echo "<br>";
      }
   
?>

</div>

 </body>
    
</html>