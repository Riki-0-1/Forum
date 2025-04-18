<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Froum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    $cat_id = $_GET['catid'];
    $sql = "SELECT * FROM `forum_table` WHERE category_id=$cat_id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>


    <?php
    // this php is for form
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        // insert into thread
        $thr_title = $_POST['title'];
        $thr_desc = $_POST['desc'];
        // $thr_id=$_POST['category_id'];


        $thr_title = str_replace("<", "&lt;", $thr_title);
        $thr_title = str_replace(">", "&gt;", $thr_title); 

        $thr_desc = str_replace("<", "&lt;", $thr_desc);
        $thr_desc = str_replace(">", "&gt;", $thr_desc); 

        $sno=$_POST['sno'];
        $sql = "INSERT INTO `thread_table` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$thr_title', '$thr_desc', '$cat_id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            ';
        }
    }
    ?>





   

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to
                <?php echo $catname; ?> Forum
            </h1>
            <p class="lead">
                <?php echo $catdesc; ?>
            </p>
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
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>

    </div>

    <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
   echo' <div class="container">
        <h1 class="py-2">Start a Discussion </h1>
        <form action=" '. $_SERVER['REQUEST_URI'] .' " method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short as possible.</div>
            </div>
            <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
            <div class="form-group">
                <label for="desc" class="form-label">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success my-3">Submit</button>
        </form>

    </div>';
}
else{
    echo'
    <div class="container">
    <p class="lead">You are not logged in. Please login to be able to start a Discussion</p>
    </div>';
}
    ?>

    <div class="container my-4 mb-5" id="ques">
        <?php
        $cat_id = $_GET['catid'];
        $sql = "SELECT * FROM `thread_table` WHERE thread_cat_id=$cat_id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noresult = false;

            $th_title = $row['thread_title'];
            $th_desc = $row['thread_desc'];
            $th_id = $row['thread_id'];
            $thread_time = $row['timestamp']; 
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT signupEmail FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<div class="d-flex">
        <img class="align-self-center me-3" src="./upload_image/user_default.png" width="35px" alt="Generic placeholder image">
        <div>'.
            '<h5 class="mt-0"> <a class="text-dark" href="thread.php?threads_id=' . $th_id . ' "> ' . $th_title . '</a> </h5>
            '. $th_desc .'<div class="font-weight-bold my-0"> Asked by: '. $row2['signupEmail'] . ' at '. $thread_time. '</div>'.
        '</div>
    </div>';
        }
        //    echo var_dump($noresult) ;
        if ($noresult) {
            echo ' <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <p class="display-6">No Threads Found</p>
                                <p class="lead">Be the first person to ask a question.</p>
                            </div>
                            </div>
            ';
        }
        ?>



        <!-- remove later added just to check html alignment -->

        <!-- <div class="d-flex">
        <img class="align-self-center me-3" src="./upload_image/user_default.png" width="35px" alt="Generic placeholder image">
        <div>
            <h5 class="mt-0">Unable to install Pycharm in Windows</h5>
            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
        </div>
    </div> -->



    </div>
























    <?php include './partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>