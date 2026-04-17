<?php
$showError = "false";
$showAlert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && !empty($_POST['username']) 
        && !empty($_POST['signuppassword']) && !empty($_POST['signupcpassword'])) {
        
        include '../dbconnect.php';

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['signuppassword'];
        $cpassword = $_POST['signupcpassword'];

        // Check whether username exists
        $existSql = "SELECT * FROM `users` WHERE username = '$username'";
        $result = mysqli_query($con, $existSql);
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            $showError = "Username already in use";
        } else {
            if ($password != $cpassword) {
                $showError = "Passwords do not match";
            } else {
                // Password strength check
                $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/";
                if(!preg_match($pattern, $password)){
                    $showError = "Weak password: Must be at least 8 characters, include uppercase, lowercase, number, and special character.";
                } else {
                    // Hash password and insert
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`email`, `username`, `password`, `timestamp`) 
                            VALUES ('$email', '$username', '$hash', current_timestamp())";
                    $result = mysqli_query($con, $sql);

                    if($result){
                        $showAlert = true;
                        header("Location: /FORUM/index.php?signupsuccess=true");
                        exit();
                    } else {
                        $showError = "Error in registration";
                    }
                }
            }
        }
    } else {
        $showError = "All fields are required";
    }

    // Redirect back with error message
    header("Location: /FORUM/index.php?signupsuccess=false&error=".urlencode($showError));
    exit();
}
?>