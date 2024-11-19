<?php
include 'Database.php';
$db = new Database();


if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    
    $post = $db->fetchPostById($post_id);


    if (!$post) {
        header("Location: manage_post.php");
        exit;
    }
} else {
    header("Location: manage_post.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $image_folder = 'uploads/' . $image;


        if (move_uploaded_file($image_temp, $image_folder)) {
            $db->updatePost($post_id, $title, $description, $image_folder, $status);
        }
    } else {

        $image_folder = $post['image'];
        $db->updatePost($post_id, $title, $description, $image_folder, $status);
    }

    
    header("Location: manage_post.php");
    exit;
}
?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="edit.css">
    <title>Edit Post</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Post</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="<?php echo $post['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" required><?php echo $post['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" id="image">
                <p>Current Image:</p>
                <img src="<?php echo $post['image']; ?>" width="100" alt="Current Image">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status" required>
                    <option value="draft" <?php if ($post['status'] == 'draft') echo 'selected'; ?>>Draft</option>
                    <option value="publish" <?php if ($post['status'] == 'publish') echo 'selected'; ?>>Publish</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="manage_post.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

