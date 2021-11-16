<?php
function isLoggedIn($db)
{
  if(isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];
    //Query: select all entries from the table where the user id matches the session id limiting result to 1
    $query = "select * from CS490Users where user_id = '$id' limit 1";
    
    $result = mysqli_query($db, $query); //Run the query and store result into result variable
    if($result && mysqli_num_rows($result) > 0)
    {
      $dataOfUser = mysqli_fetch_assoc($result);//Fetches data of specific user 
      return $dataOfUser;
    }
  }
  //redirect to loggin if a sessiosn id is not set
  header("Location: login.php");
  die;
}

function random_id_num($length)
{

  $text = ""; //Creates empty string
  if($length < 5)
  {
    //If the length of the parameter is at least not 5 then set to 5
    $length = 5;
  }
  
  $actualLength = rand(4,$length);//Generate a random value between 4 and the parameter value
  for($i=0; $i <$actualLength; $i++)
  {
    //Iterate from 0 to generated random number
    $text .= rand(0,9);//append the result to text variable to form a user id for session
  }
  return $text;
}

function random_str_generator(){
  $alpha_num = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $generated_string = "";
  for($i = 0; $i < 10; $i++){
    $generated_string .= $alpha_num[rand(0, strlen($alpha_num) - 1)];
  }
  return $generated_string;
}

?>