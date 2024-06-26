document.addEventListener("DOMContentLoaded", function () {
  var modeSwitch = document.querySelector(".mode-switch");
  modeSwitch.addEventListener("click", function () {
    document.documentElement.classList.toggle("dark");
    modeSwitch.classList.toggle("active");
  });
});

// Handle form submission
document
  .getElementById("profile-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    // Get form values
    var name = document.getElementById("name").value;
    var address = document.getElementById("address").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var designation = document.getElementById("designation").value;
    var specialization = document.getElementById("specialization").value;

    // Display form values
    document.getElementById("name-display").textContent = name;
    document.getElementById("address-display").textContent = address;
    document.getElementById("phone-display").textContent = phone;
    document.getElementById("email-display").textContent = email;
    document.getElementById("designation-display").textContent = designation;
    document.getElementById("specialization-display").textContent =
      specialization;

    // Hide form and show display
    document.getElementById("profile-form").style.display = "none";
    document.getElementById("profile-display").style.display = "block";
  });

// Handle edit button click
document.getElementById("edit-button").addEventListener("click", function () {
  // Show form and hide display
  document.getElementById("profile-form").style.display = "block";
  document.getElementById("profile-display").style.display = "none";
});
