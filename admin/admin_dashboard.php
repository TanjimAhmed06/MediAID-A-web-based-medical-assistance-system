<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: Admin_login.php");
    exit;
}

// Fetch stats
$total_doctors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM doctors"))['total'];
$pending_doctors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM doctors WHERE status='Pending'"))['total'];
$total_patients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM patients"))['total'];
$total_diseases = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM diseases"))['total'];

// Fetch recent doctors (last 5)
$recent_doctors = mysqli_query($conn, "SELECT * FROM doctors ORDER BY created_at DESC LIMIT 5");

// Fetch recent patients (last 5)
$recent_patients = mysqli_query($conn, "SELECT * FROM patients ORDER BY created_at DESC LIMIT 5");

// Fetch all diseases
$all_diseases = mysqli_query($conn, "SELECT * FROM diseases ORDER BY disease_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    background: #f4f7f8;
}
header {
    /* display:flex;
    justify-content:center;
    align-items:center; */
    position: sticky; /* keeps it on top */
    top: 0;
    z-index: 999;
    background: #0198ac;
    color: white;
    padding: 15px 20px;
    text-align: center;
    font-size: 24px;
}
header h1 {
    margin: 0;
    color: white;
}
.container {
    padding: 20px;
}
h1, h2 {
    color: #0198ac;
}
.stats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}
.card {
    background: white;
    padding: 20px;
    border-radius: 15px;
    flex: 1 1 200px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    text-align: center;
}
.card h3 {
    margin: 0;
    font-size: 18px;
    color: #555;
}
.card p {
    font-size: 32px;
    margin: 10px 0 0 0;
    font-weight: bold;
    color: #0198ac;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    text-align: left;
}
th {
    background: #e0f7fa;
}
a.button {
    padding: 5px 10px;
    background: #0198ac;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
a.button:hover {
    background: #007b99;
}
.scrollable {
    max-height: 300px;
    overflow-y: auto;
}
</style>
</head>
<body>
<header>
    <h1>Admin Dashboard</h1>
    <!-- <ul><li class="nav_item"><a href="../logout.php" class="nav_item_ancor">Log Out</a></li></ul> -->
    
</header>
<div class="container">
    <h2>Statistics</h2>
    <div class="stats">
        <div class="card">
            <h3>Total Doctors</h3>
            <p><?php echo $total_doctors; ?></p>
        </div>
        <div class="card">
            <h3>Pending Approvals</h3>
            <p><?php echo $pending_doctors; ?></p>
        </div>
        <div class="card">
            <h3>Total Patients</h3>
            <p><?php echo $total_patients; ?></p>
        </div>
        <div class="card">
            <h3>Total Diseases</h3>
            <p><?php echo $total_diseases; ?></p>
        </div>
    </div>

    <h2>Recent Doctors</h2>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Speciality</th><th>Status</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($recent_doctors)) { ?>
        <tr>
            <td><?php echo $row['doctor_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['specialty']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
            <?php if($row['status'] == 'Pending') { ?>
                <a href="approve_doctor.php?id=<?= $row['doctor_id']; ?>&action=approve" class="button">Approve</a>
                <a href="approve_doctor.php?id=<?= $row['doctor_id']; ?>&action=reject" class="button">Reject</a>
            <?php } else { ?>
                <!-- Optionally show text -->
                <span style="color: green; font-weight:bold;">Action Completed</span>
            <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h2>Recent Patients</h2>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Age</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($recent_patients)) { ?>
        <tr>
            <td><?php echo $row['patient_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['age']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>All Diseases</h2>
    <div class="scrollable">
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Symptoms</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($all_diseases)) { ?>
        <tr>
            <td><?php echo $row['disease_id']; ?></td>
            <td><?php echo $row['disease_name']; ?></td>
            <td><?php echo $row['symptoms']; ?></td>
        </tr>
        <?php } ?>
    </table>
    </div>

</div>
</body>
</html>