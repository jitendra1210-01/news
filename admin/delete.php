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

if (isset($_GET['post_id'])) {
    $id = $_GET['post_id'];
    $select = "SELECT post_img from post where post_id = $id";
    mysqli_query($connection,$select);
    if($row = mysqli_fetch_assoc(mysqli_query($connection,$select))){
        $image_name = $row['post_img'];
        if(file_exists("upload/".$image_name)){
            unlink("upload/".$image_name);
        }
    }
    $delete_query = "DELETE FROM post where post_id = $id";
    $delete_result = mysqli_query($connection,$delete_query);
    if($delete_result){
        header("location:post.php");
    }
}
?>