<?php
session_start(); // Start the session


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
// Fetch patient's name from the database
$sql_patient = "SELECT * FROM patient WHERE id = $patient_id";
$result_patient = $conn->query($sql_patient);

// Initialize variable to store patient's name
$patient_name = "Unknown";

// Check if the query was successful and fetch the patient's name
if ($result_patient && $result_patient->num_rows > 0) {
    $row = $result_patient->fetch_assoc();
    $patient_name = $row['firstName'];
}
// $sql = "SELECT day_of_week, time_slot FROM appointments ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
// $result = mysqli_query($conn, $sql);

$dayOfWeek = [];

// Fetch data from the appointments table
$sql = "SELECT day_of_week, time_slot FROM appointments ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // Loop through each row
    while ($row = mysqli_fetch_assoc($result)) {
        $day = $row['day_of_week'];
        $timeSlot = $row['time_slot'];


        // Check if the day already exists in the array
        if (!isset($dayOfWeek[$day])) {
            // If not, initialize an empty array for that day
            $dayOfWeek[$day] = [];
        }
        // Add the time slot to the array for that day
        $dayOfWeek[$day][] = $timeSlot;
    }
}

// Check if the query was successful
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$sql_patient = "SELECT * FROM patient WHERE id = $patient_id";
$result_patient = $conn->query($sql_patient);

