<?php include 'header.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <?php
                    $select_query = "SELECT p.post_id,p.title, IFNULL(c.category_name, 'Uncategorized') AS category_name, p.post_date, u.username,p.description,p.post_img FROM post p LEFT JOIN category c ON p.category = c.category_id LEFT JOIN user u ON u.user_id = p.author where post_id = $id";
                    $select_result = mysqli_query($connection, $select_query);
                    if ($select_result) {
                        $row = mysqli_fetch_assoc($select_result); ?>
                        <div class="post-container">
                            <div class="post-content single-post">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <div class="post-information">
                                    <span>
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <?php echo htmlspecialchars($row['category_name']); ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <a href='author.php'><?php echo htmlspecialchars($row['username']); ?></a>
                                    </span>
                                    <span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <?php echo htmlspecialchars($row['post_date']); ?>
                                    </span>
                                </div>
                                <img class="single-feature-image" src="admin/upload/<?php echo htmlspecialchars($row['post_img']); ?>" alt="" />
                                <p class="description">
                                    <?php echo htmlspecialchars($row['description']); ?></p>
                            </div>
                        </div>
                <?php }
                } ?>
                <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>