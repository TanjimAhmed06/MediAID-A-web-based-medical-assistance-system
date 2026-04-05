<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mediaid";

// Step 1: Connect to MySQL server (no database yet)
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die(" Connection failed: " . mysqli_connect_error());
}

// Step 2: Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if (mysqli_query($conn, $sql)) {
    // Database created successfully or already exists
} else {
    die(" Error creating database: " . mysqli_error($conn));
}

// Step 3: Select the database
mysqli_select_db($conn, $database);

$sql_admin = "CREATE TABLE IF NOT EXISTS admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if (!mysqli_query($conn, $sql_admin)) {
    die(" Error creating admin table: " . mysqli_error($conn));
}
$sql_doctors = "CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    -- speciality VARCHAR(100) NOT NULL,
    specialty VARCHAR(100) NOT NULL,
    hospital VARCHAR(150),
    phone VARCHAR(20),
    district VARCHAR(100),
    available_time VARCHAR(100),
    gender ENUM('male','female'),
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $sql_doctors)) {
    die(" Error creating doctors table: " . mysqli_error($conn));
}

$sql_review = "CREATE TABLE IF NOT EXISTS review (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    review VARCHAR(120) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $sql_review)) {
    die(" Error creating review table: " . mysqli_error($conn));
}
$sql_patients = "CREATE TABLE IF NOT EXISTS patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    age INT,
    blood_type VARCHAR(5),
    district VARCHAR(100),
    gender ENUM('male','female'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!mysqli_query($conn, $sql_patients)) {
    die(" Error creating patients table: " . mysqli_error($conn));
}

$sql_diseases = "CREATE TABLE IF NOT EXISTS diseases (
    disease_id INT AUTO_INCREMENT PRIMARY KEY,
    disease_name VARCHAR(100) NOT NULL UNIQUE,
    symptoms VARCHAR(255) NOT NULL,
    specialty VARCHAR(100) NOT NULL
)";

mysqli_query($conn, $sql_diseases);

$sql_insert_diseases = "INSERT IGNORE INTO diseases (disease_name, symptoms, specialty) VALUES
('Flu', 'fever,cough,fatigue', 'General Physician'),
('Common Cold', 'runny nose,sneezing,sore throat', 'General Physician'),
('Migraine', 'headache,nausea,light sensitivity', 'Neurologist'),
('COVID-19', 'fever,cough,loss of taste,loss of smell', 'Pulmonologist'),
('Dengue', 'fever,body pain,rash', 'General Physician'),
('Chickenpox', 'itching,blister rash,fever', 'Dermatologist'),
('Malaria', 'fever,chills,night sweats', 'General Physician'),
('Typhoid', 'high fever,abdominal pain,diarrhea', 'General Physician'),
('Pneumonia', 'cough,fever,shortness of breath', 'Pulmonologist'),
('Asthma', 'wheezing,shortness of breath,chest tightness', 'Pulmonologist'),
('Diabetes', 'frequent urination,thirst,blurred vision', 'Endocrinologist'),
('Hypertension', 'headache,dizziness,shortness of breath', 'Cardiologist'),
('Appendicitis', 'abdominal pain,fever,nausea', 'Surgeon'),
('Allergy', 'sneezing,itching', 'Allergist'),
('Arthritis', 'joint pain,swelling', 'Orthopedic'),
('Heart Attack', 'chest pain,shortness of breath', 'Cardiologist'),
('Depression', 'persistent sadness,fatigue', 'Psychiatrist'),
('Back Pain', 'lower back pain,stiffness', 'Orthopedic'),
('Fracture', 'break pain,deformity', 'Orthopedic'),
('Tuberculosis', 'cough,weight loss,fever', 'Pulmonologist')";

mysqli_query($conn, $sql_insert_diseases);
// $sql_mapping = "CREATE TABLE IF NOT EXISTS disease_mapping (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     disease_id INT NOT NULL,
//     symptom_name VARCHAR(100) NOT NULL,
//     FOREIGN KEY (disease_id) REFERENCES diseases(disease_id) ON DELETE CASCADE
// )";
// mysqli_query($conn, $sql_mapping);

