<?php
session_start();
include "dbconnect.php";

// Handle new thread submission before any HTML output
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['catid']) && !empty($_POST['title']) && !empty($_POST['desc'])) {
        $id = intval($_POST['catid']);
        $th_title = mysqli_real_escape_string($con, $_POST['title']);
        $th_desc = mysqli_real_escape_string($con, $_POST['desc']);
        $sno = intval($_POST['sno']);

        $sql = "INSERT INTO `thread` 
                (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) 
                VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";

        if (mysqli_query($con, $sql)) {
            // Redirect before any HTML output
            header("Location: threadlist.php?catid=" . $id . "&success=1");
            exit;
        }
    }
}

// Get category info
$id = intval($_GET['catid'] ?? 0);
$sql = "SELECT * FROM `categories` WHERE category_id = $id";
$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_assoc($result)) {
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss - Coding Forums</title>
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
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php include "partials/_header.php"; ?>

<?php
// Show success alert if redirected after thread submission
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}
?>

<div class="container my-3">
    <div class="bg-light p-5 rounded-3">
        <h1 class="display-4"><?php echo htmlspecialchars($catname ?? 'Unknown Category'); ?></h1>
        <p class="lead"><?php echo htmlspecialchars($catdesc ?? ''); ?></p>
        <hr class="my-4">
        <p>This is a peer-to-peer forum. Please follow community guidelines:</p>
        <ul>
            <li>No Spam or Self-promotion</li>
            <li>Be Respectful and Courteous</li>
            <li>Stay on Topic</li>
            <li>Follow Netiquette</li>
        </ul>
        <a class="btn btn-success btn-lg" href="#" role="button">Learn More</a>
    </div>
</div>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
<div class="container">
    <h1>Start a Discussion</h1>
    <form action="threadlist.php?catid=<?php echo $id; ?>" method="post">
        <input type="hidden" name="catid" value="<?php echo $id; ?>">
        <input type="hidden" name="sno" value="<?php echo $_SESSION['sno']; ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Thread Title</label>
            <input type="text" name="title" class="form-control" id="title" required>
            <div class="form-text">Keep your title as crisp and short as possible.</div>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Elaborate your problem</label>
            <textarea name="desc" class="form-control" id="desc" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success my-2">Submit</button>
    </form>
</div>
<?php else: ?>
<div class="container">
    <h1>Start a Discussion</h1>
    <p class="lead">You are not logged in. Please login to start a discussion.</p>
</div>
<?php endif; ?>

<div class="container">
    <h1 class="py-3">Browse Questions</h1>
    <?php
    $sql = "SELECT * FROM `thread` WHERE `thread_cat_id` = $id";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo '<p class="text-danger">Error fetching threads.</p>';
    } elseif (mysqli_num_rows($result) == 0) {
        echo '<section class="bg-light py-5">
                <div class="container-fluid">
                    <h1 class="display-4">No threads found</h1>
                    <p class="lead">Be the first person to ask a question.</p>
                </div>
              </section>';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $thread_id = $row['thread_id'];
            $title = htmlspecialchars($row['thread_title']);
            $desc = htmlspecialchars($row['thread_desc']);
            $thread_time = htmlspecialchars($row['timestamp']);
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT username FROM `users` WHERE sno= '$thread_user_id'";
            $result2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $username = htmlspecialchars($row2['username'] ?? 'Anonymous');

            echo '
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <img src="images/user.jpg" class="rounded-circle me-3" width="50" height="50" alt="user">
                        <div>
                            <h6 class="text-muted mb-0">
                                <strong>' . $username . '</strong>
                                <small class="text-secondary"> • ' . $thread_time . '</small>
                            </h6>
                        </div>
                    </div>
                    <h4 class="card-title mb-2">
                        <a href="thread.php?threadid=' . $thread_id . '" class="text-dark text-decoration-none">'
                            . $title . '</a>
                    </h4>
                    <p class="card-text text-secondary">' . $desc . '</p>
                    <a href="thread.php?threadid=' . $thread_id . '" class="btn btn-outline-primary btn-sm mt-2">View Discussion</a>
                </div>
            </div>';
        }
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php include "partials/_footer.php"; ?>

</body>
</html>
