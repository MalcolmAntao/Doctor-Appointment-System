$(document).ready(function () {
  // Function to check if passwords match
  function checkPasswordsMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#confirm-password").val();
    var passwordMatchMessage = $("#password-match");

    if (password !== confirmPassword) {
      // If passwords don't match, set border color to red and show error message
      $("#password, #confirm-password").css("border-color", "red");
      passwordMatchMessage.text("Passwords don't match").css("color", "red");
    } else {
      // If passwords match, set border color to green and show success message
      $("#password, #confirm-password").css("border-color", "green");
      passwordMatchMessage.text("Passwords match").css("color", "green");
    }
  }

  // Add event listener to password fields to check while typing
  $("#password, #confirm-password").keyup(checkPasswordsMatch);
});
