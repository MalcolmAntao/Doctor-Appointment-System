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

$query = "SELECT ba.day_of_week, ba.time_slot, CONCAT(p.firstName, ' ', p.lastName) AS patient_name, p.id AS patient_id
    FROM booked_appointments ba
    INNER JOIN patient p ON ba.patient_id = p.id";
$result = mysqli_query($conn, $query);


// Fetch data and store it in an array
$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/DoctorDash.css">


    <style>
        .pres {
            position: relative;
            top: 10px;
            max-height: 300px;
            /* Adjust the maximum height as needed */
            overflow-y: auto;
            /* Add a scrollbar when content overflows vertically */
            padding-bottom: 150px;
        }

        /* Adjusted CSS for the table */
        table#myTable {
            width: 100%;
            border-collapse: collapse;
        }

        #myTable th,
        #myTable td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        #myTable th {
            background-color: #f2f2f2;
        }

        #myTable button {
            padding: 8px 16px;
            background-color: transparent;
            color: black;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        #myTable button:hover {
            font-weight: bold;
            color: #253C8B;
        }

        /* Adjusted CSS for the prescription table */
        .table-container {
            max-height: 300px;
            /* Adjust the maximum height as needed */
            overflow-y: auto;
            /* Add a scrollbar when content overflows vertically */
            position: sticky;
            /* Stick to the top */
            top: 0;
            /* Stick to the top */
        }

        #prescription-table {
            width: 100%;
            border-collapse: collapse;
        }

        #prescription-table th,
        #prescription-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        #prescription-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        #prescription-table tr {
            background-color: #E6F1F6;
        }

        #prescription-table tr:hover {
            background-color: #ddd;
        }

        #prescription-form button {
            padding: 8px 16px;
            background-color: transparent;
            color: black;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        #prescription-form button:hover {
            font-weight: bold;
            color: #253C8B;
        }

        /* Additional CSS for the prescription form */
        .Prescription {
            width: 100%;
            overflow: auto;
        }

        .Prescription ul {
            list-style-type: none;
            padding: 0;
        }


        .Prescription li {
            margin-bottom: 10px;
        }


        .Prescription input[type="text"] {
            width: 100%;
            /* Set input width to 100% to occupy full width of column */
            padding: 5px;
        }

        .Prescription button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }


        .Prescription button:hover {
            background-color: #d32f2f;
        }

        .Prescription button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            transition: none;
            /* Remove transition animation */
        }


        .Prescription button:hover {
            background-color: #d32f2f;
            transition: none;
            /* Remove hover transition animation */
        }

        #prescription-form button[type="submit"] {
            width: 100%;
            /* Make the button span the entire width */
            display: block;
            /* Ensure it takes up the full width */
            margin: 0 auto;
            /* Center the button horizontally */
            padding: 8px 0;
            /* Adjust padding as needed */
            background-color: transparent;
            color: black;
            border: 1px solid black;
            ;
            /* Add border */
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            /* Adjust font size as needed */
            transition: border-color 0.3s, background-color 0.3s;
            /* Add transition */
        }


        #prescription-form button[type="submit"]:hover {
            border-color: #253C8B;
            /* Change border color on hover */
            background-color: #253C8B;
            /* Change background color on hover */
            color: #ffffff;
            /* Change text color on hover */
        }


        #prescription-form .add-medication-button {
            padding: 8px 16px;
            /* Adjust padding as needed */
            background-color: transparent;
            color: black;
            border: 1px solid black;
            ;
            /* Add border */
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            /* Adjust font size as needed */
            font-weight: bold;
            /* Optionally make the text bold */
            transition: border-color 0.3s, background-color 0.3s;
            /* Add transition */
        }

        #prescription-form .add-medication-button:hover {
            border-color: #253C8B;
            /* Change border color on hover */
            background-color: #253C8B;
            /* Change background color on hover */
            color: #ffffff;
            /* Change text color on hover */
        }
    </style>
</head>

