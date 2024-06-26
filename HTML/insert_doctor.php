<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medibook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_SESSION["doctor_id"])) {
        $doctor_id = $_SESSION["doctor_id"];

        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $specialization = $_POST['specialization'];
        $qualification = $_POST['qualification'];

        // Check if the doctor already exists in the database
        $stmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If the doctor exists, update the record
            $stmt = $conn->prepare("UPDATE doctors SET name=?, address=?, phone=?, email=?, specialization=?, qualification=? WHERE doctor_id=?");
            $stmt->bind_param("ssssssi", $name, $address, $phone, $email, $specialization, $qualification, $doctor_id);
        } else {
            // If the doctor doesn't exist, insert a new record
            $stmt = $conn->prepare("INSERT INTO doctors (name, address, phone, email, specialization, qualification, doctor_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $name, $address, $phone, $email, $specialization, $qualification, $doctor_id);
        }

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: doctor_prof.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Doctor ID not found in session!";
    }
} else {
    echo "Invalid request method!";
}
