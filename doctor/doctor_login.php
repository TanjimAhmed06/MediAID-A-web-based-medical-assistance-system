<?php
session_start();
include '../includes/db_connect.php';
$error='';
if($_SERVER['REQUEST_METHOD']=='POST'){
	$email=$_POST["email"];
	$password=$_POST["password"];
	$query="SELECT * FROM doctors where email='$email'";
	$result=mysqli_query($conn,$query);

	if(mysqli_num_rows($result)==1){
		$row = mysqli_fetch_assoc($result);
        $id = $row['doctor_id'];
        $name = $row['name'];
		$status=$row['status'];
        $hashed_password = $row['password'];

		if (password_verify($password, $hashed_password)){
				if($status!='Approved'){
					$error= "Your account is not approved yet<br>";
				}
				else{
					$_SESSION['doctor_logged_in'] = true;
					$_SESSION['doctor_id']=$id;
					$_SESSION['doctor_name']=$name;
					header("Location:doctor_dashboard.php");
					exit;
				}
			}
		else{
			$error= "Incorrect Password<br>";
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
    <title>Doctor Log in</title>
    <style>

    	body{
    		min-height:90vh;
      		background-color:#E3F2FD;
      		display:flex;
      		justify-content:center;
      		align-items:center;
    	}
        .container{
      		display:flex;
      		box-shadow: 0 15px 50px rgba(0,0,0,0.1);
      		border-radius:15px;
      		overflow:hidden;
    	}
    	.left{
    		display: flex;
    		height: 520px;
    		width: 350px;
    		background-color:#f3f6ff;
    	}
    	.right{
    		display: flex;
    		height: 520px;
    		width: 650px;
    		background-color:#6dadff;
    		justify-content:center;
      		align-items:center;
    	}
    	p{  
      		font-weight:900;
      		font-weight: bolder;
      		color:white;
      		font-size:40px;
      		font-family:serif;
      		text-align:center;

    	}
    	p:hover{
      		color:#004aad;
    	}
    	input{
    		border-radius: 10px;
    		border:none;
    		outline:none;
    		padding: 25px;
    		width: 350px;
    		transition: all 0.5s ease;
    	}
    	input:focus{
      		box-shadow:0 0 10px rgba(191, 229, 252, 0.8);
      		transform:scale(1.05);
    	}
    	button{
    		border-radius: 10px;
    		background-color: white;
    		border:none;
    		outline: none;
    		padding: 15px;
    		width:399px ;
    		color:#6dadff;
    		font-size: 15px;
    		font-weight: 700;
    		font-weight: bolder;
    		font-family: serif;
    	}
    	button:hover{
      		background-color:#004aad;
      		color:white;
    	}
    	#fp{
    		padding: 5px;
    	}
    	#dhaa{
    		padding: 5px;
    	}
    	#checkbox{
    		align-content: left;
    	}

    </style>

  </head>
  <body>
  	<div class="container">

  		<div class="left">
  			<img src="doc_image.png" alt="Doctor img">
  		</div>
  		<div class=right>
  			<form method="post" action="doctor_login.php">
        		<p>Login To Your Account</p>
				<?php if(!empty($error)) { ?>
   				<p style="color:red; text-align:center;"><?php echo $error; ?></p>
				<?php } ?>
        		<input type="text" id="email" name="email" placeholder="enter your email" required><br><br>

        		<input type="password" id="password" name="password" placeholder="enter your password" required><br><br>
        		<button type="submit">Log In</button><br><br>
        		<a href="#" id="fp">Forgot Password?</a>
        		<a href="doctor_registration.php" id="dhaa">Don't Have An Account?</a>
        	</form>
  		</div>
  	</div>
      
  </body>
  <script src="script.js"></script>
</html>