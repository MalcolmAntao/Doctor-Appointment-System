<?php
session_start(); // Start session

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
