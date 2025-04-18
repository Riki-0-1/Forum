<?php
$servername="localhost";
$username="root";
$password="";
$database="forum";
// Database connection (update with your credentials)
$conn= new mysqli($servername,$username,$password,$database);

// $conn = new mysqli('localhost', 'username', 'password', 'forum');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if (isset($_POST['upload'])) {
    // Get image file info
    $image = $_FILES['image']['name'];
    $target = "upload_image/" . basename($image); // Directory to store the uploaded image

    // Allowed file types for security
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $file_extension = pathinfo($image, PATHINFO_EXTENSION);

    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.";
        exit;
    }

    // SQL query to insert image path into forum_table
    $sql = "INSERT INTO forum_table (image_path) VALUES ('$target')";

    // Execute query and move uploaded file to target directory
    if (mysqli_query($conn, $sql) && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "Image uploaded successfully!";
    } else {
        echo "Failed to upload image!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Display Image</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Upload an Image</h2>
        <!-- Upload Form -->
        <form action="upload_and_display.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="image" class="form-control-file">
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Upload Image</button>
        </form>

        <h2 class="my-4">Uploaded Images</h2>
        <div class="row">
            <?php
            // Fetch images from the forum_table
            $result = mysqli_query($conn, "SELECT * FROM forum_table");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='col-md-4 my-2'>
                        <div class='card' style='width: 18rem;'>
                          <img src='" . $row['image_path'] . "' class='card-img-top' alt='Uploaded Image'>
                          <div class='card-body'>
                            <h5 class='card-title'>Uploaded Image</h5>
                            <p class='card-text'>This is an image uploaded by the user.</p>
                          </div>
                        </div>
                      </div>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
