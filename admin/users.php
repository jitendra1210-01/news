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
$limit = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit;
$select_query = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}";

$select_result = mysqli_query($connection, $select_query);



?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">

                <?php  
                if(isset($_SESSION['error'])){
                       echo  '<div style="color: red; margin: 10px 0px; text-align:center">'.$_SESSION['error'].'</div>';
                       unset($_SESSION["error"]);
                }?>
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                        if ($select_result) {

                            $i = $offset + 1;
                            while ($row = mysqli_fetch_assoc($select_result)) {
                                $fname = $row['first_name'];
                                $lname = $row['last_name'];
                                $username = $row['username'];
                                $role = $row['role']; ?>
                                <tr>
                                    <td class='id'><?php echo $i ?></td>
                                    <td><?php echo htmlspecialchars($fname . " " . $lname); ?></td>
                                    <td><?php echo htmlspecialchars($username); ?></td>
                                    <?php
                                    if ($role == 1) {
                                    ?>
                                        <td><?php echo htmlspecialchars("Admin"); ?>
                                        <?php } else {
                                        ?>
                                        <td><?php echo htmlspecialchars("Normal"); ?>

                                        <?php } ?>
                                        </td>
                                        <td class='edit'><a href='update-user.php?id=<?php echo ($row['user_id']); ?>'><i class='fa fa-edit'></i></a></td>
                                        <td class='delete'><a href='delete.php?user_id=<?php echo ($row['user_id']); ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No Data Found</td></tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>
                <?php
                $sql = "SELECT * from user";
                $result = mysqli_query($connection, $sql);
                $total_user = mysqli_num_rows($result);
                $total_page = ceil($total_user / $limit);
                
                if($total_page >1){
                echo "<ul class='pagination admin-pagination'>";
                if($page > 1){
                    echo "<li><a href='users.php?page=".($page - 1)."'>Prev</a></li>";
                }
                
                for ($i = 1; $i <= $page; $i++) {
                    if($page == $i){
                        $active = "active";
                    }
                    else{
                        $active = "";
                    }
                    echo "<li class='".$active."'><a href='users.php?page={$i}'>" . $i . "</a></li>";
                }
                if($total_page > $page){
                    echo "<li><a href='users.php?page=".($page + 1)."'>Next</a></li>";
                }
                echo "</ul>";
            }
            ?>
                <!-- <li class="active"><a>1</a></li>
                    <li><a>3</a></li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>