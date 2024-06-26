
<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medibook";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get patient ID from session
    if (isset($_SESSION['patient_id'])) {
        $patient_id = $_SESSION['patient_id'];

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO medication_info (name, dosage, instructions, quantity, patient_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $dosage, $instructions, $quantity, $patient_id);

        // Insert each medication into the database
        foreach ($_POST['medication_name'] as $key => $value) {
            $name = $_POST['medication_name'][$key];
            $dosage = $_POST['dosage'][$key];
            $instructions = $_POST['instructions'][$key];
            $quantity = $_POST['quantity'][$key];
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Patient ID not found.";
    }
}
?>
