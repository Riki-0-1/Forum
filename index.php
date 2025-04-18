<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Froum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
  #ques{
    min-height: 440px;
  }
</style>

<body>
  <?php include './partials/header.php'; ?>
  <?php include './dbconnect.php'; ?> 



  <!-- slider start -->
  <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./upload_image/mountain.jpg" class=" d-block w-100 "style="height: 500px;" alt="...">
      </div>
      <div class="carousel-item">
        <img src="./upload_image/mountain.jpg" class="d-block w-100 " style="height: 500px;" alt="...">
      </div>
      <div class="carousel-item">
        <img src="./upload_image/mountain.jpg" class="d-block w-100 " style="height: 500px;" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>









  <div class="container my-4" id="ques" >
    <h2 class="text-center my-3">GCR-Discuss Browse Categories </h2>


    <div class="row">
<!-- fetch all categories -->

<!-- using while loop to iterate the categories  -->
    <?php 
    $sql="SELECT * FROM `forum_table`";
    $result=mysqli_query($conn,$sql); 
    while($row = mysqli_fetch_assoc($result)){
      $cat_id= $row['category_id'] ;
      $cat_name= $row["category_name"];
      $cat_desc=$row["category_description"];
      // echo '<div class="col-md-4 my-2">
      //   <div class="card" style="width: 18rem;">
      //     <img src="car.webp" class="card-img-top" alt="...">
      //     <div class="card-body">
      //       <h5 class="card-title"> '. $cat_name .' </h5>
      //       <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>
      //       <a href="#" class="btn btn-primary">riki</a>
      //     </div>
      //   </div>
      // </div>';
      echo "<div class='col-md-4 my-2'>
        <div class='card' style='width: 18rem;'>
          <img <img src='https://picsum.photos/500/300?". $cat_name . ",programming' class='card-img-top' alt='Random Unsplash Image'>
          <div class='card-body'>
            <h5 class='card-title'> <a href='./threadlist.php?catid=". $cat_id . " '>". $cat_name . "</a> </h5>
            <p class='card-text'>". substr($cat_desc, 0, 185 ). " .....</p>
            <a href='./threadlist.php?catid=". $cat_id . " ' class='btn btn-primary'>View Threads</a>
          </div>
        </div>
      </div>";
       

    };
    

    
    ?>



<!-- use a for loop to iterate categories -->
      
   
    </div>
  </div>

















  <?php include './partials/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>