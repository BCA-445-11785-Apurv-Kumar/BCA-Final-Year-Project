<!doctype html>
<html lang="en">

<head>
  <style>
    .container{
        min-height: 64vh;
    }
    .a{
        text-decoration: none;
    }

  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to iDiscuss - Coding Forums</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
  <?php 
  include "dbconnect.php";
  include "partials/_header.php";
   ?>

    <!-- Search Results -->
    <div class="container">
        <h1 class="py-3">Search results for <em>"<?php echo $_GET['search']?>"</em></h1>

        <?php 
        $noresults = false ;
  $query = $_GET["search"];
  $sql = "SELECT * FROM `thread` WHERE MATCH (`thread_title`, `thread_desc`) AGAINST ('$query')";
  $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 0){
      echo '
                <section class="bg-light py-5">
                    <div class="container-fluid">
                        <h1 class="display-4">No Results Found</h1>
                        <p class="lead">Suggestions:</p>
                        <ul>
                        <li>Make sure that all words are spelled correctly.</li>
                        <li>Try different keywords.</li>
                        <li>Try more general keywords.</li>
                        </ul>
                    </div>
                </section>';
    }

  while($row = mysqli_fetch_assoc($result)){
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_id = $row['thread_id'];
    $url = "thread.php?threadid=". $thread_id;
 
    //Display the search result
  echo '<div class="result">
            <h3><a href='. $url.'" class="text-dark a">'. $title .'</h3></a>
            <p>
            '. $desc .'
            </p>
        </div>';
  }
  ?>
        
    </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
<?php include "partials/_footer.php" ?>