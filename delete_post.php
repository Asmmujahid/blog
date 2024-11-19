<?php
include 'Database.php';
$db = new Database();


if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    
    if ($db->deletePost($post_id)) {
    
        header("Location: manage_post.php");
        exit;
    } else {
    
        echo "Error: Could not delete the post.";
    }
} else {
    
    header("Location: manage_post.php");
    exit;
}
?>
