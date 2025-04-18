<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Froum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
  .container{
    min-height: 83vh;
  }
</style>

<body>
<?php include './dbconnect.php'; ?> 

  <?php include './partials/header.php'; ?>



  





<!-- Search Result starts here -->

<div class="container my-3">
    <div class="search">
        <h1 class=py-3>Search Result for <em> <?php echo $_GET['search']?> </em></h1>
        
        <!-- <?php
        $search = mysqli_real_escape_string($conn, $_GET['search']);
          $sql = "SELECT * FROM thread_table WHERE MATCH (thread_title,thread_desc) against ('$search')";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
              $thr_title = $row['thread_title'];
              $thr_desc = $row['thread_desc'];
              $thr_id=$row['thread_id'];
              $url="threadlist.php?catid=".$thr_id;

          
          
              echo'
              <div class="result">
                <h3><a href="'. $url  .'" class="text-dark">'. $thr_title .'</a> </h3>
                <p>'. $thr_desc .' </p>
            </div>';
       
      }
          ?> -->

          <?php
          $search = mysqli_real_escape_string($conn, $_GET['search']); // sanitize input

          $sql = "SELECT * FROM thread_table WHERE MATCH (thread_title,thread_desc) AGAINST ('$search')";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $thr_title = $row['thread_title'];
                  $thr_desc = $row['thread_desc'];
                  // $url="threadlist.php?catid=".$thr_id;


                  echo '<h3><a href="" class="text-dark">' . $thr_title . '</a></h3>';
                  echo '<p>' . $thr_desc . '</p>';
              }
          } else {
              echo "<p>No results found for <em>$search</em></p>";
          }
          ?>

    </div>
</div>

















  <?php include './partials/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>