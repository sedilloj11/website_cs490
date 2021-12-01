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
</head>

<body>

  <style type="text/css">
  
  .view{
    margin: auto;
  background-color: white;
  width: 50%;
  border-style: solid;
  border-width: 3px ;
  padding: 10px ;
 
  text-align: ;left;
  }
  body{
  background-color: #b0aa8c;
  //add Style and formatting to tables
   
  }
  </style>
 
  <a href = "takeTest.php">Take Test</a> | <a href="index.php">Home</a>

<?php
echo "<p>hello $name</p>";
echo "<div class = 'view'>";
$query = "SELECT * FROM `CS490ExamRecords`  where student_id = '$id'";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
    //group by test Unique ID
    
      
      foreach($qResult as $test){
          $test_id  = $test['test_id'];
          $test_name  = $test['test_name'];
          $tQuery = "SELECT * FROM `CS490Answers`  where unique_id = '$test_id'";
          $tResult = mysqli_query($db,$tQuery);
          $tCheck = mysqli_num_rows($tResult);
          echo "<h4>". $test_name ." </h4>";
          echo "<table border='1'>
            <tr>
            
            <th>Question</th>
            
            <th>Answer</th>
            
            <th>Points</th>
            
            <th>Comments</th>
            
            </tr>";

          while($row = mysqli_fetch_assoc($tResult)){

            echo  "<tr>";
            echo  "<td>" . $row['question_id'] . "</td>"; 
            echo  "<td>" . $row['answer'] . "</td>";
            echo  "<td>" . $row['qScore'] . "</td>";
            echo  "<td>" . $row['comments'] . "</td>";
            echo   "</tr>";
       }
    
      
   echo "</table>";
      }
   
?>

</div>

 </body>
    
</html>


