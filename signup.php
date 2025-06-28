<?php
$fname="";
$lname="";
$email="";
$sex="";
$password1="";
$password2="";
$err=array();
$congra="";
//create database connctivity
$conn=mysqli_connect("localhost","root","","db");
if(isset($_POST["signup"])){
    $fname=mysqli_real_escape_string($conn,$_POST["fname"]);
    $lname=mysqli_real_escape_string($conn,$_POST["lname"]);
    $email=mysqli_real_escape_string($conn,$_POST["Email"]);
    $sex=mysqli_real_escape_string($conn,$_POST["sex"]);
    $password1=mysqli_real_escape_string($conn,$_POST["password1"]);
    $password2=mysqli_real_escape_string($conn,$_POST["password2"]);
    
    //valiidation
    $uppercase=preg_match('@[A-Z]@',$password1);
    $lowercase=preg_match('@[a-z]@',$password1);
    $number=preg_match('@[0-9]@',$password1);
    $special=preg_match('@[^\w]@',$password1);
    $length=strlen($password1>8);
    if(!$uppercase || !$lowercase || !$number || !$special || !$length){
        array_push($err,"password must be contain at leat one uppercas and lower case letter numbers and special character");
    }
    if($password1!=$password2){
        array_push($err,"password is not match");
    }
    $user_check_query="select *from users where fname='$fname' or Email='$email' limit 1";
    $result=mysqli_query($conn,$user_check_query);
    $user=mysqli_fetch_assoc($result);
    if ($user) {
        if ($user['fname'] === $fname) {
            array_push($err, "Username already exists!");
        }
        if ($user['Email'] === $email) {
            array_push($err, "Email already exists!");
        }
    }
    if(count($err)===0){
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
        $query="insert into users(fname,lname,Email,sex,password) values('$fname','$lname','$email','$sex','$password1')";
        mysqli_query($conn, $query);
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>login system</title>
<link rel="stylesheet" href="css2/signup_style.css">
</head>
<body>
<div class="box2">
<h1>Signup here</h1>
<div class="err">
<?php
include "err.php";
?>
</div>
<?php
echo $congra
?>
<form action="signup.php" method="post">
<input type="text" name="fname" id="" placeholder="Enter first name" required>
<input type="text" name="lname" id="" placeholder="Enter last name" required>
<input type="email" name="Email" id="" placeholder="Enter your Email address" required>
<div class="sex-group">
<label>sex</label>
<input type="radio" name="sex" id="" value="male" required>Male
<input type="radio" name="sex" id="" value="female" required>Female
</div>
<input type="password" name="password1" id="" placeholder="Enter password" required>
<input type="password" name="password2" id="" placeholder="confirm password" required>

<input type="submit" value="signup" name="signup">Already a member?<a href="login.php" style="color:#ffc107;">Login</a>
</form>
</div>
</body>
</html>