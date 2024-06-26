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
    if (isset($_POST['patient_id'])) {
        $patient_id = $_POST['patient_id'];


        // Prepare and bind SQL statement for prescription insertion
        $stmt = $conn->prepare("INSERT INTO medication_info (name, dosage, instructions, quantity, patient_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $dosage, $instructions, $quantity, $patient_id);

        // Get medication details from form submission and insert into the database
        foreach ($_POST['medication_name'] as $key => $value) {
            $name = $_POST['medication_name'][$key];
            $dosage = $_POST['dosage'][$key];
            $instructions = $_POST['instructions'][$key];
            $quantity = $_POST['quantity'][$key];
            $stmt->execute();
        }


        $stmt->close();

        // Optionally, you can redirect the user after successful submission
        header("Location: doctor.php");
        exit();
    } else {
        echo "Patient ID not found.";
    }


    $conn->close();
}
