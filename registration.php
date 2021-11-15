<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    //Getting information from submission of the user in the registration page
    $username = $_POST['username']; //Acquire submitted username using POST
    $password = $_POST['password']; //Acquire submitted password using POST
    
    //if the username, password are not empty and if the username name is just not numbers
    if(!empty($username) && !empty($password) && !is_numeric($username))
    {
      //Save submitted information into the database table
      $user_id = random_id_num(25); //Generating random user id for the user to use later for session id
      $hpass = password_hash($password, PASSWORD_DEFAULT);//Hashing password
      //Query: Insert into table the user id, username, and password in the respective columns
      $query = "insert into CS490Users (user_id, username, password) values ('$user_id', '$username', '$hpass')";
      mysqli_query($db,$query);//Running query in the database
      header("Location: login.php");//Redirecting to the login page adter registration
      die;
    }else
    {
      echo "Enter correct information";//Displayed if username or password is empty or username is just numbers
    }
  }
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
</head>
<body>

  <style type="text/css">
  body{
    background-color: #b0aa8c;
  }
  a:link {
    color: blue;
    background-color: transparent;
    text-decoration: none;
  }
  a:visited{
    color: green;
    background-color: transparent;
    text-decoration: none;
  }
  a:hover{
    color: red;
    background-color: transparent;
    text-decoration: none;
  }
  a:active{
    color: orange;
    background-color: transparent;
    text-decoration: none;
  }
  
  #text{
    height: 10px;
    border-radius:0px;
    padding: 10px;
    border: solid thin #000000;
    color: black;
  
  }
  
  #button{
    padding: 10px;
    width: 100px;
    color: white;
    background-color: #8d0000;
    border: none;
  }
  
  #box{
    background-color: #000000;
    margin: auto;
    width: 300px;
    padding: 50px;
  }
  
  #title{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 45px;
    margin: 30px;
    color: white;
    text-align: center;
  }
  
  </style>
  <div id="box">
    <form method="post">
      <div id = "title">
        Registration
      </div>
      <p style = "color:white">Username:<br>
      <input id = "text" type = "text" name = "username">
      <br>
      <br>
      Password:<br>
      <input id = "text" type = "text" name = "password">
      <br>
      <br>
      <input id = "button" type="submit" value="Submit">
      <br><br><a href="login.php">Back to Login</a><br>
    </form>
  </div>
</head>
</body>
</html>