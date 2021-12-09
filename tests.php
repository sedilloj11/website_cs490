<?php
session_start(); //Requiring sesssion to enter

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  $dataOfUser = isLoggedIn($db);//Check if the user is logged in and store its data into variable
?>

<!DOCTYPE html>
<html>
<head>
  <title>Existing Tests</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  
  <style>
  
  td{
background-color: white;
white-space: pre-wrap;

}
  table{
table-layout: auto;
margin: auto;
padding: 10px;
width: 400px;
text-align: left;
background-color: #b0aa8c;


}
    .view{
    margin: auto;
  background-color: white;
  overflow: auto;
  width: 700px;
  border-style: solid;
  border-width: 3px ;
  padding: 10px ;
 
  //text-align: left;
  }
  </style>
</head>

<body>

  <ul>
    <li><a href="welcomeAdmin.php">Home</a></li>
    <li><a href="questions.php">View Questions</a></li>
    <li><a href="createQuestion.php">Create Question</a></li>
    <li><a href="tests.php">View Tests</a></li>
    <li><a href="createTest.php">Create Test</a></li>
    <li><a href="manage.php">Grade Tests</a></li>
    <li><a href = "logout.php">Sign Out</a></li>
  </ul>
    
  <div class = "container">
  <h1>Existing Tests</h1><br>
  </div>
  <div class = "view">
  
  <form method = "post">
  <?php 
  
    //Retrieve all questions from the database
    $query = "SELECT * FROM CS490Tests";
    $qResult = mysqli_query($db,$query);
    $qCheck = mysqli_num_rows($qResult);//Will be set to the number of rows retrieved by the query
  
    if($qCheck > 0){
    
      while($row = mysqli_fetch_assoc($qResult)){
        echo '<table border = "1">';
       
        echo '<th><input type="checkbox" name="test_id[]" value= '. $row['tID'] .'  >' . $row['tName'] . '</th>';
        
        
          $questions_raw = $row['tQuestions']; //Getting question string from database | Should only be 1 entry at this point
          $scores_raw = $row['rScores'];
          $test_information =  $row['tID']; //Getting test id information
        
        $questions = explode(",",$questions_raw); //Splitting the questions by delimeter
        $scores = explode(",",$scores_raw);
        
        //Retrieve the questions from database
        $counter = 1;
        foreach($questions as $question){
          //echo $question;
          $query = "SELECT * FROM CS490Questions WHERE qID = '$question' ";
          $qr =  mysqli_query($db,$query);
          $cq = mysqli_num_rows($qr);
          if ($cq > 0){
            //If the query has returned an entries
            
            $qRow = mysqli_fetch_assoc($qr);
          
            echo "<tr><td>". $counter . "</td><td><p>" . $qRow['question'] . "</p></td><td><p>". $scores[$counter-1] ."</p></td></tr>";
           

            
            
            $counter++;
            
          }else{
           // echo "Failed to retrieve question information";
          }
          
        }
        
        
      }
    }
   
  ?>
   </table>
  <input type="submit" name="remove" value="remove">
  
  </form>
  </div>
  
  
</body>
</html>
