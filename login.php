<?php
session_start();

  include("dbConnect.php"); //requires file for connection to database
  include("functions.php"); //require file where functions are implemented
  
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    //Check is user has submitted information in the text boxes
    $username = $_POST['username']; //Acquire submitted username using POST
    $password = $_POST['password']; //Acquire submitted password using POST
    
    if(!empty($username) && !empty($password) && !is_numeric($username))
    {
      //If the username is not empty, and the password is not empty, and the username is not just numbers
      //Read the user information from the database
      
      //Query: select all entries from the CS490 where the username matches the one submitted by the user
      $query = "select * from CS490Users where username = '$username' limit 1";
      $qResult = mysqli_query($db,$query); //Using mysqli to run the query in the database and assign result
      
      //Begin comparison to determine is password entered matches the one in the database
      //If result from the query was acquired
      if($qResult)
      {
        //If query result was obtained and the number of rows is greater than 0, meaning there are entries
        if($qResult && mysqli_num_rows($qResult) > 0)
        {
          $dataOfUser = mysqli_fetch_assoc($qResult); //Retrieve data of user from the result and assign to variable
          //If the password submitted matches the saved hashed password in the database
          if(password_verify($password, $dataOfUser['password']))
          {
            $_SESSION['user_id'] = $dataOfUser['user_id']; //Assigned session id with the one from the database
            //Check for admin and normal users
            //if the isadmin value of the user is 1
            if($dataOfUser['isadmin'] == 1){
              //Administrators
              header("Location: welcomeAdmin.php");//Redirect to php file designated for admins
            }
            else{
              //Normal users
              header("Location: index.php"); //Redirect to php file designated for normal users
            }
            die;
          }
        }
      }
      
      echo "Either username or password is incorrect";//Display message if the query did not produce a result
      //Query not producing a result means incorrect information was given either for the username or password
    }else
    {
      echo "Enter correct information";//Displayed when info is not correct or is left empty
    }
  }
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
    color: black;
    padding: 10px;
    border: solid thin #000000;
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
        Login
      </div>
      <p style = "color:white">Username:<br>
      <input id = "text" type="text" name="username">
      <br>
      <br>
      Password:<br>
      <input id = "text" type="password" name="password">
      <br>
      <br>
      <input id = "button" type="submit" value="Submit">
      </p>
      <p style = "color:white">or</p>
      <a href="registration.php">Register</a><br>
    </form>
  </div>
</body>
</html>
