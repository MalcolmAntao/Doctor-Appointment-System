<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; // You might need to set your MySQL password here
$dbname = "medibook";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['patient_id'])) {
    header("Location: login_signup.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

$first_name = "";
// Query to fetch the first name from the patient table
$sql_first_name = "SELECT firstName FROM patient WHERE id = $patient_id";
$result_first_name = $conn->query($sql_first_name);

if ($result_first_name->num_rows > 0) {
    $row_first_name = $result_first_name->fetch_assoc();
    $first_name = $row_first_name['firstName'];
} else {
    // Handle the case where the first name is not found
    $first_name = "Unknown";
}
$name = $age = $sex = $feet = $inches = $weight = $address = $contact_number = $emergency_contact = $email = "";

$sql = "SELECT * FROM patient_info WHERE patient_id = $patient_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $age = $row['age'];
    $sex = $row['sex'];
    $feet = $row['height_feet'];
    $inches = $row['height_inches'];
    $weight = $row['weight'];
    $address = $row['address'];
    $contact_number = $row['contact_number'];
    $emergency_contact = $row['emergency_contact'];
    $email = $row['email'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./pprof.css">
    <style>
        #edit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            flex: 1;
        }

        #edit-button:hover {
            background-color: #0069d9;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="app-container">
            <div class="app-header" style="background-color:#253C8B; position: absolute top;">
                <div class="app-header-left">
                    <img src="../Assets/Svg/Logo.svg" height="25px" class="logo-pos" />
                    <p class="app-name" style="color:white">MEDIBOOK</p>
                </div>
                <div class="app-header-right">
                    <button class="game-btn" style="background-color:#253C8B; border:none;"><a style="color: black; text-decoration: none; font-weight: bold;" href="./Game.html">Bored? </a></button>

                    <div class="dropdown">
                        <button class="profile-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 19 19">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            <span style="color:white; margin-left: 5px;"><?php echo $first_name; ?></span>
                            <div class="dropdown-content">
                                <a href="../HTML/pat2.php">DASHBOARD</a>
                                <a href="./Landing.html">LOGOUT</a>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="profile-container">
                <div class="profile-bar">
                    <div class="center-prfile">
                        <div class="prfile-picture-container">
                            <br>
                            <img id="prfile-picture" src="../Assets/Img/Profile.jpg" alt="Profile Picture">
                        </div>
                    </div>
                </div>
                <div class="profile-info">
                    <form id="profile-form" action="process_form.php" method="post">

                        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                        <label for="name">NAME</label><br>
                        <input type="text" id="name" name="name" required placeholder="Full Name" value="<?php echo $name; ?>" disabled><br>
                        <div class="Col2-Button-Main">
                            <div>
                                <label for="age">AGE</label><br>
                                <input type="tel" id="age" name="age" required placeholder="Age (in years)" value="<?php echo $age; ?>" disabled><br>
                            </div>
                            <div>
                                <label for="sex">SEX</label><br>
                                <input type="text" id="sex" name="sex" required placeholder="Male/Female/Other" value="<?php echo $sex; ?>" disabled><br>
                            </div>
                        </div>
                        <div class="Col2-Button-Main">
                            <div class="height-container">
                                <label for="height">HEIGHT</label><br>
                                <div class="Col2-Button">
                                    <input type="text" id="feet" name="feet" required placeholder="Feet" value="<?php echo $feet; ?>" disabled><br>
                                    <input type="text" id="inches" name="inches" required placeholder="Inches" value="<?php echo $inches; ?>" disabled><br>
                                </div>
                            </div>
                            <div class="height-container">
                                <label for="weight">WEIGHT</label><br>
                                <input type="text" id="weight" name="weight" required placeholder="In Kg" value="<?php echo $weight; ?>" disabled><br>
                            </div>
                        </div>
                        <label for="address">ADDRESS</label><br>
                        <input type="text" id="address" name="address" required placeholder="eg.: House No. 42, Miramar Beach Road, Panaji, Goa, 403001, India" value="<?php echo $address; ?>" disabled><br>
                        <label for="phone">CONTACT NUMBER</label><br>
                        <input type="tel" id="phone" name="phone" required placeholder="eg.: +91 12345 67890" value="<?php echo $contact_number; ?>" disabled><br>
                        <label for="emergency_contact">EMERGENCY CONTACT</label><br>
                        <input type="tel" id="ephone" name="emergency_contact" required placeholder="eg.: +91 98765 43210" value="<?php echo $emergency_contact; ?>" disabled><br>
                        <label for="email">EMAIL</label><br>
                        <input type="email" id="email" name="email" required placeholder="eg.: example.user@example.com" value="<?php echo $email; ?>" disabled><br>

                        <div class="SE-Button">
                            <button type="button" id="edit-button" onclick="toggleEditSave()">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../patient_profile/pprofile.js"></script>
    <script>
        function toggleEditSave() {
            var inputs = document.querySelectorAll("#profile-form input");
            var editButton = document.getElementById("edit-button");
            if (editButton.textContent === "Edit") {
                inputs.forEach(function(input) {
                    input.disabled = false;
                });
                editButton.textContent = "Save";
            } else {
                // Perform Save functionality here if needed
                document.getElementById("profile-form").submit(); // Submit the form
            }
        }
    </script>
</body>

</html>