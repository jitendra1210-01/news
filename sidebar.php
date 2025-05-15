<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search ....." required>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php
        include "admin/config.php";
            $select_query = "SELECT p.post_id,p.title, IFNULL(c.category_name, 'Uncategorized') AS category_name, p.post_date, p.post_img 
             FROM post p 
             LEFT JOIN category c ON p.category = c.category_id 
             ORDER BY p.post_id DESC 
             LIMIT 5";
            $select_result = mysqli_query($connection, $select_query);

        if (mysqli_num_rows($select_result) > 0) {
            
            while ($row = mysqli_fetch_assoc($select_result)) {
        ?>
        <div class="recent-post">
            <a class="post-img" href="single.php?id=<?php echo htmlspecialchars($row['post_id']);?>">
                <img src="admin/upload/<?php echo htmlspecialchars($row['post_img']);?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?id=<?php echo htmlspecialchars($row['post_id']);?>"><?php echo htmlspecialchars($row['title']);?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?category=<?php echo htmlspecialchars($row['category_name']);?>'><?php echo htmlspecialchars($row['category_name']);?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo htmlspecialchars($row['post_date']);?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo htmlspecialchars($row['post_id']);?>">read more</a>
            </div>
        </div>
        <?php }} ?>
    </div>
    <!-- /recent posts box -->
</div>
