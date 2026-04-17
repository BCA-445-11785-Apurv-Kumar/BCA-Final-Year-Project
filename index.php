<!doctype html>
<html lang="en">

<head>
  <style>
    .a {
      text-decoration: none;
    }
  </style>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to iDiscuss - Coding Forums</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "dbconnect.php"; ?>
<?php include "partials/_header.php"; ?>

<!-- SLIDER -->
<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/pic1.jpg" class="d-block w-100" height="400">
    </div>
    <div class="carousel-item">
      <img src="images/pic10.jpg" class="d-block w-100" height="400">
    </div>
    <div class="carousel-item">
      <img src="images/pic6.jpg" class="d-block w-100" height="400">
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- CATEGORY SECTION -->
<div class="container my-3">
  <h2 class="text-center">iDiscuss - Browse Categories</h2>

  <div class="row">

  <?php
  $sql = "SELECT * FROM `categories`";
  $result = mysqli_query($con, $sql);

  while ($row = mysqli_fetch_assoc($result)) {

    $id = $row['category_id'];
    $cat = $row['category_name'];
    $desc = $row['category_description'];
    $img = !empty($row['category_image']) ? $row['category_image'] : 'default.jpg';

    echo '<div class="col-md-4 my-2">
      <div class="card" style="width: 18rem;">
        
        <img src="images/' . $img . '" class="card-img-top" alt="..." width="300px" height="200px">

        <div class="card-body">
          <h5 class="card-title">
            <a class="text-dark a" href="threadlist.php?catid=' . $id . '">' . $cat . '</a>
          </h5>

          <p class="card-text">' . substr($desc, 0, 90) . '...</p>

          <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
        </div>
      </div>
    </div>';
  }
  ?>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<?php include "partials/_footer.php"; ?>

</body>
</html>