// $sql_insert_mapping="INSERT IGNORE INTO disease_mapping (disease_id, symptom_name) VALUES
// (1, 'fever'), (1, 'cough'), (1, 'fatigue'),
// (2, 'runny nose'), (2, 'sneezing'), (2, 'sore throat'),
// (3, 'headache'), (3, 'nausea'), (3, 'light sensitivity'),
// (4, 'fever'), (4, 'cough'), (4, 'loss of taste'), (4, 'loss of smell'),
// (5, 'fever'), (5, 'body pain'), (5, 'rash'),
// (6, 'itching'), (6, 'blister rash'), (6, 'fever'),
// (7, 'fever'), (7, 'chills'), (7, 'night sweats'),
// (8, 'high fever'), (8, 'abdominal pain'), (8, 'diarrhea'),
// (9, 'cough'), (9, 'fever'), (9, 'shortness of breath'),
// (10, 'wheezing'), (10, 'shortness of breath'), (10, 'chest tightness'),
// (11, 'cough'), (11, 'mucus'), (11, 'fever'),
// (12, 'stomach pain'), (12, 'nausea'), (12, 'indigestion'),
// (13, 'stomach pain'), (13, 'heartburn'), (13, 'nausea'),
// (14, 'frequent urination'), (14, 'thirst'), (14, 'blurred vision'),
// (15, 'headache'), (15, 'dizziness'), (15, 'shortness of breath'),
// (16, 'abdominal pain'), (16, 'fever'), (16, 'nausea'),
// (17, 'headache'), (17, 'nausea'),
// (18, 'sneezing'), (18, 'itching'),
// (19, 'facial pain'), (19, 'nasal congestion'),
// (20, 'pale skin'), (20, 'fatigue'),
// (21, 'joint pain'), (21, 'swelling'),
// (22, 'ear pain'), (22, 'hearing loss'),
// (23, 'red eyes'), (23, 'discharge'),
// (24, 'painful urination'), (24, 'frequent urination'),
// (25, 'jaundice'), (25, 'fatigue'),
// (26, 'jaundice'), (26, 'abdominal pain'),
// (27, 'jaundice'), (27, 'appetite loss'),
// (28, 'headache'), (28, 'nausea'),
// (29, 'rash'), (29, 'painful blisters'),
// (30, 'cough'), (30, 'weight loss'),
// (31, 'cold intolerance'), (31, 'weight gain'),
// (32, 'heat intolerance'), (32, 'weight loss'),
// (33, 'wheezing'), (33, 'cough'),
// (34, 'itchy skin'), (34, 'dry patches'),
// (35, 'silvery scales'), (35, 'itching'),
// (36, 'confusion'), (36, 'nausea'),
// (37, 'thirst'), (37, 'blurred vision'),
// (38, 'sweating'), (38, 'tremors'),
// (39, 'chest pain'), (39, 'shortness of breath'),
// (40, 'one‑sided weakness'), (40, 'speech difficulty'),
// (41, 'excessive worry'), (41, 'restlessness'),
// (42, 'persistent sadness'), (42, 'fatigue'),
// (43, 'lower back pain'), (43, 'stiffness'),
// (44, 'ankle pain'), (44, 'swelling'),
// (45, 'break pain'), (45, 'deformity'),
// (46, 'nausea'), (46, 'vomiting'),
// (47, 'face pain'), (47, 'ear pain'),
// (48, 'nasal congestion'), (48, 'facial pressure'),
// (49, 'chest tightness'), (49, 'breathing difficulty'),
// (50, 'chronic cough'), (50, 'wheezing')";
// mysqli_query($conn, $sql_insert_mapping);



$sql_appointments = "CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    disease_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    status ENUM('Pending','Approved','Completed','Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
)";

if (!mysqli_query($conn, $sql_appointments)) {
    die(" Error creating appointments table: " . mysqli_error($conn));
}

$reports_table_sql = "
CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    patient_id INT NOT NULL,
    report_title VARCHAR(255),
    report_date DATE,
    status VARCHAR(50) DEFAULT 'pending'
) ENGINE=InnoDB;
";

if ($conn->query($reports_table_sql) === FALSE) {
    die("Error creating reports table: " . $conn->error);
}
?>
