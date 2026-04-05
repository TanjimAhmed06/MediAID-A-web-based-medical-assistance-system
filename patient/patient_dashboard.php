<?php
session_start();
include '../includes/db_connect.php';

// Ensure patient is logged in
if(!isset($_SESSION['patient_logged_in'])){
    header("Location: patient_login.php");
    exit;
}

$patient_name = $_SESSION['patient_name'];
$patient_id = $_SESSION['patient_id'];

// Example: fetch some patient-specific data
$total_appointments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments WHERE patient_id='$patient_id'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Patient Dashboard</title>
	<style>
		*{
			margin:0;
			padding:0;
		}
		body{
			display: flex;
			background-color: #E3F2FD;
			flex-direction: column;
			min-height: 100vh;
			font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    		font-size: 16px;
		}
		header{
			display: flex;
			background-color:#0D47A1;
			height: 80px;
			justify-content: center;
			align-items: center;
			padding: 15px;
			box-shadow:0 0 5px rgba(0, 0, 0, 1); 
		}
		h2{
			font-size: 40px;
			color:white;
			margin-left: 25px;
		}
		.nav_item_ancor{
			text-decoration: none;
			color:#0D47A1;
			font-weight:bolder;
			margin-bottom: 10px;
			margin-left: 15px; 
    		margin-bottom: 5px;
    		transition: all 0.3s ease;
    		padding:5px 2px;
    		background-color:#AAFF00;
    		border-radius: 5px;
		}
		.left{
			display: flex;
			width:50%;
		}
		.right{
			display: flex;
			width:100%;
			margin-top:5px;
			margin-right: 5px; 
		}
		#logout{
            background-color:#FF8C00;
            color:white;
            border:none;
            padding:8px 15px;
            border-radius:5px;
            transition:0.3s;
            margin-left: 63%;
            height: 45px;
            width:95px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size:15px;
            font-weight: bolder;
            letter-spacing: 1px;
        }
        #logout:hover{
        	background-color: red;
        }
        .nav{
        	display: flex;
    		width: 350px;
    		height: 35px;
		}
		.nav_menu {
			display:flex;
    		border-width: 2px;
    		font-weight: 700;
    		text-transform: uppercase;
    		margin:0px;
    		padding: 0px; 
    		list-style: none;
		}
		.item_div{
			margin-top: 5px;
			margin-left:650px;
			padding-right: 10px;
			display: flex;
			width: 350px;
			height: 35px;
			justify-content: center;
			align-items: center;
		}
		.nav_item{
			transition: all 0.5s ease;
		}
		.nav_item:hover{
			transform:scale(1.09);
		}

		.left_side_menu_main_div{
			display: flex;
			background-color:#6495ED;
			height: 809px;
			width: 280px;
			box-shadow:0 1px 5px rgba(0, 0, 0, 1);
			align-items: center;
			justify-content: center; 
		}
		.left_side_menu{
			height:auto;
			width: 250px;
			display: flex;
			flex-direction:column;
			justify-content: center;
			align-items: center; 
			margin-top: 35px;
			margin-bottom: 300px;
			padding:5px;
			padding-top: 20px;
		}
		p{	background-color:#0D47A1;
			font-size:24px;
			padding: 10px;
			border:2.5px solid #AAFF00;;
			width:85%;
			border-radius: 7px;
			transition: all 0.5s ease;
			text-align: center;
		}
		p:hover{
			transform:scale(1.05);
		}
		.left_item_ancor{
			text-decoration: none;
			font-size:24px;
			color:white;
		}
	</style>
</head>
<body>	
<header>
	<div class="left">
		<h2>Welcome, <?php echo"$patient_name" ?></h2>
	</div>
	<div class="right">
		<nav class="nav">
			<ul class="nav_menu">
				<div class="item_div">
					<li class="nav_item"><a href="patient_dashboard.php" class="nav_item_ancor">home</a></li>
					<li class="nav_item"><a href="../contact_us.html" class="nav_item_ancor">contact</a></li>
					<li class="nav_item"><a href="../about_us.html" class="nav_item_ancor">about us</a></li>
					<li class="nav_item"><a href="../logout.php" class="nav_item_ancor">Log Out</a></li>
				</div>	
			</ul>
		</nav>
		<!-- <Button type="submit" id="logout">LOGOUT</Button> -->
	</div>
</header>
<div class="main">
	<div class="left_side_menu_main_div">
		<div class="left_side_menu">
			<p><a href="patient_dashboard.html" class=left_item_ancor>Dashboard</a></p><br>
			<p><a href="symptom_checker.php" class=left_item_ancor>Symptom Checker</a></p><br>
			<p><a href="symptom_checker.php" class=left_item_ancor>Find Doctor</a></p><br>
			<p><a href="symptom_checker.php" class=left_item_ancor>Book Appoinment</a></p><br>
		<p><a href="#" class=left_item_ancor>My Appoinment</a></p><br>
			<p><a href="../health_tips.html" class=left_item_ancor>Health Tips</a></p><br>
			<p><a href="patient_profile.php" class=left_item_ancor>Profile & Settings</a></p><br>
		</div>
	</div>
</div>
</body>
</html>