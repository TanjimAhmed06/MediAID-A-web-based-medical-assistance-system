<?php
session_start();
include '../includes/db_connect.php';

// Make sure patient is logged in
if (!isset($_SESSION['patient_logged_in'])) {
    header("Location: patient_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $disease_id = $_POST['disease_id'];
    $patient_id = $_SESSION['patient_id']; // from login session
    $today = date('Y-m-d'); // default appointment date is today
    $status = 'pending';

    // Insert appointment
    $sql = "INSERT INTO appointments (doctor_id, patient_id, disease_id, appointment_date, status)
            VALUES ('$doctor_id', '$patient_id', '$disease_id', '$today', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Appointment booked successfully!'); window.location='patient_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>