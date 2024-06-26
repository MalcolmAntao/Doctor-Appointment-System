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
    $stmt = $con->prepare("SELECT * FROM patient WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    // If there is a matching user, set the session variable and redirect to pat2.php
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        $_SESSION['patient_id'] = $data['id'];
        header("Location: pat2.php");
        exit(); // Ensure that subsequent code is not executed after redirection
    } else {
        // If no matching user is found, set an error message in the URL parameter
        header("Location: main.html?error=Invalid email or password.");
        exit();
    }
} else {
    // If the form has not been submitted, redirect to the main page
    header("Location: main.html");
    exit();
}
