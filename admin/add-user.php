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
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    if(preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/",$password)){
    $select_query = "SELECT * from user where username = '$user'";
    $select_result = mysqli_query($connection,$select_query); 
    if($select_result){
        if(mysqli_num_rows($select_result) > 0){
            $showError = "User Already Existing.";
        }else{
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO `user`(`first_name`, `last_name`, `username`, `password`, `role`) VALUES ('$fname','$lname','$user','$hash','$role')";
            $insert_result = mysqli_query($connection,$insert_query);
            header("location:users.php");
        }
    }
}else{
    $showError = "Password must be at least 8 characters and include uppercase, lowercase and number.";
}
}
?>

    <!-- if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/", $password)) {
        // Prepared SELECT to check existing user
        $stmt = $connection->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $showError = "User already exists.";
        } else {
            // Hash the password securely
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepared INSERT to add user
            $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, username, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $fname, $lname, $user, $hash_password, $role);
            $stmt->execute();
        }
        $stmt->close();
    } else {
        $showError = "Password must be at least 8 characters and include uppercase, lowercase and number.";
    }
} -->


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>

              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <?php if (!empty($showError)): ?>
    <div style="color: red; margin: 10px 0px; text-align:center"><?php echo $showError; ?></div>
<?php endif; ?>
                  <form  action="" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin User</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>




