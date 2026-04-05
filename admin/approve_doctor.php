<?php
include '../includes/db_connect.php';

if(isset($_GET['id']) && isset($_GET['action'])){
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if($action == 'approve'){
        mysqli_query($conn, "UPDATE doctors SET status='Approved' WHERE doctor_id=$id");
    } elseif($action == 'reject'){
        mysqli_query($conn, "UPDATE doctors SET status='Rejected' WHERE doctor_id=$id");
    }

    header("Location: admin_dashboard.php"); // go back to dashboard
    exit;
}
?>