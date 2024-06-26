<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // Start session

// Debug output for session data
// echo "<pre>";
// print_r($_SESSION['selectedTimeSlots']);
// echo "</pre>";

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

// Check if selected time slots are already stored in the session
if (!isset($_SESSION['timeSlotsFetched'])) {
    // Debug statement to indicate session selectedTimeSlots is not empty
    echo "Session selectedTimeSlots is not empty!<br>";

    // Fetch selected time slots for each day from the database and store them in the session
    $selectedTimeSlotsDebug = array();
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    foreach ($days as $day) {
        // Debug statement to show executing query
        $sql = "SELECT time_slot FROM appointments WHERE day_of_week = '$day'";
        echo "Executing query: $sql<br>";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectedTimeSlotsDebug[$day][] = $row['time_slot'];
            }
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['selectedTimeSlots'])) {
        $selectedTimeSlots = json_decode(file_get_contents('php://input'), true);

        // Insert selected time slots into the database
        foreach ($selectedTimeSlots as $slot) {
            $day = $slot['day'];
            $time = $slot['time'];
            // Insert $day and $time into the database as needed
        }

        // Optionally, you can send a response back to the client if needed
        //echo "Selected time slots have been successfully scheduled.";
    } else {
        // Handle invalid request or session data missing
        //echo "Invalid request or session data missing.";
    }
    // // Debug statement to indicate before setting selectedTimeSlots
    // echo "Before setting selectedTimeSlots<br>";

    // Pass the selected time slots array to the session
    $_SESSION['selectedTimeSlots'] = $selectedTimeSlotsDebug;

    // // Debug statement to indicate after setting selectedTimeSlots
    // echo "After setting selectedTimeSlots<br>";

    // // Debug output for session data
    // echo "<pre>";
    // print_r($_SESSION['selectedTimeSlots']);
    // echo "</pre>";

    // Set flag to indicate that time slots have been fetched and stored
    $_SESSION['timeSlotsFetched'] = true;

    // Close the database connection
    $conn->close();
}

// Function to insert time slots for a specific day
function insertTimeSlots($day, $timeSlots, $conn)
{
    // Check if timeSlots[] is set and not empty
    if (!empty($timeSlots)) {
        // Loop through each selected time slot for the day
        foreach ($timeSlots as $timeSlot) {
            // Check if the time slot already exists for the day
            $sql = "SELECT COUNT(*) AS count FROM appointments WHERE day_of_week = ? AND time_slot = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $day, $timeSlot);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $stmt->close();

            if ($count == 0) {
                // Insert the time slot into the database
                $sql = "INSERT INTO appointments (day_of_week, time_slot) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $day, $timeSlot);
                if ($stmt->execute()) {
                    //echo "Time slot '$timeSlot' for $day is booked successfully.<br>";
                } else {
                    echo "Error: " . $conn->error . "<br>";
                }
                $stmt->close();
            } else {
                // Time slot already exists, skip insertion
                //echo "Time slot '$timeSlot' for $day already exists.<br>";
            }
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert time slots for each day
    insertTimeSlots('Monday', isset($_POST['monTimeSlots']) ? $_POST['monTimeSlots'] : [], $conn);
    insertTimeSlots('Tuesday', isset($_POST['tueTimeSlots']) ? $_POST['tueTimeSlots'] : [], $conn);
    insertTimeSlots('Wednesday', isset($_POST['wedTimeSlots']) ? $_POST['wedTimeSlots'] : [], $conn);
    insertTimeSlots('Thursday', isset($_POST['thuTimeSlots']) ? $_POST['thuTimeSlots'] : [], $conn);
    insertTimeSlots('Friday', isset($_POST['friTimeSlots']) ? $_POST['friTimeSlots'] : [], $conn);
    insertTimeSlots('Saturday', isset($_POST['satTimeSlots']) ? $_POST['satTimeSlots'] : [], $conn);
}

// Check if selected time slots are already stored in the session
if (!isset($_SESSION['selectedTimeSlots'])) {
    // Fetch selected time slots for each day from the database and store them in the session
    $selectedTimeSlotsDebug = array();
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    foreach ($days as $day) {
        $sql = "SELECT time_slot FROM appointments WHERE day_of_week = '$day'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectedTimeSlotsDebug[$day][] = $row['time_slot'];
            }
        }
    }

    // Pass the selected time slots array to the session
    $_SESSION['selectedTimeSlots'] = $selectedTimeSlotsDebug;

    // Debug output for session data
    echo "<pre>";
    print_r($_SESSION['selectedTimeSlots']);
    echo "</pre>";
}
// include 'process.php';
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/DoctorSchedule.css">
    <style>
        .selected {
            background-color: lightblue;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]+label {
            cursor: pointer;
            padding: 5px;
        }
    </style>
