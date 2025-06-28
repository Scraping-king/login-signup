<?php
$fname="";
$password="";
$err="";
$conn=mysqli_connect("localhost","root","","db");
if(isset($_POST["login"])){
    $fname=mysqli_real_escape_string($conn,$_POST["fname"]);
    $password=mysqli_real_escape_string($conn,$_POST["password"]);
    $sql="select *from users where fname='".$fname."' and password='".$password."' limit 1";
    
    $result=mysqli_query($conn,$sql);
    if(empty($fname)){
        $err="username is required!";
    }else if(empty($password)){
        $err="password is required!";
    }else if(mysqli_num_rows($result)==1){
        header('location:home.php');
    }else{
        $err="username or password error!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>login system</title>
<link rel="stylesheet" href="css2/login_style.css">
</head>
<body>
<div class="box">
<h1>Login here</h1>
<?php
echo $err;
?>
<form action="index3.html" method="post">
<input type="text" name="fname" id="" placeholder="Enter user name">
<input type="password" name="password" id="" placeholder="Enter password">
<input type="submit" value="login" name="login">Not yet a member?<a href="sign up.php" style="color:#ffc107;">SIGN UP</a>
</form>
</div>
</body>
</html>