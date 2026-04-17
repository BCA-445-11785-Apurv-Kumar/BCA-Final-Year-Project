<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us - iDiscuss Coding Forums</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .content {
      flex: 1;
    }
  </style>
</head>

<body>

<?php 
session_start();
include "dbconnect.php";
include "partials/_header.php"; 

$name = $_SESSION['username'] ?? '';
$email = "";

// Fetch email if user is logged in
if(isset($_SESSION['sno'])){
    $sno = $_SESSION['sno'];
    $sql = "SELECT email FROM users WHERE sno = $sno";
    $result = mysqli_query($con, $sql);

    if($row = mysqli_fetch_assoc($result)){
        $email = $row['email'];
    }
}
?>

<!-- ALERTS -->
<?php
if(isset($_GET['status'])){

    if($_GET['status'] == "success"){
        echo '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Your message has been submitted.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }

    if($_GET['status'] == "error"){
        echo '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Message not submitted. Try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
?>

<!-- PAGE CONTENT -->
<div class="content container my-5">

  <h1 class="mb-4 text-center">Contact Us</h1>

  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

      <div class="card shadow-lg">
        <div class="card-body p-4">

          <form id="contactForm" action="partials/_handleContact.php" method="POST">

            <div id="formAlert"></div>

            <!-- Username -->
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>"  required>
            </div>

            <!-- Subject -->
            <div class="mb-3">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control" required>
            </div>

            <!-- Message -->
            <div class="mb-3">
              <label class="form-label">Message</label>
              <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
            </div>

            <!-- Button -->
            <button class="btn btn-success w-100">Send Message</button>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- VALIDATION SCRIPT -->
<script>
const email = document.getElementById('email');
const message = document.getElementById('message');
const alertBox = document.getElementById('formAlert');

function showAlert(msg, type="danger"){
  alertBox.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show">
      ${msg}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
}

// Email validation
email.addEventListener("input", () => {
  let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if(!regex.test(email.value)){
    showAlert("Invalid email format");
  } else {
    alertBox.innerHTML = "";
  }
});

// Message validation
message.addEventListener("input", () => {
  if(message.value.length < 10){
    showAlert("Message must be at least 10 characters");
  } else {
    alertBox.innerHTML = "";
  }
});
</script>

<!-- AUTO DISMISS ALERT -->
<script>
setTimeout(() => {
  document.querySelectorAll('.alert').forEach(alert => {
    alert.classList.remove('show');
    setTimeout(() => alert.remove(), 500);
  });
}, 3500);
</script>

<?php include "partials/_footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.pathname);
}
</script>

</body>
</html>