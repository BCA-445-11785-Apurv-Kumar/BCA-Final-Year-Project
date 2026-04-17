<?php
require 'auth.php';
require '../dbconnect.php';
require 'partials/header.php';
?>

<div class="content">

<h3 class="mb-4">Dashboard</h3>

<div class="row g-4">

  <!-- USERS -->
  <div class="col-md-3">
    <div class="card dashboard-card shadow-sm text-center">
      <div class="card-body">
        <h6 class="text-muted">Users</h6>
        <h2>
          <?php
            $res = mysqli_query($con, "SELECT sno FROM users");
            echo mysqli_num_rows($res);
          ?>
        </h2>
      </div>
    </div>
  </div>

  <!-- CATEGORIES -->
  <div class="col-md-3">
    <div class="card dashboard-card shadow-sm text-center">
      <div class="card-body">
        <h6 class="text-muted">Categories</h6>
        <h2>
          <?php
            $res = mysqli_query($con, "SELECT category_id FROM categories");
            echo mysqli_num_rows($res);
          ?>
        </h2>
      </div>
    </div>
  </div>

  <!-- THREADS -->
  <div class="col-md-3">
    <div class="card dashboard-card shadow-sm text-center">
      <div class="card-body">
        <h6 class="text-muted">Threads</h6>
        <h2>
          <?php
            $res = mysqli_query($con, "SELECT thread_id FROM thread");
            echo mysqli_num_rows($res);
          ?>
        </h2>
      </div>
    </div>
  </div>

  <!-- COMMENTS -->
  <div class="col-md-3">
    <div class="card dashboard-card shadow-sm text-center">
      <div class="card-body">
        <h6 class="text-muted">Comments</h6>
        <h2>
          <?php
            $res = mysqli_query($con, "SELECT comment_id FROM comments");
            echo mysqli_num_rows($res);
          ?>
        </h2>
      </div>
    </div>
  </div>

  <!-- CONTACT MESSAGES -->
<div class="col-md-3">
  <div class="card dashboard-card shadow-sm text-center">
    <div class="card-body">
      <h6 class="text-muted">Contact Messages</h6>
      <h2>
        <?php
          $res = mysqli_query($con, "SELECT id FROM contact_messages");
          echo mysqli_num_rows($res);
        ?>
      </h2>
    </div>
  </div>
</div>

</div>
</div>
<?php require 'partials/footer.php'; ?>
