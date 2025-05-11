<?php include "header.php";
include 'config.php'; ?>
<?php
// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION['role'] == '0') {
    header("Location:post.php");
}

// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
if(isset($_GET["id"])){
    $id = $_GET['id'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $category = $_POST['cat_name'];

    $update_query = "UPDATE category SET Category_name = '$category' where category_id = '$id'";
    if(mysqli_query($connection,$update_query)){
        header("location:category.php");

    }
}
?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="adin-heading"> Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <form action="" method="POST">
                    <?php
                    $select_query = "SELECT * FROM category where category_id = '$id'";
                    $select_result  = mysqli_query($connection, $select_query);
                    if (mysqli_num_rows($select_result) > 0) {
                        $row = mysqli_fetch_assoc($select_result);
                    ?>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name'] ?>" placeholder="" required>
                        </div>
                    <?php  }} ?>
                    <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>