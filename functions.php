<?php
function isLoggedIn($db)
{
  if(isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];
    $query = "select * from CS490Users where user_id = '$id' limit 1";
    
    $result = mysqli_query($db, $query);
    if($result && mysqli_num_rows($result) > 0)
    {
      $dataOfUser = mysqli_fetch_assoc($result);
      return $dataOfUser;
    }
  }
  
  //redirect to loggin
  header("Location: login.php");
  die;
}

function random_id_num($length)
{

  $text = "";
  if($length < 5)
  {
    $length = 5;
  }
  
  $actualLength = rand(4,$length);
  for($i=0; $i <$actualLength; $i++)
  {
    $text .= rand(0,9);
  }
  return $text;
}
?>