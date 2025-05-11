<?php include "header.php"; 
include "config.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if( $_SESSION['role'] == '0'){
    header("Location:post.php");
}


// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $category = $_POST["cat"];

    $select_query = "SELECT Category_name from Category where category_name = '$category'";
    $select_result = mysqli_query($connection,$select_query);
    if(mysqli_num_rows($select_result)>0){
        $showError = "Category Already Exist.";
    }else{

    $sql = "INSERT INTO `category`(`category_name`) VALUES ('$category');";
    $result = mysqli_query($connection,$sql);
    if($result){
        header("location:category.php");
    }
}
}
?>


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                    <?php if (!empty($showError)): ?>
                         <div style="color: red; margin: 10px 0px; text-align:center"><?php echo $showError; ?></div>
<?php endif; ?>
                  <form action="" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
