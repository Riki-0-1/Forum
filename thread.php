<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Froum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    #ques {
        min-height: 440px;
    }
</style>

<body>
    <?php include './partials/header.php'; ?>

    <?php include './dbconnect.php'; ?>
    <?php
    $cat_id = $_GET['threads_id'];
    $sql = "SELECT * FROM `thread_table` WHERE thread_id=$cat_id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $thr_title = $row['thread_title'];
        $thr_desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        // Query the users table to find out the name of OP
        $sql2 = "SELECT signupEmail FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['signupEmail'];
    }
    ?>

    <?php
    // this php is for form
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        // insert into comments db
        $com_comment = $_POST['comment'];
        
        $comment = str_replace("<", "&lt;", $com_comment);
        $comment = str_replace(">", "&gt;", $com_comment); 
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$com_comment', '$cat_id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added! .
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            ';
        }
    }
    ?>





    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $thr_title; ?> </h1>
            <p class="lead"> <?php echo $thr_desc; ?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other.
                No Spam / Advertising / Self-promote in the forums,
                Do not post copyright-infringing material,
                Do not post “offensive” posts, links or images,
                Do not advertise on the support forums,
                Do not offer to pay for help,
                Do not post about commercial products,
                Do not create multiple accounts,
                Be mindful when creating links to external resources.</p>
            <p class="lead">
                <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
            <p>Posted by : <em><?php echo $posted_by; ?></em></p>
            </p>
        </div>
        <!-- <div class="container">
            <h1 class="py-2">Post a Comment </h1>
            <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">

                <div class="form-group">
                    <label for="comment" class="form-label">Type your comments</label>
                    <textarea class="form-control" id="comment" name=comment rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success my-3">Post Comments</button>
            </form>

        </div> -->
        <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
   echo' <div class="container">
            <h1 class="py-2">Post a Comment </h1>
            <form action=" '. $_SERVER['REQUEST_URI'] .' " method="post">

                <div class="form-group">
                    <label for="comment" class="form-label">Type your comments</label>
                    <textarea class="form-control" id="comment" name=comment rows="3"></textarea>
                    <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
                </div>
                <button type="submit" class="btn btn-success my-3">Post Comments</button>
            </form>

        </div>';
}
else{
    echo'
    <div class="container">
    <h1 class="py-2">Post a Comment</h1> 
    <p class="lead"> <strong> You are not logged in. Please login to be able to post comments.</strong> </p>
    </div>';
}
    ?>


    </div>
    <div class="container my-4 mb-5" id="ques">
        <h1 class="py-2">Discussion </h1>
        <?php
        //  for comment
        $cat_id = $_GET['threads_id'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$cat_id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noresult = false;
            $com_id = $row['comment_id'];
            $com_content = $row['comment_content'];
            $com_time = $row['comment_time'];
            $thread_user_id = $row['comment_by']; 

            $sql2 = "SELECT signupEmail FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="d-flex">
        <img class="align-self-center me-3" src="./upload_image/user_default.png" width="35px" alt="Generic placeholder image">
        <div>
        <p class="fw-bold my-0">'. $row2['signupEmail'] .' at ' . $com_time . '</p>
            <p>' . $com_content . '</p>
        </div>
    </div>';
        }
        //    echo var_dump($noresult) ;
        if ($noresult) {
            echo ' <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <p class="display-6">No Comments Found</p>
                                <p class="lead">Be the first person to comment.</p>
                            </div>
                            </div>
            ';
        }
        ?>

    </div>















    <?php require './partials/footer.php'; ?>










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>