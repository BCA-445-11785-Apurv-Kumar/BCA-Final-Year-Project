<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title fs-5">Signup for an iDiscuss account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" action="/FORUM/partials/handleSignup.php">
        <div class="modal-body">

          <!-- Alert Box -->
          <div id="signupAlert">
            <?php
            if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
                echo '<div class="alert alert-success alert-dismissible fade show">
                        <strong>Success!</strong> Your account has been created.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
            }

            if(isset($_GET['error'])){
                $error = htmlspecialchars($_GET['error']);
                echo '<div class="alert alert-danger alert-dismissible fade show">
                        <strong>Error!</strong> '.$error.'
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>';
            }
            ?>
          </div>

          <!-- Email -->
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" maxlength="31" class="form-control" id="email" name="email" required>
          </div>

          <!-- Username -->
          <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" maxlength="11" class="form-control" id="username" name="username"
              pattern="^[A-Za-z0-9]+$"
              title="Only letters and numbers allowed"
              required>
          </div>

          <!-- Password -->
          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="signuppassword" name="signuppassword"
              pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}"
              title="Must contain 8+ chars, uppercase, lowercase, number & special char"
              required>
          </div>

          <!-- Confirm Password -->
          <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="signupcpassword" name="signupcpassword" required>
            <div class="form-text">Make sure to input the same password.</div>
          </div>

          <button type="submit" class="btn btn-primary mt-3 w-100">Sign Up</button>

        </div>
      </form>

    </div>
  </div>
</div>

<!-- VALIDATION SCRIPT -->
<script>
const username = document.getElementById('username');
const email = document.getElementById('email');
const pwd = document.getElementById('signuppassword');
const cpwd = document.getElementById('signupcpassword');
const alertDiv = document.getElementById('signupAlert');

// Store current errors
let errors = {
  username: "",
  email: "",
  password: "",
  confirm: ""
};

// Show all errors together
function updateAlerts() {
    let messages = Object.values(errors).filter(msg => msg !== "");

    if (messages.length > 0) {
        alertDiv.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show">
            ${messages.join("<br>")}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        `;
    } else {
        alertDiv.innerHTML = "";
    }
}

// Username validation
username.addEventListener("input", () => {
    let regex = /^[A-Za-z0-9]*$/;
    errors.username = regex.test(username.value) ? "" : "Username should contain only letters and numbers";
    updateAlerts();
});

// Email validation (FIXED REGEX ✅)
email.addEventListener("input", () => {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    errors.email = regex.test(email.value) ? "" : "Invalid email format";
    updateAlerts();
});

// Password validation
pwd.addEventListener("input", () => {
    let regex = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}/;
    errors.password = regex.test(pwd.value)
        ? ""
        : "Password must have uppercase, lowercase, number & special character (min 8 chars)";
    updateAlerts();
});

// Confirm password
cpwd.addEventListener("input", () => {
    if (pwd.value !== cpwd.value) {
        errors.confirm = "Passwords do not match";
    } else {
        errors.confirm = "";
    }
    updateAlerts();
});
</script>