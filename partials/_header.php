<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/FORUM">iDiscuss</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="/FORUM">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top Categories
          </a>
          <ul class="dropdown-menu">';
          
          $sql = "SELECT category_name, category_id FROM categories LIMIT 3";
          $result = mysqli_query($con, $sql);
          while($row = mysqli_fetch_assoc($result)){
           echo '<li><a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id'] . '">'.$row['category_name'].'</a></li>';
          }
          echo' </ul>
           </li>

       <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
      </ul>

      <!-- Right-side navbar content -->
      <div class="d-flex align-items-center">
        <form class="d-flex align-items-center me-2" role="search" method = "get" action="search.php">
          <input class="form-control me-2" name = "search" type="search" placeholder="Search" aria-label="Search"/>
          <button class="btn btn-success" type="submit">Search</button>
        </form>';

        ?>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
          <p class="text-light my-0 mx-2">Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></p>
          <a href="partials/logout.php" class="btn btn-outline-danger ms-2">LOGOUT</a>
        <?php else: ?>
          <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">SIGNUP</button>
          <button class="btn btn-outline-success ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">LOGIN</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<?php
include $_SERVER['DOCUMENT_ROOT'].'/FORUM/partials/_loginModal.php';
include $_SERVER['DOCUMENT_ROOT'].'/FORUM/partials/_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
          <strong>Success!</strong> You can now login.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

?>

<?php
if(isset($_GET['login'])){

    if($_GET['login'] == "success"){
        echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
                <strong>Success!</strong> You are logged in successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }

    if($_GET['login'] == "failed"){
        echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Error!</strong> Invalid username or password.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
?>

