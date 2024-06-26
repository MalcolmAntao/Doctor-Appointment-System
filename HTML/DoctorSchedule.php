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
</head>

<body>


    <div class="app-container">

        <div class="app-header" style="background-color:#253C8B">
            <div class="app-header-left">
                <span class="app-icon"></span>
                <p class="app-name" style="color:white">MEDIBOOK</p>
            </div>
            <div class="app-header-right">
                <button class="game-btn"><a style="color: white; text-decoration: none; font-weight: bold;" href="./Game.html">Bored? </a></button>

                <!--<button class="add-btn" title="Logout button">
        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
        <line x1="12" y1="5" x2="12" y2="19" />
        <line x1="5" y1="12" x2="19" y2="12" /></svg>
        </button>
        <button class="notification-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
        <path d="M13.73 21a2 2 0 0 1-3.46 0" /></svg>
        </button>-->
                <!--logout button/profile-->
                <div class="dropdown">
                    <button class="profile-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 19 19">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>

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
                    <div class="capacity" style="display: inline-flex">
                        <div class="numpat">
                            <form id="pat_in_ts">
                                <label for="num">No. of Patients per Slot</label><br>
                                <input type="text" id="num" name="num" required style="width:20px; height:20px; font-weight:bold; background-color:#f2f2f2; margin-left:2px; font-weight:bold"><br>
                            </form>
                        </div>
                        <!-- <p >No of Patients per slot:</p>
                            <div class="patient" style=" text-align:center;">
                                <p style="width:20px; height:20px; font-weight:bold; background-color:#f2f2f2; margin-left:2px; font-weight:bold"> 5 </p>
                            </div> -->
                    </div>
                </div>


                <div class="grid-block">

                    <!-- days Appointments -->
                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #fee4cb;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper "></div>
                            </div>
                            <div class="grid-item">
                                <div class="container">
                                    <div class="time-slot-container">
                                        <div class="timeslot" data-time="9:30am">9:30am</div>
                                        <div class="timeslot" data-time="10:00am">10:00am</div>
                                        <div class="timeslot" data-time="10:30am">10:30am</div>
                                        <div class="timeslot" data-time="11:00am">11:00am</div>
                                        <div class="timeslot" data-time="11:00am">11:30am</div>
                                        <div class="timeslot" data-time="11:00am">03:00pm</div>
                                        <div class="timeslot" data-time="11:00am">03:30pm</div>
                                        <div class="timeslot" data-time="11:00am">04:00pm</div>
                                        <div class="timeslot" data-time="11:00am">04:30pm</div>
                                        <div class="timeslot" data-time="11:00am">05:00pm</div>
                                        <div class="timeslot" data-time="11:00am">05:30pm</div>
                                        <div class="timeslot" data-time="11:00am">06:00pm</div>
                                        <div class="timeslot" data-time="11:00am">06:30pm</div>
                                        <div class="timeslot" data-time="11:00am">07:00pm</div>
                                        <div class="timeslot" data-time="11:00am">07:30pm</div>
                                    </div>
                                </div>
                                <div class="Schedule-container">
                                    <hr />
                                    <div class="Schedule">
                                        <button>
                                            SCHEDULE
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- days Appointments end -->

                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #d8e1fe;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper "></div>
                            </div>
                            <div class="grid-item">
                                <div class="container">
                                    <div class="time-slot-container">
                                        <div class="timeslot" data-time="9:30am">9:30am</div>
                                        <div class="timeslot" data-time="10:00am">10:00am</div>
                                        <div class="timeslot" data-time="10:30am">10:30am</div>
                                        <div class="timeslot" data-time="11:00am">11:00am</div>
                                        <div class="timeslot" data-time="11:00am">11:30am</div>
                                        <div class="timeslot" data-time="11:00am">03:00pm</div>
                                        <div class="timeslot" data-time="11:00am">03:30pm</div>
                                        <div class="timeslot" data-time="11:00am">04:00pm</div>
                                        <div class="timeslot" data-time="11:00am">04:30pm</div>
                                        <div class="timeslot" data-time="11:00am">05:00pm</div>
                                        <div class="timeslot" data-time="11:00am">05:30pm</div>
                                        <div class="timeslot" data-time="11:00am">06:00pm</div>
                                        <div class="timeslot" data-time="11:00am">06:30pm</div>
                                        <div class="timeslot" data-time="11:00am">07:00pm</div>
                                        <div class="timeslot" data-time="11:00am">07:30pm</div>
                                    </div>
                                </div>
                                <div class="Schedule-container">
                                    <hr />
                                    <div class="Schedule">
                                        <button>
                                            SCHEDULE
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #fdd4ea;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper "></div>
                            </div>
                            <div class="grid-item">
                                <div class="container">
                                    <div class="time-slot-container">
                                        <div class="timeslot" data-time="9:30am">9:30am</div>
                                        <div class="timeslot" data-time="10:00am">10:00am</div>
                                        <div class="timeslot" data-time="10:30am">10:30am</div>
                                        <div class="timeslot" data-time="11:00am">11:00am</div>
                                        <div class="timeslot" data-time="11:00am">11:30am</div>
                                        <div class="timeslot" data-time="11:00am">03:00pm</div>
                                        <div class="timeslot" data-time="11:00am">03:30pm</div>
                                        <div class="timeslot" data-time="11:00am">04:00pm</div>
                                        <div class="timeslot" data-time="11:00am">04:30pm</div>
                                        <div class="timeslot" data-time="11:00am">05:00pm</div>
                                        <div class="timeslot" data-time="11:00am">05:30pm</div>
                                        <div class="timeslot" data-time="11:00am">06:00pm</div>
                                        <div class="timeslot" data-time="11:00am">06:30pm</div>
                                        <div class="timeslot" data-time="11:00am">07:00pm</div>
                                        <div class="timeslot" data-time="11:00am">07:30pm</div>
                                    </div>
                                </div>
                                <div class="Schedule-container">
                                    <hr />
                                    <div class="Schedule">
                                        <button>
                                            SCHEDULE
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #d4f1fe;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper "></div>
                            </div>
                            <div class="grid-item">
                                <div class="container">
                                    <div class="time-slot-container">
                                        <div class="timeslot" data-time="9:30am">9:30am</div>
                                        <div class="timeslot" data-time="10:00am">10:00am</div>
                                        <div class="timeslot" data-time="10:30am">10:30am</div>
                                        <div class="timeslot" data-time="11:00am">11:00am</div>
                                        <div class="timeslot" data-time="11:00am">11:30am</div>
                                        <div class="timeslot" data-time="11:00am">03:00pm</div>
                                        <div class="timeslot" data-time="11:00am">03:30pm</div>
                                        <div class="timeslot" data-time="11:00am">04:00pm</div>
                                        <div class="timeslot" data-time="11:00am">04:30pm</div>
                                        <div class="timeslot" data-time="11:00am">05:00pm</div>
                                        <div class="timeslot" data-time="11:00am">05:30pm</div>
                                        <div class="timeslot" data-time="11:00am">06:00pm</div>
                                        <div class="timeslot" data-time="11:00am">06:30pm</div>
                                        <div class="timeslot" data-time="11:00am">07:00pm</div>
                                        <div class="timeslot" data-time="11:00am">07:30pm</div>
                                    </div>
                                </div>
                                <div class="Schedule-container">
                                    <hr />
                                    <div class="Schedule">
                                        <button>
                                            SCHEDULE
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #dff7cf;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper "></div>
                            </div>
                            <div class="grid-item">
                                <div class="container">
                                    <div class="time-slot-container">
                                        <div class="timeslot" data-time="9:30am">9:30am</div>
                                        <div class="timeslot" data-time="10:00am">10:00am</div>
                                        <div class="timeslot" data-time="10:30am">10:30am</div>
                                        <div class="timeslot" data-time="11:00am">11:00am</div>
                                        <div class="timeslot" data-time="11:00am">11:30am</div>
                                        <div class="timeslot" data-time="11:00am">03:00pm</div>
                                        <div class="timeslot" data-time="11:00am">03:30pm</div>
                                        <div class="timeslot" data-time="11:00am">04:00pm</div>
                                        <div class="timeslot" data-time="11:00am">04:30pm</div>
                                        <div class="timeslot" data-time="11:00am">05:00pm</div>
                                        <div class="timeslot" data-time="11:00am">05:30pm</div>
                                        <div class="timeslot" data-time="11:00am">06:00pm</div>
                                        <div class="timeslot" data-time="11:00am">06:30pm</div>
                                        <div class="timeslot" data-time="11:00am">07:00pm</div>
                                        <div class="timeslot" data-time="11:00am">07:30pm</div>
                                    </div>
                                </div>
                                <div class="Schedule-container">
                                    <hr />
                                    <div class="Schedule">
                                        <button>
                                            SCHEDULE
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #ffd7e1;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper "></div>
                            </div>
                            <div class="grid-item">
                                <div class="container">
                                    <div class="time-slot-container">
                                        <div class="timeslot" data-time="9:30am">9:30am</div>
                                        <div class="timeslot" data-time="10:00am">10:00am</div>
                                        <div class="timeslot" data-time="10:30am">10:30am</div>
                                        <div class="timeslot" data-time="11:00am">11:00am</div>
                                        <div class="timeslot" data-time="11:00am">11:30am</div>
                                        <div class="timeslot" data-time="11:00am">03:00pm</div>
                                        <div class="timeslot" data-time="11:00am">03:30pm</div>
                                        <div class="timeslot" data-time="11:00am">04:00pm</div>
                                        <div class="timeslot" data-time="11:00am">04:30pm</div>
                                        <div class="timeslot" data-time="11:00am">05:00pm</div>
                                        <div class="timeslot" data-time="11:00am">05:30pm</div>
                                        <div class="timeslot" data-time="11:00am">06:00pm</div>
                                        <div class="timeslot" data-time="11:00am">06:30pm</div>
                                        <div class="timeslot" data-time="11:00am">07:00pm</div>
                                        <div class="timeslot" data-time="11:00am">07:30pm</div>
                                    </div>
                                </div>
                                <div class="Schedule-container">
                                    <hr />
                                    <div class="Schedule">
                                        <button>
                                            SCHEDULE
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- card content-end -->
        </div>
    </div>

    <script src="../JavaScript/DoctorSchedule.js"></script>
    <script src="../JavaScript/dash.js"></script>
    <script src="../JavaScript/table.js"></script>
    </div>

</body>
</html>