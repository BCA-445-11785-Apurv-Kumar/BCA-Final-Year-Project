<?php
session_start();
include "../dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validation
    if(empty($name) || empty($email) || empty($subject) || empty($message)){
        header("Location: /FORUM/contact.php?status=error");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: /FORUM/contact.php?status=error");
        exit();
    }

    $user_id = $_SESSION['sno'] ?? NULL;

    $sql = "INSERT INTO contact_messages (user_id, name, email, subject, message)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);

    if($stmt->execute()){
        header("Location: /FORUM/contact.php?status=success");
    } else {
        header("Location: /FORUM/contact.php?status=error");
    }
    exit();
}
?>