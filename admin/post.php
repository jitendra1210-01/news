<?php include "header.php"; ?>
<?php
include "config.php";
// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$limit = 10;
$offset = ($page - 1) * $limit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="refresh" content="10"> -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="admin-heading">All Posts</h1>
                </div>
                <div class="col-md-2">
                    <a class="add-new" href="add-post.php">add post</a>
                </div>
                <div class="col-md-12">
    <table class="content-table">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Author</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if($_SESSION['role'] == 1){
        $select_query = "SELECT p.post_id,p.title, c.category_name, p.post_date, u.username 
                         FROM post p 
                         LEFT JOIN category c ON p.category = c.category_id 
                         LEFT JOIN user u ON u.user_id = p.author 
                         ORDER BY p.post_id DESC 
                         LIMIT {$offset}, {$limit}";
        }elseif($_SESSION['role'] == 0){
         $select_query = "SELECT p.post_id,p.title, c.category_name, p.post_date, u.username,u.role
                         FROM post p 
                         LEFT JOIN category c ON p.category = c.category_id 
                         LEFT JOIN user u ON u.user_id = p.author where u.role = {$_SESSION['role']}
                         ORDER BY p.post_id DESC 
                         LIMIT {$offset}, {$limit}";   
        }
        $select_result = mysqli_query($connection, $select_query);

        if (mysqli_num_rows($select_result) > 0) {
            $i = $offset + 1;
            while ($row = mysqli_fetch_assoc($select_result)) {
                echo "<tr>
                        <td>{$i}</td>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['category_name']) . "</td>
                        <td>" . htmlspecialchars($row['post_date']) . "</td>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td class='edit'><a href='update-post.php?id=" . htmlspecialchars($row['post_id']) . "'><i class='fa fa-edit'></i></a></td>
                        <td class='delete'><a href='delete.php?post_id=" . htmlspecialchars($row['post_id']) . "'><i class='fa fa-trash-o'></i></a></td>
                      </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center;'>No Records Found</td></tr>";
        }
        ?>
        </tbody>
    </table>

     <?php
              $count_query = "SELECT * from post";
                $count_result = mysqli_query($connection, $count_query);
                $total_category  = mysqli_num_rows($count_result);
                $total_page = ceil($total_category / $limit);

                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo "<li><a href=post.php?page=" . ($page - 1) . ">Prev</a></li>";
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($page == $i) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    echo " <li class='" . $active . "'><a href=post.php?page=" . $i . ">" . $i . "</a></li>";
                }
                if ($total_page > $page) {
                    echo "<li><a href=post.php?page=" . ($page + 1) . ">Next</a></li>";
                }
                echo "</ul>";  ?>
                

</div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <?php include "footer.php"; ?>
</body>

</html>