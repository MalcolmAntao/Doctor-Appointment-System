// // Check if there's a login error message
// <?php if(isset($_SESSION['login_error'])): ?>
// alert("<?php echo $_SESSION['login_error']; ?>"); // Display an alert with the error message
// <?php unset($_SESSION['login_error']); ?> // Clear the error message from the session
// <?php endif; ?>
window.onload = function () {
  // Get the error message from the URL parameter
  const urlParams = new URLSearchParams(window.location.search);
  const error = urlParams.get("error");

  // Display the error message if it exists
  if (error) {
    alert("Localhost says: " + error);
  }
};