</head>

<body>

    <div class="app-container" style="overflow: auto;">
        <div class="app-header" style="background-color:#253C8B">
            <div class="app-header-left">
                <span class="app-icon"></span>
                <p class="app-name" style="color:white">MEDIBOOK</p>
            </div>
            <div class="app-header-right">
                <button class="game-btn"><a style="color: white; text-decoration: none; font-weight: bold;" href="./Game.html">Bored? </a></button>

                <div class="dropdown">
                    <button class="profile-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 19 19">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                        <span style="color:white">Doctor</span>
                        <div class="dropdown-content">
                            <a href="../HTML/DoctorDash.php">DASHBOARD</a>
                            <a href="../HTML/doctor_prof.php">PROFILE</a>
                            <a href="./Landing.html">LOGOUT</a>
                        </div>
                    </button>
                </div>
                <button class="messages-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                    </svg>
                </button>
            </div>
        </div>

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

                    // Define an array of days
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                    // Loop through each day
                    foreach ($days as $index => $day) {
                        echo '<div class="project-box-wrapper">
            <div class="project-box" style="background-color: ' . $colors[$index] . ';">
                <div class="project-box-header">
                    <span>' . $day . '</span>
                    <div class="more-wrapper "></div>
                </div>
                <div class="grid-item">
                    <form method="post" action="">
                        <div class="container">
                            <div class="time-slot-container" id="' . strtolower(substr($day, 0, 3)) . 'TimeSlots">';

                        // Generate time slots for each day
                        for ($hour = 9; $hour <= 19; $hour++) {
                            for ($minute = 0; $minute < 60; $minute += 30) {
                                $time = sprintf("%02d:%02d", $hour, $minute);
                                $formattedTime = date("g:i A", strtotime($time));
                                echo '<div class="timeslot" data-time="' . $time . '">
                    <input type="checkbox" name="' . strtolower(substr($day, 0, 3)) . 'TimeSlots[]" value="' . $time . '" id="' . strtolower(substr($day, 0, 3)) . '-' . $time . '">
                    <label for="' . strtolower(substr($day, 0, 3)) . '-' . $time . '">' . $formattedTime . '</label>
                </div>';
                            }
                        }

                        echo '</div>
                        </div>
                        <div class="Schedule-container">
                            <hr />
                            <div class="Schedule">
                                <button type="submit">SCHEDULE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>';
                    }
                    ?>
                    <!-- <div class="Schedule" style="width:100%;">
                        <button id="commonScheduleBtn" type="submit">Schedule All</button>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let scheduleButton = document.getElementById("commonScheduleBtn");

            scheduleButton.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect the selected time slots
                let selectedTimeSlots = [];
                document.querySelectorAll(".timeslot.selected").forEach(slot => {
                    let day = slot.querySelector("input[type='checkbox']").getAttribute("name").substring(0, 3);
                    let time = slot.getAttribute("data-time");
                    selectedTimeSlots.push({
                        day: day,
                        time: time
                    });
                });

                // Send the data to the server using fetch API
                fetch("process.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(selectedTimeSlots)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.text();
                    })
                    .then(data => {
                        console.log("Response from server:", data);
                        // Optionally handle the response here
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let timeSlots = document.querySelectorAll(".timeslot");

            timeSlots.forEach(slot => {
                let checkbox = slot.querySelector("input[type='checkbox']");
                let day = checkbox.getAttribute("name").substring(0, 3); // Extract day from checkbox name
                let time = slot.getAttribute("data-time"); // Get time slot value

                // Check if the time slot is selected from session data
                if (<?php echo isset($_SESSION['selectedTimeSlots']) ? 'true' : 'false'; ?>) {
                    let selectedTimeSlots = <?php echo json_encode($_SESSION['selectedTimeSlots']); ?>;
                    if (selectedTimeSlots.hasOwnProperty(day) && selectedTimeSlots[day].includes(time)) {
                        slot.classList.add("selected");
                        checkbox.checked = true;
                    }
                }

                slot.addEventListener("click", function() {
                    console.log("Time slot clicked:", day, time); // Add this line for debugging
                    this.classList.toggle("selected");
                    checkbox.checked = !checkbox.checked;
                });
            });
        });
    </script>
</body>
</html>