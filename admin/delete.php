<?php include "header.php";
include "config.php";
if (isset($_GET['user_id'])) {
    $id = $_GET['user_id'];
    $delete_query = "DELETE FROM user where user_id = $id";
    $delete_result = mysqli_query($connection,$delete_query);
    if($delete_result){
        header("location:users.php");
    }
}

if (isset($_GET['category_id'])) {
    $id = $_GET['category_id'];
    $delete_query = "DELETE FROM category where category_id = $id";
    $delete_result = mysqli_query($connection,$delete_query);
    if($delete_result){
        header("location:category.php");
    }
}

if (isset($_GET['post_id']) && isset($_GET['cid'])) {
    $id = (int) $_GET['post_id']; // cast to int to avoid injection
    $cid = (int) $_GET['cid'];

    // Get image name
    $select = "SELECT post_img FROM post WHERE post_id = $id";
    $result = mysqli_query($connection, $select);

    if ($row = mysqli_fetch_assoc($result)) {
        $image_name = $row['post_img'];
        if (file_exists("upload/" . $image_name)) {
            unlink("upload/" . $image_name);
        }
    }

    // Combine DELETE and UPDATE queries
    $delete_query = "DELETE FROM post WHERE post_id = $id;";
    $delete_query .= "UPDATE category SET post = post - 1 WHERE category_id = $cid;";

    // Execute both queries
    if (mysqli_multi_query($connection, $delete_query)) {
        header("Location: post.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

?>