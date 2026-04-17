<?php
require '../dbconnect.php';
require 'partials/header.php';

$success = '';
$error = '';

/* ADD USER */
if (isset($_POST['add_user'])) {

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $role     = trim($_POST['role']);
    $plainPassword = $_POST['password'];

    // VALIDATIONS
    if (!preg_match('/^[A-Za-z0-9]{3,20}$/', $username)) {
        $error = "Username must contain only letters/numbers (3-20 characters).";
    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    }

    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $plainPassword)) {
        $error = "Password must be 8+ chars with uppercase, lowercase, number and special character.";
    }

    else {

        $username = mysqli_real_escape_string($con, $username);
        $email    = mysqli_real_escape_string($con, $email);
        $role     = mysqli_real_escape_string($con, $role);
        $password = password_hash($plainPassword, PASSWORD_DEFAULT);

        // CHECK DUPLICATE EMAIL
        $check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already exists.";
        } else {

            $insert = mysqli_query($con, "
                INSERT INTO users (username, email, password, role)
                VALUES ('$username', '$email', '$password', '$role')
            ");

            if ($insert) {
                $success = "User added successfully!";
            } else {
                $error = "Failed to add user.";
            }
        }
    }
}

/* DELETE USER */
if (isset($_POST['delete_user'])) {
    $id = (int) $_POST['id'];

    // Prevent self-delete
    if ($_SESSION['sno'] == $id) {
        $error = "You cannot delete your own account.";
    } else {
        $delete = mysqli_query($con, "DELETE FROM users WHERE sno = $id");
        if ($delete) {
            $success = "User deleted successfully!";
        } else {
            $error = "Failed to delete user.";
        }
    }
}
?>

<h3 class="page-title">Manage Users</h3>

<!-- ALERTS -->
<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?= $success ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?= $error ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- ADD USER -->
<div class="card admin-card p-4 mb-4">
    <h5>Add New User</h5>

    <form method="POST" class="admin-form mt-3" id="userForm">

        <div id="formAlert"></div>

        <input type="text" 
               name="username" 
               class="form-control mb-3"
               placeholder="Username"
               required
               maxlength="20"
               pattern="^[A-Za-z0-9]{3,20}$"
               title="Only letters and numbers (3-20 characters)">

        <input type="email" 
               name="email" 
               id="email"
               class="form-control mb-3"
               placeholder="Email"
               required>

        <input type="password" 
               name="password" 
               id="password"
               class="form-control mb-3"
               placeholder="Password"
               required
               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}"
               title="Minimum 8 characters with uppercase, lowercase, number and special character">

        <select name="role" class="form-control mb-3" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button class="btn btn-success" name="add_user">Add User</button>
    </form>
</div>

<!-- USERS TABLE -->
<div class="card admin-card p-4">
<table class="table table-bordered admin-table table-hover">
<tr>
    <th>#</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th width="120">Action</th>
</tr>

<?php
$res = mysqli_query($con, "SELECT * FROM users");
$i = 1;

while ($row = mysqli_fetch_assoc($res)) {
    echo "
    <tr>
        <td>$i</td>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>
            <span class='badge bg-" . ($row['role'] == 'admin' ? 'danger' : 'secondary') . "'>
                {$row['role']}
            </span>
        </td>
        <td>
            <button 
                class='btn btn-danger btn-sm'
                data-bs-toggle='modal'
                data-bs-target='#deleteModal'
                data-id='{$row['sno']}'>
                Delete
            </button>
        </td>
    </tr>";
    $i++;
}
?>
</table>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content text-center">
      <div class="modal-body">
        <input type="hidden" name="id" id="delete_id">
        <p class="mb-3">Delete this user permanently?</p>
        <button name="delete_user" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('delete_id').value = button.getAttribute('data-id');
});

// LIVE VALIDATION ALERTS
const email = document.getElementById('email');
const password = document.getElementById('password');
const alertBox = document.getElementById('formAlert');

function showAlert(msg){
    alertBox.innerHTML = `
    <div class="alert alert-danger alert-dismissible fade show">
        ${msg}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
}

email.addEventListener('input', function(){
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!regex.test(email.value)){
        showAlert("Enter a valid email address.");
    } else {
        alertBox.innerHTML = "";
    }
});

password.addEventListener('input', function(){
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
    if(!regex.test(password.value)){
        showAlert("Weak password.");
    } else {
        alertBox.innerHTML = "";
    }
});
</script>

<?php require 'partials/footer.php'; ?>