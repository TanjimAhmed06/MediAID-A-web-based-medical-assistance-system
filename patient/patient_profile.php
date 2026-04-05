<?php
session_start();
include '../includes/db_connect.php';

// Protect page
if(!isset($_SESSION['patient_logged_in'])){
    header("Location: patient_login.php");
    exit();
}

$id = $_SESSION['patient_id'];

// Fetch patient data
$result = mysqli_query($conn, "SELECT * FROM patients WHERE patient_id = $id");
$patient = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patient Profile</title>
<style>
body{font-family: Arial, sans-serif; background:#f0f2f5; margin:0; padding:0;}
.container{max-width:700px; margin:50px auto; background:white; padding:30px; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.1);}
h2{text-align:center; color:#1f4f7a;}
.profile-info p{font-size:16px; margin:10px 0;}
</style>
</head>
<body>
<div class="container">
    <h2>My Profile</h2>
    <div class="profile-info">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($patient['phone']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
        <p><strong>Blood Type:</strong> <?php echo htmlspecialchars($patient['blood_type']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
        <p><strong>District:</strong> <?php echo htmlspecialchars($patient['district']); ?></p>
        <p><strong>Registered At:</strong> <?php echo $patient['created_at']; ?></p>
    </div>
    <p style="text-align:center; margin-top:30px;">
        <a href="patient_settings.php" style="text-decoration:none; color:white; background:#2f80c7; padding:10px 20px; border-radius:5px;">Edit Profile / Settings</a>
        <a href="../logout.php" style="text-decoration:none; color:white; background:#e74c3c; padding:10px 20px; border-radius:5px; margin-left:10px;">Logout</a>
    </p>
</div>
</body>
</html>