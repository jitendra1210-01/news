<!DOCTYPE html>
<html lang="en">
    <?php

    session_start();

    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ADMIN Panel</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header-admin">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-2">
                    <a href="post.php"><img class="logo" src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
                <!-- LOGO-Out -->
                <!-- USER DROPDOWN -->
                <div class="col-md-offset-8 col-md-2 text-right">
                    <div class="dropdown" style="margin-top: 10px;">
                        <button class="btn btn-default dropdown-toggle btn-sm" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 16px;">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?> <span class="caret"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>

                <!-- LOGO-Out -->

            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="admin-menubar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="admin-menu">
                            <li>
                                <a href="post.php">Post</a>
                            </li>
                            <?php
                            if ($_SESSION['role'] == '1') {
                            ?>
                            <li>
                                <a href="category.php">Category</a>
                            </li>
                            <li>
                                <a href="users.php">Users</a>
                            </li>
                        <?php } 
                        ?>
                           
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->
    <!-- jQuery (required for Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>