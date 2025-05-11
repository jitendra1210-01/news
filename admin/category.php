<?php include "header.php"; ?>
<?php
// Redirect to login if not logged in
include "config.php";
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
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$limit = 5;
$offset = ($page - 1) * $limit;

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Category Name</th>
                            <th>No. of Posts</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $select_query = "SELECT * FROM category order by category_id desc limit {$offset},{$limit}";
                        $select_result  = mysqli_query($connection, $select_query);

                        if (mysqli_num_rows($select_result) > 0) {
                            $i = $offset + 1;
                            while ($row = mysqli_fetch_assoc($select_result)) {
                                echo "<tr>
                        <td class='id'>{$i}</td>
                        <td>" . htmlspecialchars($row['category_name']) . "</td>
                        <td>" . htmlspecialchars($row['post']) . "</td>
                        <td class='edit'><a href='update-category.php?id=" . htmlspecialchars($row["category_id"]) . "'><i class='fa fa-edit'></i></a></td>
                        <td class='delete'><a href='delete.php?category_id=" . htmlspecialchars($row["category_id"]) . "'><i class='fa fa-trash-o'></i></a></td>
                    </tr>";
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No Data Found</td></tr>";
                        }


                        ?>
                    </tbody>
                </table>

                <?php
                $count_query = "SELECT * from Category";
                $count_result = mysqli_query($connection, $count_query);
                $total_category  = mysqli_num_rows($count_result);
                $total_page = ceil($total_category / $limit);

                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo "<li><a href=category.php?page=" . ($page - 1) . ">Prev</a></li>";
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($page == $i) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    echo " <li class='" . $active . "'><a href=category.php?page=" . $i . ">" . $i . "</a></li>";
                }
                if ($total_page > $page) {
                    echo "<li><a href=category.php?page=" . ($page + 1) . ">Next</a></li>";
                }
                echo "</ul>";
                ?>

            </div>

        </div>
    </div>
</div>
<?php include "footer.php"; ?>