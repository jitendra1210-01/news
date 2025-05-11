<?php include "header.php";
// Redirect to login if not logged in
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


include "config.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $fname = $_POST["f_name"];
        $lname = $_POST["l_name"];
        $username = $_POST["username"];
        $role = $_POST["role"];
        
        $update_query = "UPDATE user set first_name = '$fname',last_name = '$lname', username = '$username', role = '$role' where user_id = $id";
        $update_result = mysqli_query($connection,$update_query);
        if($update_result){
            header("location:users.php");
        }
    } ?>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="admin-heading">Modify User Details</h1>
                </div>
                <div class="col-md-offset-4 col-md-4">
                    <!-- Form Start -->
                    <?php
                    $select_query = "SELECT * from user where user_id = $id";
                    $select_result = mysqli_query($connection, $select_query);

                    if ($select_result) {
                        $row = mysqli_fetch_assoc($select_result);
                             $fname = $row['first_name'];
                             $lname = $row['last_name'];
                             $username = $row['username'];
                             $role = $row['role']; ?>
                            <form action="" method="POST" autocomplete="off">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="f_name" class="form-control" value="<?php echo htmlspecialchars($fname); ?>" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="l_name" class="form-control" value="<?php echo htmlspecialchars($lname); ?>" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>User Role</label>
                                    <select class="form-control" name="role">
                                        <option value="0" <?php if ($role == 0) echo "selected"; ?>>Normal User</option>
                                        <option value="1" <?php if ($role == 1) echo "selected"; ?>>Admin</option>
                                    </select>

                                </div>
                                <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                            </form>
                <?php }
                    }
                ?>
                <!-- /Form -->
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>