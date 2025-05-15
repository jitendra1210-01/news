<?php include "header.php"; ?>
<?php
include "config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if($_SESSION['role'] == 0){
    $pid = $_GET['id'];
    $sql1 = "SELECT author from post where post_id={$pid}";
    $result1 = mysqli_query($connection,$sql1);
    $row1 = mysqli_fetch_assoc($result1);
    if($row1['author'] != $_SESSION['user_id']){
        header("location:post.php");
    }


}


// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['post_title'];
    $details = $_POST['postdesc'];
    $category = isset($_POST['category']) ? $_POST['category'] : null;
    $old_image = $_POST['old-image'];
    $image_name = $old_image; 


    if (!empty($_FILES["new-image"]["name"])) {
        $new_image_name = $_FILES['new-image']["name"];
        $new_image_tmp = $_FILES['new-image']['tmp_name'];
        $new_image_size = $_FILES['new-image']['size'];

        if ($new_image_size <= (2 * 1024 * 1024)) { 
            if (move_uploaded_file($new_image_tmp, "upload/".$new_image_name)) {
                
                if (file_exists("upload/" . $old_image)) {
                    unlink("upload/" . $old_image);
                }
                $image_name = $new_image_name;
            }
        }
    }
        $update_query = "UPDATE post SET title='$title', description='$details', category=$category, post_img='$image_name' WHERE post_id = $id;";
        if($_POST["old_category"] != $_POST['category']){
            $update_query .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
            $update_query .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']}";
        }
        $update_result = mysqli_multi_query($connection, $update_query);

    if ($update_result) {
        header("Location: post.php");
        exit;
        
    }
}
}
?>

<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
          <?php
                    $select_query = "SELECT * from post left join category   on post.category = category.category_id where post_id = $id";
                    $select_result = mysqli_query($connection, $select_query);

                    if ($select_result) {
                        $row = mysqli_fetch_assoc($select_result);
                             $title = $row['title'];
                             $details = $row['description'];
                             $category = $row['category_name'];
                             $image_name = $row['post_img']; ?>
                   
        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
            
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo htmlspecialchars($title)?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo htmlspecialchars($details)?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select name="category" class="form-control" required>
                        <option value="" disabled>Select Category</option>
                        <?php
                        $c_query = "SELECT * FROM category";
                        $c_result = mysqli_query($connection, $c_query);
                        while ($cat = mysqli_fetch_assoc($c_result)) {
                            $selected = ($row['category_id'] == $cat['category_id']) ? "selected" : "";
                            echo "<option value='{$cat['category_id']}' $selected>{$cat['category_name']}</option>";
                        }
                        ?>
                </select>
                <input type="hidden" name="old_category" value="<?php echo $row['category'] ?>">
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image" accept="image/*">
                <img  src="upload/<?php echo htmlspecialchars($image_name)?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo htmlspecialchars($image_name)?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <?php }
        ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
