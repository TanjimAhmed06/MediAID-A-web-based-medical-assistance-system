<?php
session_start();
include '../includes/db_connect.php';
$error='';
if($_SERVER['REQUEST_METHOD']=='POST'){
	$name=$_POST["name"];
	$password=$_POST["password"];
	$query="SELECT * FROM admin where name='$name'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)==1){
		$row = mysqli_fetch_assoc($result);
        $id = $row['admin_id'];
        $name = $row['name'];
		if ($password==$row['password']){
            $_SESSION['admin_logged_in'] = true;
			$_SESSION['admin_id']=$id;
			$_SESSION['admin_name']=$name;
			header("Location:admin_dashboard.php");
			exit;
		}
		else{
			$error= "Your password is wrong";
		}
	}
	else{
		$error= "User not found<br>";
	}
	mysqli_close($conn);	
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
        body{
            min-height:100vh;
            background: linear-gradient(to right, #1e293b, #0f172a);
            display:flex;
            justify-content:center;
            align-items:center;
            margin:0;
            font-family: Arial, sans-serif;
        }

        .container{
            display:flex;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            border-radius:15px;
            overflow:hidden;
        }

        .left{
            width:350px;
            height:500px;
            background-color:#111827;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .left img{
            width:80%;
        }

        .right{
            width:500px;
            height:500px;
            background-color:#1e293b;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        form{
            text-align:center;
        }

        h2{
            color:white;
            margin-bottom:30px;
            font-size:30px;
        }

        input{
            width:320px;
            padding:15px;
            margin:10px 0;
            border:none;
            border-radius:8px;
            outline:none;
            transition:0.3s;
        }

        input:focus{
            box-shadow:0 0 10px rgba(59,130,246,0.7);
            transform:scale(1.05);
        }

        button{
            width:350px;
            padding:15px;
            border:none;
            border-radius:8px;
            background-color:#3b82f6;
            color:white;
            font-weight:bold;
            cursor:pointer;
            margin-top:10px;
            transition:0.3s;
        }

        button:hover{
            background-color:#2563eb;
        }

        a{
            display:block;
            color:#93c5fd;
            margin-top:10px;
            text-decoration:none;
        }

        a:hover{
            color:white;
        }

    </style>

</head>

<body>

    <div class="container">

        <div class="left">
            <img src="images/admin.png" alt="Admin">
        </div>

        <div class="right">
            <form method="POST" action="Admin_login.php">
                <h2>Admin Login</h2>
                <?php if(!empty($error)) { ?>
   				<p style="color:red; text-align:center;"><?php echo $error; ?></p>
				<?php } ?>
                <input type="text" name="name" placeholder="Admin Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>

                <button type="submit">Login</button>

                <a href="#">Forgot Password?</a>
                <a href="#">Create Admin Account</a>
            </form>
        </div>

    </div>

</body>
</html>