<?php
session_start();
include '../includes/db_connect.php';
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit;
}
$doctor_name=$_SESSION['doctor_name'];
$doctor_id = $_SESSION['doctor_id'];
$today = date('Y-m-d');
$sql = "
SELECT a.appointment_id, a.appointment_date, a.status, p.name
FROM appointments a
JOIN patients p ON a.patient_id = p.patient_id
WHERE a.doctor_id='$doctor_id' AND a.appointment_date='$today'
ORDER BY a.appointment_date ASC
";

$result = mysqli_query($conn, $sql);
// Today's Patients
$q1 = "SELECT COUNT(DISTINCT patient_id) as total 
       FROM appointments 
       WHERE doctor_id='$doctor_id' AND appointment_date='$today'";
$r1 = mysqli_query($conn, $q1);
$today_patients = mysqli_fetch_assoc($r1)['total'] ?? 0;

// Total Patients
$q2 = "SELECT COUNT(DISTINCT patient_id) as total 
       FROM appointments 
       WHERE doctor_id='$doctor_id'";
$r2 = mysqli_query($conn, $q2);
$total_patients = mysqli_fetch_assoc($r2)['total'] ?? 0;

// Appointments Today
$q3 = "SELECT COUNT(*) as total 
       FROM appointments 
       WHERE doctor_id='$doctor_id' AND appointment_date='$today'";
$r3 = mysqli_query($conn, $q3);
$appointments_today = mysqli_fetch_assoc($r3)['total'] ?? 0;

// Pending Reports
$q4 = "SELECT COUNT(*) as total 
       FROM reports 
       WHERE doctor_id='$doctor_id' AND status='pending'";
$r4 = mysqli_query($conn, $q4);
$pending_reports = mysqli_fetch_assoc($r4)['total'] ?? 0;

// Appointment List
$q5 = "SELECT * FROM appointments 
       WHERE doctor_id='$doctor_id' AND appointment_date='$today'";
$appointments = mysqli_query($conn, $q5);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            display:flex;
            min-height:100vh;
            font-family: Arial, sans-serif;
            background-color:#e3f2fd;
        }

        /* SIDEBAR */
        .sidebar{
            width:250px;
            background:#0d47a1;
            color:white;
            padding:20px;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:30px;
        }

        .menu a{
            display:block;
            padding:12px;
            margin:10px 0;
            background:#1565c0;
            color:white;
            text-decoration:none;
            border-radius:6px;
            transition:0.3s;
        }

        .menu a:hover{
            background:#42a5f5;
        }

        /* MAIN */
        .main{
            flex:1;
            display:flex;
            flex-direction:column;
        }

        /* HEADER */
        .header{
            background:#1976d2;
            color:white;
            padding:15px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        #logout{
            background:#ef5350;
            border:none;
            padding:10px 15px;
            color:white;
            border-radius:5px;
            cursor:pointer;
        }

        #logout:hover{
            background:#d32f2f;
        }

        /* CARDS */
        .cards{
            display:flex;
            gap:20px;
            padding:20px;
            flex-wrap:wrap;
        }

        .card{
            flex:1;
            min-width:200px;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 5px 10px rgba(0,0,0,0.1);
        }

        .card h3{
            margin-bottom:10px;
            color:#0d47a1;
        }

        .card p{
            font-size:22px;
            font-weight:bold;
        }

        /* TABLE */
        .table-section{
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
        }

        th, td{
            padding:12px;
            text-align:center;
        }

        th{
            background:#1976d2;
            color:white;
        }

        tr:nth-child(even){
            background:#f1f5f9;
        }

    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Doctor Panel</h2>

        <div class="menu">
            <a href="doctor_dashboard.php">Dashboard</a>
            <a href="doctor_patients.php">My Patients</a>
            <a href="doctor_appointments.php">Appointments</a>
            <a href="#">Prescriptions</a>
            <a href="#">Reports</a>
            <a href="doctor_profile.php">Profile</a>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header">
            <h3>Welcome, Dr. <?php echo"$doctor_name"?></h3>
            <a href="logout.php"><button id="logout">Logout</button></a>
        </div>

        <!-- CARDS -->
        <div class="cards">
            <div class="card">
                <h3>Today's Patients</h3>
                <p><?php echo $today_patients; ?></p>
            </div>

            <div class="card">
                <h3>Total Patients</h3>
                <p><?php echo $total_patients; ?></p>
            </div>

            <div class="card">
                <h3>Appointments Today</h3>
                <p><?php echo $appointments_today; ?></p>
            </div>

            <div class="card">
                <h3>Pending Reports</h3>
                <p><?php echo $pending_reports; ?></p>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-section">
            <h3 style="margin-bottom:10px;">Today's Appointments</h3>

            <table>
    <tr>
        <th>ID</th>
        <th>Patient Name</th>
        <th>Date</th>
        <th>Status</th>
    </tr>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['appointment_id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['appointment_date']; ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No appointments today</td>
        </tr>
    <?php endif; ?>
</table>
        </div>

    </div>

</body>
</html>