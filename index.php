<?php
session_start(); // MUST BE FIRST
include 'includes/db_connect.php'; // include files if needed

$sql = "SELECT name, review FROM review ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

$reviews = []; // initialize empty array
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediaid</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header id="mediaid_header">
        <div class="mediaid_header_content">
            <a href="../mediaid/index.html"><h2>Medi<span style="color: red;">AID</span></h2></a>
            <a href="../mediaid/index.html">Home</a>
            <a href="about_us.html">About Us</a>
            <a href="contact_us.php">Contact</a>
            <div class="dropdown">
                <a href="#">Login/Signup &#x25BC;</a>
                <div class="dropdown_menu">
                    <a href="../mediaid/patient/patient_login.php">Patient Login</a>
                    <a href="../mediaid/doctor/doctor_login.php">Doctor Login</a>
                    <a href="../mediaid/admin/Admin_login.php">Admin Login</a>
                    <a href="../mediaid/patient/patient_registration.php">Patient Registration</a>
                    <a href="../mediaid/doctor/doctor_registration.php">Doctor Registration</a>
                </div>
            </div>
        </div>
    </header>
    <div class="main">
        <div class="image1">
            <img src="main_body.jpg" alt="" class="main-image">
            <div class="text1">
                <h1>Welcome to MediAID</h1>
                <h2 id="typewriter"></h2>

                <script>
                    const texts = [
                    "Your Health, Simplified",
                    "Book Appointments Easily",
                    "Get Doctor Advice Online",
                    "Track Your Medical History"
                    ];

                    let count = 0;
                    let index = 0;
                    let currentText = '';
                    let letter = '';

                    (function type() {
                        if (count === texts.length) count = 0;
                        currentText = texts[count];
                        letter = currentText.slice(0, ++index);

                        document.getElementById('typewriter').textContent = letter;
                        if (letter.length === currentText.length) {
                            // Pause before deleting
                            setTimeout(() => {
                                (function erase() {
                                    letter = letter.slice(0, --index);
                                    document.getElementById('typewriter').textContent = letter;
                                    if (letter.length > 0) {
                                        setTimeout(erase, 50);
                                    } else {
                                        count++;
                                        index = 0;
                                        setTimeout(type, 500);
                                    }
                                })();
                            }, 1000);
                        } else {
                            setTimeout(type, 100);
                        }
                    })();
                </script>

                <style>
                #typewriter {
                    font-size: 24px;
                    color: white;
                    font-weight: bold;
                    min-height: 30px; /* prevents page shift during typing */
                    }
                </style>
                <!-- <p>Your Health, Simplified</p> -->
                 <br><br>
                <button id="mybutton1">Get Started</button>
            </div>
        </div>
    </div>
    <h1 style="text-align: center;padding-top: 10px;">Our <span style="color: blueviolet;">Services</span></h2>
    <div class="cards">
        <div class="card1">
            <button class="symptom-checker">Symptom Checker</button>
        </div>
        <div class="card2">
            <button class="health-tips">Health Tips</button>
        </div>
        <div class="card3">
            <button class="bmi">BMI Calculator</button>
        </div>

    </div>
    <h1 style="text-align: center;padding-top: 10px;">Our <span style="color: blueviolet;">Partners</span></h2>
    <div class="partners">
        <div class="partner1">
            <img src="https://upload.wikimedia.org/wikipedia/en/c/ca/World_University_of_Bangladesh_logo.jpg" alt="" height="300px">
        </div>
        <div class="partner2">
            <img src="https://seekvectorlogo.com/wp-content/uploads/2018/01/world-health-organization-vector-logo-small.png" alt="" height="300px">
        </div>
        <div class="partner3">
            <img src="https://cdn-dynmedia-1.microsoft.com/is/image/microsoftcorp/RWCZER-Legal-IP-Trademarks-CP-MS-logo-740x417-1?wid=297&hei=167&fit=crop" alt="" height="300px">
        </div>
    </div>
    <h1 style="text-align: center;padding-top: 10px;">Reviews From Our <span style="color: blueviolet;">Patients</span></h2>
    <div class="rating">
        <?php if(!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-card">
                    <h4><?php echo htmlspecialchars($review['name']); ?></h4>
                    <p>"<?php echo htmlspecialchars($review['review']); ?>"</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>
    <footer>
        <div class="footer-container">
            <!-- About Section -->
            <div class="footer-section about">
                <h3>MediAid</h3>
                <p>Your trusted online medical assistance platform connecting patients and doctors seamlessly.</p>
            </div>
    
            <!-- Quick Links -->
            <div class="footer-section links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="../mediaid/doctor/doctor_login.php">Doctor Login</a></li>
                    <li><a href="../mediaid/patient/patient_login.php">Patient Login</a></li>
                    <li><a href="about_us.html">About Us</a></li>
                    <li><a href="terms_&_condition.html">Terms and Conditions</a></li>
                </ul>
            </div>
    
            <!-- Contact Section -->
            <div class="footer-section contact">
                <h3>Contact</h3>
                <p>Email: support@mediaid.com</p>
                <p>Phone: +880 1234 567 890</p>
                <p>Address: Dhaka, Bangladesh</p>
            </div>
    
            <!-- Social Media -->
            <div class="footer-section social">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><img src="icons/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="icons/twitter.png" alt="Twitter"></a>
                    <a href="#"><img src="icons/instagram.png" alt="Instagram"></a>
                    <a href="#"><img src="icons/linkedin.png" alt="LinkedIn"></a>
                </div>
            </div>
        </div>
    
        <div class="footer-bottom">
            &copy; 2026 MediAid. All Rights Reserved.
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>

