<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch appointments for this doctor
$sql_appointments = "
SELECT a.appointment_id, a.appointment_date, a.status, p.name
FROM appointments a
JOIN patients p ON a.patient_id = p.patient_id
WHERE a.doctor_id='$doctor_id'
ORDER BY a.appointment_date ASC
";
$result_appointments = mysqli_query($conn, $sql_appointments);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background: #1976d2; color: #fff; }
    </style>
</head>
<body>

<h2>My Appointments</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Patient Name</th>
        <th>Date</th>
        <th>Status</th>
    </tr>

    <?php if(mysqli_num_rows($result_appointments) > 0): ?>
        <?php while($appt = mysqli_fetch_assoc($result_appointments)): ?>
        <tr>
            <td><?php echo $appt['appointment_id']; ?></td>
            <td><?php echo htmlspecialchars($appt['name']); ?></td>
            <td><?php echo $appt['appointment_date']; ?></td>
            <td><?php echo htmlspecialchars($appt['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">No appointments found</td></tr>
    <?php endif; ?>
</table>

</body>
</html>