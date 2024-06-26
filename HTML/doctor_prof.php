<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../CSS/dprof.css">
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

        }

        #edit-button:hover {
            background-color: #0069d9;
        }

        .profile-picture-container {
            width: 20vh;
            height: 20vh;
            overflow: hidden;
            border-radius: 50%;
            /* Makes it circular */
        }

        /* Styles for the profile picture */
        #profile-picture {
            width: 100%;
            height: auto;
            border: none;
            display: block;
            position: relative;
            bottom: 30px;
            border-radius: 50%;
        }

        .center-profile {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="app-container">
            <div class="app-header" style="background-color:#253C8B;">
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
                            <span style="color:white">DOCTOR</span>
                            <div class="dropdown-content">
                                <a href="../HTML/DoctorDash.php">DASHBOARD</a>
                                <a href="../HTML/doctor.php">SCHEDULING</a>
                                <a href="./Landing.html">LOGOUT</a>

                            </div>
                        </button>
                        <!--logout button/profile ends-->
                    </div>
                </div>
            </div>
            <div class="profile-container">
                <div class="profile-bar">
                    <div class="center-profile">
                        <div class="profile-picture-container">
                            <br>
                            <img id="profile-picture" src="../Assets/Img/Dprof.jpg" alt="Profile Picture">
                        </div>
                    </div>
                </div>
                <div class="profile-info">
                    <form id="profile-form" action="insert_doctor.php" method="POST">
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

                        if (!isset($_SESSION['doctor_id'])) {
                            header("Location: login_signup.php");
                            exit();
                        }

                        $doctor_id = $_SESSION['doctor_id'];

                        $name = $address = $phone = $email = $specialization = $qualification = "";

                        $sql = "SELECT * FROM doctors WHERE doctor_id = $doctor_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $name = $row['name'];
                            $address = $row['address'];
                            $phone = $row['phone'];
                            $email = $row['email'];
                            $specialization = $row['specialization'];
                            $qualification  = $row['qualification'];
                        }
                        ?>
                        <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">

                        <label for="name">NAME</label><br>
                        <input type="text" id="name" name="name" required value="<?php echo $name; ?>" disabled><br>
                        <label for="address">ADDRESS</label><br>
                        <input type="text" id="address" name="address" required value="<?php echo $address; ?>" disabled><br>
                        <label for="phone">CONTACT NUMBER</label><br>
                        <input type="tel" id="phone" name="phone" required value="<?php echo $phone; ?>" disabled><br>
                        <label for="email">EMAIL</label><br>
                        <input type="email" id="email" name="email" required value="<?php echo $email; ?>" disabled><br>
                        <label for="specialization">SPECIALIZATION</label><br>
                        <input type="text" id="specialization" name="specialization" required value="<?php echo $specialization; ?>" disabled><br>
                        <label for="qualification">QUALIFICATION</label><br>
                        <input type="text" id="qualification" name="qualification" required value="<?php echo $qualification; ?>" disabled><br>
                        <div class="SE-Button">
                            <button type="button" id="edit-button" onclick="toggleEditSave()">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../JavaScript/dprofile.js"></script>
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