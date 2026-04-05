<?php
session_start(); // Start session
include '../includes/db_connect.php';
$error="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    // Plain SQL query 
    $query = "SELECT patient_id, name, password FROM patients WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $id = $row['patient_id'];
        $name = $row['name'];
        $hashed_password = $row['password'];

        if(password_verify($password, $hashed_password)){
            // Successful login → create session
            $_SESSION['patient_logged_in'] = true;
            $_SESSION['patient_id'] = $id;
            $_SESSION['patient_name'] = $name;

            // Redirect to dashboard
            header("Location: patient_dashboard.php");
            exit();
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "User not found<br>";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patient Login</title>
<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#b7d7f0;
    font-family: Arial, sans-serif;
}
/* Main Box */
.container{
    width:900px;
    height:520px;
    background:white;
    border-radius:20px;
    display:flex;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
}
/* Left patient Section */
.left{
    width:45%;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}
.left img{
    width:115%;
    max-width:400px;
}
/* Right  Login Section */
.right{
    width:55%;
    padding:60px 50px;
    background:#f7fbff;
}
.right h1{
    text-align:center;
    color:#1f4f7a;
    margin-bottom:35px;
}
.input-box{
    width:90%;
    padding:15px;
    margin:13px 0;
    border-radius:30px;
    border:1px solid #cfd9e2;
    font-size:15px;
}
.forgot{
    text-align:right;
    display:block;
    margin-top:5px;
    color:#2a7acb;
    text-decoration:none;
    font-size:14px;
}
.login-btn{
    width:100%;
    padding:15px;
    margin-top:25px;
    border:none;
    border-radius:30px;
    background:linear-gradient(to right,#2f80c7,#2a6fb0);
    color:white;
    font-size:18px;
    cursor:pointer;
}
.signup{
    text-align:center;
    margin-top:30px;
    font-size:15px;
    color:#666;
}
.signup a{
    color:#2a7acb;
    text-decoration:none;
    font-weight:bold;
}
</style>
<h1><?php if($error != "") echo "<p style='color:red; text-align:center;'>$error</p>"; ?></h1>
</head>

<body>
    
<div class="container">

    <!-- Left patient Image -->
    <div class="left">
        <img src="patient_image.png" alt="Patient">
    </div>
    <!-- Right Login Form -->
    <div class="right">
        <h1 style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif"> Login</h1>

        <form method="POST" action="patient_login.php">
            <input class="input-box" type="text" name="email" placeholder="Email" required>
            <input class="input-box" type="password" name="password" placeholder="Password" required>

            <a href="#" class="forgot">Forget Password?</a>

            <button class="login-btn">Login</button>

            <div class="signup">
                Don’t have an account? <a href="../patient/patient_registration.php">Sign Up</a>
            </div>
        </form>
    </div>

</div>
</body>
</html>
