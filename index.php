<?php
include 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_folder = 'uploads/' . $image;

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($image_temp, $image_folder)) {
        $db = new Database();
        if ($db->__insert($title, $description, $image_folder, $status)) {
        
            header("Location: manage_post.php");
            exit();
        } else {
            echo "Failed to add post.";
        }
    } else {
        echo "Failed to upload image.";
    }
}

include 'index.html';
?>