<body>

    <div class="app-container">


        <div class="app-header" style="background-color:#253C8B">
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
                        <span style="color:white">DOCTOR</span>
                        <div class="dropdown-content">
                            <div class="dropdown-box">
                                <a href="../HTML/doctor_prof.php">PROFILE<br /></a>
                                <a href="../HTML/doctor.php">SCHEDULING</a>
                                <a href="../HTML/Landing.html">LOGOUT<br /></a>
                            </div>

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

                <div>
                    <table id="myTable">
                        <thead>
                            <tr class="Slots">
                                <th style="border: 1px solid black; padding: 8px;">Sr. No.</th>
                                <th style="border: 1px solid black; padding: 8px;">Name</th>
                                <th>Time Slot</th>
                                <th>Select Patient</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>

            </div>
            <!-- card content-end -->

            <!-- upcomming Appointments --> <!-- upcomming Appointments-end -->
            <div class="messages-section" style="overflow-y: hidden;">
                <button class="messages-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </button>
                <div class="projects-section-header" style="display: flex; justify-content: center;  align-items: center; ">
                    <p>Patient Details</p>
                </div>

                <div class="messages" style=" max-height: none; overflow-y: hidden; ">
                    <div class="center-profile">
                        <div class="profile-picture-container">
                            <img id="profile-picture" src="../Assets/Img/Profile.jpg" alt="Profile Picture">
                        </div>
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <h2 id="patient-name"></h2>
                    </div>

                    <hr />
                </div>

                <div class="projects-section-header" style="display: flex; flex-direction: column; align-items: center;">
                    <div>
                        <p>Latest Prescription</p>
                    </div>

                </div>
                <div>
                    <form id="prescription-form" style="display: inline-block; margin-right: 20px;" method="post" action="submit_prescription.php" onsubmit="submitForm(event)">
                        <button type="button" style="margin-left: 20px;" class="add-medication-button" onclick="addMedication()">Add Medication</button>
                    </form>
                </div>

                <div class="pres">
                    <div class="Prescription">
                        <form id="prescription-form" method="post" action="submit_prescription.php" onsubmit="submitForm(event)">

                            <table id="prescription-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Dosage</th>
                                        <th>Instructions</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="prescription-list">
                                    <tr>
                                        <td><input type="text" name="medication_name[]" placeholder="Name" required></td>
                                        <td><input type="text" name="dosage[]" placeholder="Dosage" required></td>
                                        <td><input type="text" name="instructions[]" placeholder="Instructions" required></td>
                                        <td><input type="text" name="quantity[]" placeholder="Quantity" required></td>
                                        <td><button type="button" class="no-animation-button" onclick="removeMedication(this)">Delete</button></td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" style="position:relative; top: 10px; margin-left:2px; margin-right: 2px;" class="no-animation-button">Submit Prescription</button>
                            <input type="hidden" name="patient_id" id="patient-id">
                        </form>
                    </div>
                </div>

                <script>
                    function addMedication() {
                        var prescriptionList = document.getElementById("prescription-list");
                        var newRow = document.createElement("tr"); // Create a new row element
                        newRow.innerHTML = `
        <td><input type="text" name="medication_name[]" placeholder="Name" required></td>
        <td><input type="text" name="dosage[]" placeholder="Dosage" required></td>
        <td><input type="text" name="instructions[]" placeholder="Instructions" required></td>
        <td><input type="text" name="quantity[]" placeholder="Quantity" required></td>
        <td><button type="button" onclick="removeMedication(this)">Delete</button></td>
    `;
                        prescriptionList.appendChild(newRow); // Append the new row to the list
                    }

                    function removeMedication(button) {
                        var row = button.parentNode.parentNode; // Get the parent row of the button
                        row.parentNode.removeChild(row); // Remove the row from the table
                    }
                </script>
            </div>
        </div>
    </div>

    <script>
        function addRow(srNo, name, timeSlot, patientId) {
            var table = document.getElementById("myTable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3); // Add checkbox cell after timeslot
            var button = document.createElement("button");
            button.textContent = name;
            button.onclick = function() {
                document.getElementById("patient-id").value = patientId; // Set patient ID
            };
            cell1.textContent = srNo;
            cell2.appendChild(button);
            cell3.textContent = timeSlot;
            cell4.style.textAlign = "center"; // Set checkbox cell alignment
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.name = "patient_checkbox"; // Set the name attribute to identify checkboxes
            checkbox.value = patientId; // Set value to patientId
            checkbox.id = "checkbox_" + patientId; // Assign unique id to each checkbox
            checkbox.onclick = function() {
                handleCheckbox(this, name); // Pass the name to the handleCheckbox function
                document.getElementById("patient-id").value = patientId; // Set patient ID
            };
            cell4.appendChild(checkbox); // Append checkbox to the cell
        }

        function handleCheckbox(clickedCheckbox, name) {
            var checkboxes = document.getElementsByName("patient_checkbox");
            checkboxes.forEach(function(checkbox) {
                if (checkbox !== clickedCheckbox) {
                    checkbox.checked = false; // Uncheck other checkboxes
                }
            });
            if (clickedCheckbox.checked) {
                displayPatientDetails(name); // Display patient's name when checkbox is checked
            } else {
                displayPatientDetails(""); // Clear patient details when checkbox is unchecked
            }
        }

        function displayPatientDetails(name) {
            var patientName = document.getElementById("patient-name");
            patientName.textContent = name;
        }

        document.addEventListener("DOMContentLoaded", function() {
            populateTable();
        });

        function populateTable() {
            var table = document.getElementById("myTable");
            appointments.forEach(function(appointment, index) {
                var timeSlot = convertTo12HourFormat(appointment.time_slot);
                addRow(index + 1, appointment.patient_name, appointment.day_of_week + " " + timeSlot, appointment.patient_id);
            });
        }

        function convertTo12HourFormat(time) {
            var hour = parseInt(time.split(":")[0]);
            var minute = parseInt(time.split(":")[1]);
            var period = hour >= 12 ? "PM" : "AM";
            hour = hour % 12 || 12;
            return hour + ":" + (minute < 10 ? "0" : "") + minute + " " + period;
        }

        var appointments = <?php echo json_encode($appointments); ?>;
    </script>
    <script>
        function submitForm(event) {
            event.preventDefault();
            var formData = new FormData(event.target);
            fetch(event.target.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('There was a problem with the form submission:', error);
                });
        }
    </script>

    <script src="../JavaScript/.DoctorDashboard.js"></script>
    <script src="../JavaScript/dash.js"></script>
    <script src="../JavaScript/table.js"></script>
    </div>

</body>
</html>