<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medibook";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_SESSION["patient_id"])) {
        $patient_id = $_SESSION["patient_id"];

        $name = $_POST["name"];
        $age = $_POST["age"];
        $sex = $_POST["sex"];
        $feet = $_POST["feet"];
        $inches = $_POST["inches"];
        $weight = $_POST["weight"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $emergency_contact = $_POST["emergency_contact"];
        $email = $_POST["email"];

        $stmt = $conn->prepare("SELECT * FROM patient_info WHERE patient_id = ?");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE patient_info SET name=?, age=?, sex=?, height_feet=?, height_inches=?, weight=?, address=?, contact_number=?, emergency_contact=?, email=? WHERE patient_id=?");
            $stmt->bind_param("sisissssssi", $name, $age, $sex, $feet, $inches, $weight, $address, $phone, $emergency_contact, $email, $patient_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO patient_info (patient_id, name, age, sex, height_feet, height_inches, weight, address, contact_number, emergency_contact, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isisisissss", $patient_id, $name, $age, $sex, $feet, $inches, $weight, $address, $phone, $emergency_contact, $email);
        }

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: patientProfile.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Patient ID not found in session!";
    }
} else {
    echo "Invalid request method!";
}
