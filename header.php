<?php
include "admin/config.php";
$page = basename($_SERVER['PHP_SELF']);
switch($page){
    case "single.php":
        if(isset($_GET["id"])){
            $sql = "SELECT title from post where post_id = {$_GET['id']}";
            $result = mysqli_query($connection,$sql);
            $row = mysqli_fetch_assoc($result);
            $page_title = $row['title'];
        }
        break;

    case "category.php":
        if(isset($_GET["category"])){
            $sql = "SELECT category_name from category where category_name = '{$_GET['category']}'";
            $result = mysqli_query($connection,$sql);
            $row = mysqli_fetch_assoc($result);
            $page_title = $row['category_name'];
        }
        break;

    case "author.php":
        if(isset($_GET["author"])){
            $sql = "SELECT first_name,last_name from user where username = '{$_GET['author']}'";
            $result = mysqli_query($connection,$sql);
            $row = mysqli_fetch_assoc($result);
            $page_title = $row['first_name']." ".$row['last_name'];
        }
        break;
    case "search.php":
        if(isset($_GET["search"])){
            $page_title = $_GET['search'];
        }
        break;
    default :
        $page_title = "news";
        break;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title  ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class='menu'>
                        <li><a href='index.php'>Home</a></li>
                        <?php

                        $select_query = "SELECT * FROM category";
                        $select_result  = mysqli_query($connection, $select_query);

                        while ($row = mysqli_fetch_assoc($select_result)) {
                        ?>
                            <li><a href='category.php?category=<?php echo htmlspecialchars($row['category_name']); ?>'><?php echo htmlspecialchars($row['category_name']); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->