<?php include 'header.php';
include "admin/config.php";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$limit = 2;
$offset = ($page - 1) * $limit;
if (isset($_GET['author'])) {
    $author = $_GET['author'];

?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">
                        <h2 class="page-heading">Author Name :<?php echo $author ?></h2>
                        <?php
                        $select_query = "SELECT p.post_id,p.title, IFNULL(c.category_name, 'Uncategorized') AS category_name, p.post_date, u.username,p.description,p.post_img 
                         FROM post p 
                         LEFT JOIN category c ON p.category = c.category_id 
                         LEFT JOIN user u ON u.user_id = p.author
                         where u.username = '{$author}'
                         ORDER BY p.post_id DESC 
                         LIMIT {$offset}, {$limit}";
                        $select_result = mysqli_query($connection, $select_query);

                        if (mysqli_num_rows($select_result) > 0) {

                            while ($row = mysqli_fetch_assoc($select_result)) {
                        ?>
                                <div class="post-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="post-img" href="single.php?id=<?php echo htmlspecialchars($row['post_id']); ?>"><img src="admin/upload/<?php echo htmlspecialchars($row['post_img']); ?>" alt="" /></a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="inner-content clearfix">
                                                <h3><a href='single.php?id=<?php echo htmlspecialchars($row['post_id']); ?>'><?php echo htmlspecialchars($row['title']); ?></a></h3>
                                                <div class="post-information">
                                                    <span>
                                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                                        <a href='category.php?category=<?php echo htmlspecialchars($row['category_name']);?>'><?php echo htmlspecialchars($row['category_name']); ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <a href='author.php?author=<?php echo htmlspecialchars($row['username']);?>'><?php echo htmlspecialchars($row['username']); ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo htmlspecialchars($row['post_date']); ?>
                                                    </span>
                                                </div>
                                                <p class="description">
                                                    <?php echo htmlspecialchars($row['description']); ?></p>
                                                <a class='read-more pull-right' href='single.php?id=<?php echo htmlspecialchars($row['post_id']); ?>'>read more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>

                    <?php
                    $count_query = "SELECT * from post p left join user u on p.author = u.user_id where u.username = '{$author}'";
                    $count_result = mysqli_query($connection, $count_query);
                    $total_category  = mysqli_num_rows($count_result);
                    $total_page = ceil($total_category / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                    if ($total_page > 1) {
                            echo "<ul class='pagination admin-pagination'>";
                            if ($page > 1) {
                                echo "<li><a href='author.php?author=" . urlencode($author) . "&page=" . ($page - 1) . "'>Prev</a></li>";
                            }
                            for ($i = 1; $i <= $total_page; $i++) {
                                $active = ($i == $page) ? "active" : "";
                                echo "<li class='$active'><a href='author.php?author=" . urlencode($author) . "&page=$i'>$i</a></li>";
                            }
                            if ($page < $total_page) {
                                echo "<li><a href='author.php?author=" . urlencode($author) . "&page=" . ($page + 1) . "'>Next</a></li>";
                            }
                            echo "</ul>";
                }} ?>
                    </div><!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>