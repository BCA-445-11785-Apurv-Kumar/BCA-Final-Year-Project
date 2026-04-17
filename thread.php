<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thread - iDiscuss Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
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

        .a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php include "dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>
    <div class="content">
        <?php
        // Sanitize threadid from GET
        $id = isset($_GET['threadid']) ? (int)$_GET['threadid'] : 0;

        // Query the thread
        $sql = "SELECT * FROM `thread` WHERE thread_id = $id";
        $result = mysqli_query($con, $sql);

        if (!$result || mysqli_num_rows($result) === 0) {
            // No thread found
            echo '
                <section class="bg-light py-5">
                    <div class="container-fluid">
                        <h1 class="display-4">No threads found</h1>
                        <p class="lead">Be the first person to ask a question.</p>
                    </div>
                </section>
            ';
        } else {
            // Thread found
            $row = mysqli_fetch_assoc($result);
            $title = htmlspecialchars($row['thread_title']);
            $desc = nl2br(htmlspecialchars($row['thread_desc']));
            $thread_user_id = ($row['thread_user_id']);

            //Query the users table to find out the name of OP
            $sql2 = "SELECT username FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['username'];

            echo '
                <div class="container my-4">
                    <div class="bg-light p-5 rounded-3">
                        <h1 class="display-4">' . $title . '</h1>
                        <p class="lead">' . $desc . '</p>
                        <hr class="my-4">
                        <p>This is a peer-to-peer forum. Please follow community guidelines:</p>
                        <ul>
                            <li>No Spam or Self-promotion</li>
                            <li>Be Respectful and Courteous</li>
                            <li>Stay on Topic</li>
                            <li>Follow Netiquette</li>
                        </ul>
                        <p>Posted by <b>' . $posted_by . '</b></p>
                    </div>
                </div>
            ';
        }
        ?>
    </div>

    <?php
    $showAlert = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['comment'])) {
        // Get comment content and sanitize it
        $comment_content = mysqli_real_escape_string($con, $_POST['comment']);

        // Insert comment into DB
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`,`comment_by`, `comment_time`) 
                VALUES ('$comment_content', '$id', '$sno', current_timestamp())";

        $result = mysqli_query($con, $sql);

        if ($result) {
            $showAlert = true;
        }
    }
}

    // Show success alert if comment was added
    if ($showAlert) {
        echo '
        <div class="alert alert-success alert-dismissible fade show mx-auto text-center" 
            role="alert" 
            style="max-width: 400px;">
            <strong>Success!</strong> Your comment has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
        <h1>Post a comment</h1>
        <form action=" '.htmlspecialchars($_SERVER["PHP_SELF"]) .'?threadid=' . $id .'" method="post">
            <div class="form-group">
                <label for="comment">Elaborate your problem</label>
                <textarea name="comment" class="form-control mt-2" rows="3" required></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success my-2">Post Comment</button>
        </form>
    </div>';
    }
    else {
        echo '
        <div class="container">
        <h1 class = "py-2">Post a comment </h1>
            <p class = "lead">You are not logged in. Please login to be able to post comments.</p>
        </div>';
    }
    ?>
    

    <div class="container">
        <h1 class="py-2">Discussions</h1>
        <?php 
        $id = isset($_GET['threadid']) ? (int)$_GET['threadid'] : 0;
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
        $result = mysqli_query($con, $sql);
        $noResult = false;

        if (mysqli_num_rows($result) == 0) {
            echo '
                <section class="bg-light py-5">
                    <div class="container-fluid">
                        <h1 class="display-4">No comments found</h1>
                        <p class="lead">Be the first person to ask a question.</p>
                    </div>
                </section>';
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $commentId = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];

            $sql2 = "SELECT username FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '
                <div class="d-flex align-items-start my-3">
                    <img src="images/user.jpg" width="54px" class="flex-shrink-0 me-3" alt="user" />
                    <div>
                        <h5 class="font-weight-bold my-0">'.$row2['username'] .' at '. $comment_time .'</h5>
                        <p class="mt-0">' . $content . '</p>
                    </div>
                </div>';
        }
        ?>
    </div>

    <?php include "partials/_footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
