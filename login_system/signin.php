<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
<?php 

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root."/components/navbar.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once("./dbconnect.php");
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "select password from users where username='$username'";
    $result = mysqli_query($conn,$sql);
    $result = $result->fetch_assoc()['password'];
    
    if($password == $result){
        echo '<div class="alert alert-success" role="alert">
            User Logged in
            </div>';
    }
}

?>
<form action="./signin.php" method="post">
  <div class="form-group">
    <label for="username">UserName</label>
    <input type="text" name="username" class="form-control" id="username_input" placeholder="Enter UserName">
  </div>
  <div class="form-group">
    <label for="pasword">Password</label>
    <input type="password" name="password" class="form-control" id="pass_input" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>


