<?php
include '../includes/db_connect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $phone = $_POST['phone'];
    $btype = $_POST['blood'];
    $district = $_POST['district'];
    $age = $_POST['age'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    if(strlen($password) < 6){
        $error = "Password must be at least 6 characters!";
    }
    else {
        // 🔍 Check if email exists
        $check = $conn->prepare("SELECT patient_id FROM patients WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if($check->num_rows > 0){
            $error = "Email already registered!";
        } 
        else {
            // 🔐 Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // ✅ Prepared statement (SAFE)
            $stmt = $conn->prepare("INSERT INTO patients (name, email, password, phone, age, blood_type, district, gender)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssisss", $name, $email, $hashed_password, $phone, $age, $btype, $district, $gender);
            if ($stmt->execute()) {
                 $success = "✅ Registration successful!";
            } else {
                $error = "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    }
        $conn->close();
}
?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Patient Registration</title>
</head>
<body>
    <div class="main">
        <div class="patient_registration_form">
            <div id="pat_header_text">
                <h2>Registration Form</h2>
                <div class="pat_image">
                    <img src="patient.jpg" alt="" height="100px" width="100px">
                </div>
            </div>
            <div class="patient_inputs">
                <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
                <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form method="post" action="patient_registration.php">
                    <label for="user">Username</label><br>
                    <input class='ip' type="text" id="user" name="username" required><br>
                    <label for="mail">Email</label><br>
                    <input class='ip' type="email" id="mail" name="email" required><br>
                    <label for="pass">Password</label><br>
                    <input class='ip' type="password" id="pass" name="password"required><br>
                    <label for="contact">Contact Number</label><br>
                    <input class='ip' type="text" id="contact" name="phone" required><br>
                    <label for="btype">Blood Type</label><br>
                    <input class='ip' type="text" id="btype" name="blood" required><br>
                    <label for="dis">District</label><br>
                    <input class='ip' type="text" id="dis" name="district"required><br>
                    <label for="age">Age</label><br>
                    <input class='ip' type="number" id="age" name="age"required><br>
                    <p>Choose your gender</p>
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Male</label><br>
                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Female</label><br>
                    <button type="submit" id="pat_reg_btn">Register</button>
                    <p style="font-size:smaller;">Already have an account.</p>
                    <br>
                    <a href="patient_login.php" style="font-size:small">Sign in</a>
                </form>
            </div>
        </div>
       
    </div>
</body>
</html>