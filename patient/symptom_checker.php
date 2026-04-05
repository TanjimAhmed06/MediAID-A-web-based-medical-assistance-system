<?php
include '../includes/db_connect.php';

$result_data = [];
$doctor_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $symptoms = $_POST['symptoms'];
    $symptom_list = explode(',', strtolower($symptoms)); // split comma-separated symptoms

    $where_clauses = [];
    foreach ($symptom_list as $symptom) {
        $symptom = trim($symptom);
        if ($symptom !== '') {
            $where_clauses[] = "symptoms LIKE '%$symptom%'";
        }
    }

    if (!empty($where_clauses)) {
        $sql = "SELECT disease_id, disease_name, symptoms, specialty FROM diseases WHERE " . implode(" OR ", $where_clauses);
        $result = mysqli_query($conn, $sql);
        while ($disease = mysqli_fetch_assoc($result)) {
            $result_data[] = $disease;

            $specialty = $disease['specialty'];
            $sql_doc = "SELECT * FROM doctors WHERE specialty='$specialty'";
            $res3 = mysqli_query($conn, $sql_doc);

            $doctor_data[$disease['disease_id']] = [];
            while ($doc_row = mysqli_fetch_assoc($res3)) {
                $doctor_data[$disease['disease_id']][] = [
                    'doctor_name' => $doc_row['name'],
                    'specialty'   => $doc_row['specialty'],
                    'hospital'    => $doc_row['hospital'],
                    'contact'     => $doc_row['phone'],
                    'doctor_id'   => $doc_row['doctor_id']
                ];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Checker</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{background:linear-gradient(135deg,#dff1ff,#c1f0f6);font-family:Arial,sans-serif;display:flex;flex-direction:column;min-height:100vh;}
        .nav{height:60px;width:100%;background:linear-gradient(to right,#dff1ff,#0198ac);display:flex;align-items:center;justify-content:space-between;padding:0 40px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
        .nav a{text-decoration:none;color:#004aad;font-weight:bold;transition:0.3s;}
        .nav a:hover{color:white;}
        .centermain{flex:1;display:flex;justify-content:center;align-items:flex-start;padding:20px;}
        .main{width:600px;background:white;padding:30px;border-radius:20px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
        input[type=text]{width:100%;padding:10px;border-radius:10px;border:1px solid #ccc;}
        input[type=submit]{background-color:#007bff;color:white;border:none;padding:10px;width:100%;border-radius:10px;cursor:pointer;font-weight:bold;}
        input[type=submit]:hover{background-color:#0056b3;}
        .result{margin-top:20px;}
        .disease{margin-bottom:20px;padding:15px;border:1px solid #eee;border-radius:10px;background:#f9f9f9;}
        .doctors{margin-top:10px;padding-left:15px;}
        .doctor{margin-bottom:5px;}
    </style>
</head>
<body>
    <div class="nav">
        <a href="patient_dashboard.php">🏠 Home</a>
        <a href="../logout.php">🚪 Log Out</a>
    </div>
    <div class="centermain">
        <div class="main">
            <h2>Symptom Checker:</h2>
            <form action="" method="post">
                <label>Enter your symptom (comma separated)</label><br><br>
                <input type="text" name="symptoms" placeholder="eg., fever, headache, cold" required><br><br>
                <input type="submit" value="Check Disease">
            </form>

            <?php if (!empty($result_data)): ?>
                <div class="result">
                    <h3>Possible Diseases:</h3>
                    <?php foreach ($result_data as $disease): ?>
                        <div class="disease">
                            <strong><?php echo htmlspecialchars($disease['disease_name']); ?></strong><br>
                            Symptoms: <?php echo htmlspecialchars($disease['symptoms']); ?><br>
                            Specialty: <?php echo htmlspecialchars($disease['specialty']); ?><br>

                            <?php if (!empty($doctor_data[$disease['disease_id']])): ?>
                                <div class="doctors">
                                    <strong>Available Doctors:</strong>
                                    <?php foreach ($doctor_data[$disease['disease_id']] as $doc): ?>
                                        <div class="doctor">
                                            <?php echo htmlspecialchars($doc['doctor_name']); ?> - <?php echo htmlspecialchars($doc['hospital']); ?> (<?php echo htmlspecialchars($doc['contact']); ?>)

                                            <!-- BOOK APPOINTMENT FORM -->
                                            <form method="POST" action="book_appointment.php" style="display:inline;">
                                                <input type="hidden" name="doctor_id" value="<?php echo $doc['doctor_id']; ?>">
                                                <input type="hidden" name="disease_id" value="<?php echo $disease['disease_id']; ?>">
                                                <input type="submit" value="Book Appointment" style="margin-left:10px; padding:3px 8px; font-size:12px;">
                                            </form>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="doctors">
                                    <em>No doctors available for this specialty.</em>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <p>No diseases found matching these symptoms.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>