<?php
include '../includes/db_connect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $phone = $_POST['phone'];
    $specialty = $_POST['speciality'];
    $hospital = $_POST['hospital'];
    $district = $_POST['district'];
    $available_time = $_POST['available_time'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO doctors (name, email, password, specialty, hospital, phone, district, available_time, gender)
            VALUES ('$name','$email','$hashed_password','$specialty','$hospital','$phone','$district','$available_time','$gender')";
if (mysqli_query($conn, $query)) {
    $success = "✅ Registration successful! Waiting for admin approval.";
} else {
    $error = "❌ Error: " . mysqli_error($conn);
}

mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Doctor Registration</title>
</head>
<body>
    <div class="main">
        <div class="doctor_registration_form">
            <div id="doc_header_text">
                <h2>Registration Form</h2>
                <div class="doc_image">
                    <img src="doctor.jpg" alt="" height="100px" width="100px">
                </div>
            </div>
            <div class="doctor_inputs">
                <form method="post" action="doctor_registration.php">
                    <label for="user">Username</label><br>
                    <input class="ip" type="text" id="user" name="username" required><br>
                    <label for="mail">Email</label><br>
                    <input class="ip" type="email" id="mail" name="email" required><br>
                    <label for="pass">Password</label><br>
                    <input class="ip" type="password" id="pass" name="password" required><br>
                    <label for="contact">Contact Number</label><br>
                    <input class="ip" type="number" id="contact" name="phone" required><br>
                    <label for="spec">Speciality</label><br>
                    <input class="ip" type="text" id="spec" name="speciality" required><br>
                    <label for="hospital">Hospital</label><br>
                    <input class="ip" type="text" id="hospital" name="hospital" required><br>
                    <label for="dis">District</label><br>
                    <input class="ip" type="text" id="dis" name="district" required><br>
                    <label for="atime">Available Time</label><br>
                    <input class="ip" type="time" id="atime" name="available_time" required><br><br>
                    <p>Choose your gender</p>
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Male</label><br>
                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Female</label><br>
                    <button type="submit" id="doc_reg_btn">Register</button>
                    <p style="font-size:smaller;">Already have an account.</p>
                    <br>
                    <a href="doctor_login.php" style="font-size:small">Sign in</a>
                </form>
            </div>
        </div>
       
    </div>
</body>
</html>