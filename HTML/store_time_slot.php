<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medibook";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the patient_id session variable is set
if (isset($_SESSION['patient_id'])) {
    // Get the patient_id from the session
    $patient_id = $_SESSION['patient_id'];

    // Now you can use $patient_id for your operations
    //echo "Patient ID: " . $patient_id;
} else {
    // If the session variable is not set, redirect back to the login page
    header("Location: login.php");
    exit();
}

// Check if time_slot and day_of_week are sent via POST
if (isset($_POST['time_slot']) && isset($_POST['day_of_week'])) {
    $time_slot = $_POST['time_slot'];
    $day_of_week = $_POST['day_of_week'];

    // Insert the selected time slot for the selected day into the database
    $sql = "INSERT INTO booked_appointments (patient_id, time_slot, day_of_week) VALUES ('$patient_id', '$time_slot', '$day_of_week')";

    if (mysqli_query($conn, $sql)) {
        echo "Appointment scheduled successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error: Time slot or day of week not provided.";
}

mysqli_close($conn);
