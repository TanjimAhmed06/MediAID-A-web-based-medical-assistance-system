<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor details
$sql = "SELECT name, email, phone, specialty, hospital, status FROM doctors WHERE doctor_id='$doctor_id'";
$result = mysqli_query($conn, $sql);

$doctor = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e3f2fd;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            color: #0d47a1;
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-item {
            margin-bottom: 15px;
        }
        .profile-item label {
            font-weight: bold;
            color: #1976d2;
        }
        .profile-item span {
            margin-left: 10px;
            color: #333;
        }
        .edit-btn {
            display: block;
            width: 150px;
            margin: 20px auto 0;
            padding: 10px;
            background-color: #1976d2;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            transition: 0.3s;
        }
        .edit-btn:hover {
            background-color: #004aad;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Doctor Profile</h2>

    <div class="profile-item">
        <label>Name:</label>
        <span><?php echo htmlspecialchars($doctor['name']); ?></span>
    </div>

    <div class="profile-item">
        <label>Email:</label>
        <span><?php echo htmlspecialchars($doctor['email']); ?></span>
    </div>

    <div class="profile-item">
        <label>Phone:</label>
        <span><?php echo htmlspecialchars($doctor['phone']); ?></span>
    </div>

    <div class="profile-item">
        <label>Specialty:</label>
        <span><?php echo htmlspecialchars($doctor['specialty']); ?></span>
    </div>

    <div class="profile-item">
        <label>Hospital:</label>
        <span><?php echo htmlspecialchars($doctor['hospital']); ?></span>
    </div>

    <div class="profile-item">
        <label>Status:</label>
        <span><?php echo htmlspecialchars($doctor['status']); ?></span>
    </div>

    <a class="edit-btn" href="edit_profile.php">Edit Profile</a>
</div>

</body>
</html>