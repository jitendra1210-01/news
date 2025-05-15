<?php include "header.php";
include "config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['post_title'];
    $details = $_POST['postdesc'];
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    } else {
        $category = "Uncategorized";
    }
    $date = date("d M,Y");
    $author = $_SESSION['user_id'];
    if (isset($_FILES["fileToUpload"])) {
        $image_name = $_FILES['fileToUpload']["name"];
        $image_tmp = $_FILES['fileToUpload']['tmp_name'];
        $image_size = $_FILES['fileToUpload']['size'];
        if ($image_size < (2 * 1024 * 1024)) {
            move_uploaded_file($image_tmp, "upload/" . $image_name);
            $insert_query = "INSERT INTO `post`(`title`, `description`, `category`, `post_date`, `author`, `post_img`) 
VALUES ('$title','$details','$category','$date','$author','$image_name')";
            $insert_result = mysqli_query($connection, $insert_query);

            if ($insert_result && isset($_POST['category'])) {
                $category = $_POST['category'];
                $update_query = "UPDATE category SET post = post + 1 WHERE category_id = $category";
                mysqli_query($connection, $update_query);
            }
            if ($insert_result) {
                header("location:post.php");
            }
        }else{
            $showError = "Please upload image less than 2 MB.";
        }
    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                 <?php if (!empty($showError)): ?>
                         <div style="color: red; margin: 10px 0px; text-align:center"><?php echo $showError; ?></div>
<?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <select name="category" class="form-control">
                            <option value="" disabled> Select Category</option>
                            <?php
                            $c_query = "SELECT * from category";
                            $c_result = mysqli_query($connection, $c_query);
                            while ($row = mysqli_fetch_assoc($c_result)) {
                                echo "<option value=" . $row['category_id'] . ">" . $row['category_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Post image</label>
                        <input type="file" name="fileToUpload" accept="image/*" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
                <!--/Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>