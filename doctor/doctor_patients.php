<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch patients for this doctor
$sql_patients = "
SELECT DISTINCT p.patient_id, p.name, p.email, p.phone
FROM patients p
JOIN appointments a ON p.patient_id = a.patient_id
WHERE a.doctor_id='$doctor_id'
ORDER BY p.name ASC
";
$result_patients = mysqli_query($conn, $sql_patients);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Patients</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background: #1976d2; color: #fff; }
    </style>
</head>
<body>

<h2>My Patients</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>

    <?php if(mysqli_num_rows($result_patients) > 0): ?>
        <?php while($patient = mysqli_fetch_assoc($result_patients)): ?>
        <tr>
            <td><?php echo $patient['patient_id']; ?></td>
            <td><?php echo htmlspecialchars($patient['name']); ?></td>
            <td><?php echo htmlspecialchars($patient['email']); ?></td>
            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">No patients found</td></tr>
    <?php endif; ?>
</table>

</body>
</html>