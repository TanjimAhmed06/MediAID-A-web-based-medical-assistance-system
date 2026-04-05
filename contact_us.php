<?php
session_start();
include 'includes/db_connect.php';
$error="";
if($_SERVER['REQUEST_METHOD']=='POST'){
	$name = $_POST['name'] ?? "";
	$email = $_POST['email'] ?? "";
	$review= $_POST['review'] ?? "";

	$stmt = $conn->prepare("INSERT INTO review (name, email, review)
                                    VALUES (?, ?, ?)");
            $stmt->bind_param("sss",$name, $email,$review);
            if ($stmt->execute()) {
                 $success = "✅ Successfully Submitted";
            } else {
                $error = "❌ Error: " . $stmt->error;
            }
        $stmt->close();
}


// Ensure patient is logged in
// if(!isset($_SESSION['patient_logged_in'])){
//     header("Location: patient_login.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Contact Us</title>
	<style>
		*{
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
		}
		body{
      		background-color: #f4f9ff;
      		display: flex;
      		justify-content: center;
      		align-items: center;
      		min-height: 100vh;			
		}
		.container{
      		width: 100%;
      		padding: 40px;
      		display: flex;
      		justify-content: center;
      		align-items: center;
    	}
    	.contact_box{
      		background: white;
      		width: 800px;
      		max-width: 100%;
      		border-radius: 12px;
      		box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      		display: flex;
      		overflow: hidden;
    	}
    	.contact_info{
      		background:#1976D2;
      		color: white;
      		flex: 1;
      		padding: 30px;
      		display: flex;
      		flex-direction: column;
      		justify-content: center;

    	}    
    	.contact_info h2{
      		margin-bottom: 20px;
    	}

    	.contact_info p{
      		margin: 10px 0;
      		font-size: 14px;
    	}
    	.contact_form{
    		flex:1;
    		padding: 30px;
    	}
    	.contact_form h2{
     		margin-bottom: 20px;
      		color: #0D47A1;
    	}
    	input,textarea{
    		width:90%;
    		margin:10px 0px;
    		padding:10px;
    		border-radius: 6px;
    		border:1px solid;
    		font-size: 14px;
    	}
    	textarea{
    		height: 120px;
    	}
    	button{
      		background: #0D47A1;
      		color: white;
      		border: none;
      		padding: 12px;
      		border-radius: 6px;
      		width: 100%;
      		font-size: 16px;
      		cursor: pointer;
      		transition: 0.3s;
    	}
    	button:hover {
    		background: #1565C0;
	    }

	</style>
</head>
<body>

<div class="container">
  <div class="contact_box">

    <div class="contact_info">
      <h2>Get in Touch</h2>
      <p><strong>Address:</strong> Lakeview Drive,Uttara,Sector-17,Dhaka</p>
      <p><strong>Phone:</strong> +880 1234 567890</p>
      <p><strong>Email:</strong> support.mediaid@gmail.com</p>
      <p><strong>Hours:</strong> 24/7 Emergency Support</p>
    </div>

    <div class="contact_form">
      <h2>Send Message</h2>
      <form method="POST" action="contact_us.php">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="subject" placeholder="Subject">
        <textarea placeholder="Your Message" name="review" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>

  </div>
</div>

</body>
</html>