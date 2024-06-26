<?php
session_start(); // Start the session

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Establish a database connection
    $con = new mysqli("localhost", "root", "", "medibook");
    if ($con->connect_error) {
        die("Failed to connect : " . $con->connect_error);
    }

    // Prepare and execute the SQL query
    $stmt = $con->prepare("SELECT * FROM doctor WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    // If there is a matching user, set the session variable and redirect to patientProfile.php
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        $_SESSION['doctor_id'] = $data['id'];
        header("Location: DoctorDash.php");
        exit(); // Ensure that subsequent code is not executed after redirection
    } else {
        // If no matching user is found, redirect back to the login page with an error message
        header("Location: login_signup.php?error=invalid");
        exit();
    }
} else {
    // If the form has not been submitted, redirect back to the login page
    header("Location: login_signup.php");
    exit();
}
?>
