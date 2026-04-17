<?php
$showError = false;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    include '../dbconnect.php';   

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];  

            // ✅ SUCCESS ALERT
            if($row['role'] == 'admin'){
                header("Location: /FORUM/admin/index.php?login=success");
            } else {
                header("Location: /FORUM/index.php?login=success");
            }
            exit;

        } else {
            $showError = true;
        }
    } else {
        $showError = true;
    }

    if($showError){
        // ❌ ERROR ALERT
        header("Location: /FORUM/index.php?login=failed");
        exit;
    }
}
?>