$bookedTimeSlots = [];
$sqlBooked = "SELECT time_slot FROM booked_appointments";
$resultBooked = mysqli_query($conn, $sqlBooked);
if (!$resultBooked) {
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($resultBooked) > 0) {
    while ($row = mysqli_fetch_assoc($resultBooked)) {
        $bookedTimeSlots[] = $row["time_slot"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/dashcss.css">
    <style>
        .time-slot {
            background-color: #F8F8F8;
            height: 22px;
            color: #333333;
            padding: 4px;
            margin-top: 5px;
            font-size: 14px;
            border-radius: 3px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5px;
            transition: background-color 0.1s ease;
        }

        .time-slot:hover {
            color: rgb(255, 255, 255);
            background-color: rgb(47, 161, 214);
            height: 22px;
            padding: 2px;
            font-size: 14px;
            font-weight: bold;
        }

        .time-slot.selected {
            background-color: rgb(47, 161, 214);
            color: #ffffff;
            height: 22px;
            padding: 2px;
            font-size: 14px;
            font-weight: bold;
        }

        .Prescription {
            width: 100%;
            overflow: auto;
            /* Enable scrolling if content exceeds container width */
        }

        #prescription-table {
            width: 100%;
            border-collapse: collapse;
        }

        #prescription-table th,
        #prescription-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            /* Add bottom border to separate rows */
            text-align: left;
            /* Align text to the left */
        }

        #prescription-table th {
            background-color: #f2f2f2;
            /* Light gray background for table headers */
            font-weight: bold;
        }

        #prescription-table tr

        /* :nth-child(even)*/
            {
            background-color: #E6F1F6;
            /* Alternate row background color */
        }

        #prescription-table tr:hover {
            background-color: #ddd;
            /* Highlight row on hover */
        }

        .dropdown-content {
            color: black;
            padding: 12px 12px;
            text-decoration: none;
            display: inline-block;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 5;
            top: 40px;
            right: 0;
        }

        .dropdown-content:hover {
            color: #f9f9f9;
            background-color: #ffffff;
        }

        a {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            font-weight: bold;
            color: #0c0073;
            text-decoration: none;
        }

        /* Style the container for the dropdown content */
        .dropdown-content {
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            padding: 8px 0;
            z-index: 5;
            display: none;
            /* Initially hide the dropdown content */
        }

        /* Style each individual link within the dropdown */
        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of links on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Style the container for the dropdown box */
        .dropdown-box {
            display: flex;
            flex-direction: column;
        }

        a:hover {
            text-decoration: underline;
            color: #24bfe9;
        }

        .profile-btn:hover .dropdown-content {
            display: block;
        }

        .profile-btn img {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 4px;
        }

        .profile-btn span {
            color: var(--main-color);
            font-size: 16px;
            line-height: 24px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="app-container">
        <div class="app-header" style="background-color:#253C8B; position: absolute top;">
            <div class="app-header-left">
                <img src="../Assets/Svg/Logo.svg" height="25px" class="logo-pos" />
                <p class="app-name" style="color:white">MEDIBOOK</p>
            </div>
            <div class="app-header-right">
                <button class="game-btn"><a style="color: black; text-decoration: none; font-weight: bold;" href="./Game.html">Bored? </a></button>

                <!--logout button/profile-->
                <div class="dropdown">
                    <button class="profile-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 19 19">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                        <span><?php echo $patient_name; ?></span>
                        <div class="dropdown-content">
                            <a href="./patientProfile.php">PROFILE<br /></a>
                            <a href="./Landing.html">LOGOUT</a>
                        </div>
                    </button>
                    <!--logout button/profile ends-->
                </div>
            </div>
            <button class="messages-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
            </button>
        </div>
        <!-- cards content -->
        <div class="app-content">

            <div class="projects-section">
                <div class="projects-section-header">
                    <p>HOME</p>
                    <table>
                        <tbody style="font-weight: 900; font-size: x-large;">
                            <tr>
                                <td id="day"></td>
                                <td id="date"></td>
                            <tr style="text-align: right;">
                                <td></td>
                                <td id="time"></td>
                            </tr>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="grid-block">
                    <?php
                    // Define an array of background colors
                    $colors = ['#fee4cb', '#d8e1fe', '#fdd4ea', '#d4f1fe', '#dff7cf', '#ffd7e1'];

                    foreach ($dayOfWeek as $day => $timeSlots) {
                        echo '<div class="project-box-wrapper">
                            <div class="project-box" style="background-color: ' . $colors[array_search($day, array_keys($dayOfWeek))] . ';">
                                <div class="project-box-header">
                                    <span>' . $day . '</span>
                                    <div class="more-wrapper "></div>
                                </div>
                                <div class="grid-item">
                                    <div class="container">
                                        <div class="time-slot-container" id="' . strtolower(substr($day, 0, 3)) . 'TimeSlots">';

                        if (!empty($timeSlots)) {
                            foreach ($timeSlots as $timeSlot) {
                                // Convert 24-hour time to 12-hour format
                                $formattedTime = date("g:i A", strtotime($timeSlot));
                                if (!in_array($timeSlot, $bookedTimeSlots)) {
                                    echo '<div class="time-slot" data-time="' . $timeSlot . '" data-day="' . $day . '">' . $formattedTime . '</div>';
                                }
                            }
                        } else {
                            echo "<p>No available time slots.</p>";
                        }
                        echo '</div>
                                    </div>
                                    <div class="Schedule-container">
                                        <hr />
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    echo '<div class="Schedule">
                        <button id="submitBtn">SCHEDULE</button>
                    </div>';
                    ?>
                </div>
            </div>
            <!-- card content-end -->
            <!-- upcomming Appointments --> <!-- upcomming Appointments-end -->
            <div class="messages-section">
                <button class="messages-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </button>
                <div class="messages">
                    <div class="pres">
                        <div class="projects-section-header">
                            <p>Latest Prescription</p>
                        </div>
                        <div class="Prescription">
                            <table id="prescription-table">
                                <tr>
                                    <th>Name</th>
                                    <th>Dosage</th>
                                    <th>Instructions</th>
                                    <th>Quantity</th>
                                </tr>
                                <?php

                                $patient_id = $_SESSION['patient_id']; // Get the patient ID from the session

                                // Perform a database query to fetch medication information for the specific patient
                                $medication_query = "SELECT * FROM medication_info WHERE patient_id = $patient_id";
                                $medication_result = mysqli_query($conn, $medication_query);

                                // Check if the query was successful
                                if ($medication_result && mysqli_num_rows($medication_result) > 0) {
                                    // Loop through each row of the result
                                    while ($row = mysqli_fetch_assoc($medication_result)) {
                                        // Output table row with medication information
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['dosage'] . "</td>";
                                        echo "<td>" . $row['instructions'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // If no medications found for the patient, display a message
                                    echo "<tr><td colspan='4'><div style='text-align: center;'>No Prescriptions found.</div></td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var timeSlots = document.querySelectorAll('.time-slot');
                timeSlots.forEach(function(slot) {
                    slot.addEventListener('click', function() {
                        // Remove 'selected' class from all time slots
                        timeSlots.forEach(function(slot) {
                            slot.classList.remove('selected');
                        });
                        // Add 'selected' class to the clicked time slot
                        slot.classList.add('selected');
                    });
                });

                document.getElementById('submitBtn').addEventListener('click', function() {
                    var selectedTimeSlot = document.querySelector('.time-slot.selected');
                    if (selectedTimeSlot) {
                        var timeSlotValue = selectedTimeSlot.getAttribute('data-time');
                        var dayOfWeekValue = selectedTimeSlot.getAttribute('data-day');
                        var patientId = "<?php echo $patient_id; ?>"; // get the patient ID from the session variable
                        storeSelectedTimeSlot(timeSlotValue, dayOfWeekValue, patientId);
                    } else {
                        alert('Please select a time slot before submitting.');
                    }
                });

                function storeSelectedTimeSlot(timeSlot, dayOfWeek, patientId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'store_time_slot.php');
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            // Remove selected time slot from the UI
                            var selectedSlot = document.querySelector('.time-slot.selected');
                            selectedSlot.parentElement.removeChild(selectedSlot);
                        } else {
                            alert('Error: ' + xhr.responseText);
                        }
                    };
                    xhr.send('time_slot=' + encodeURIComponent(timeSlot) + '&day_of_week=' + encodeURIComponent(dayOfWeek) + '&patient_id=' + encodeURIComponent(patientId));
                }
            });
        </script>
        <script src="../JavaScript/dash.js"></script>
        <script src="../JavaScript/table.js"></script>
        <?php
        mysqli_close($conn);
        ?>
</body>

</html>