<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'medibook');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if username or email already exists
function isUsernameOrEmailTaken($username, $email, $conn)
{
    $sql = "SELECT * FROM patient WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true; // Username or email already exists
    } else {
        return false; // Username and email are available
    }
}

if (isUsernameOrEmailTaken($username, $email, $conn)) {
    echo "Sorry, this username or email is already taken.";
} else {
    if ($conn->connect_error) {
        die('Connection Failed:' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO patient (firstName, lastName, email, username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $password);
        $stmt->execute();

        // Fetch the ID of the newly inserted user
        $last_id = $conn->insert_id;

        // Store the ID in session
        session_start();
        $_SESSION['patient_id'] = $last_id;

        echo "Registration successful";
        // Redirect to the next page with the newly generated patient ID
        header("Location: pat2.php?id=$last_id");
        exit(); // Terminate the script after redirection
    }
}

$stmt->close();
$conn->close();
