<?php
include('../includes/header.php');
include('../db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image'];

    $author_id = $_SESSION['user_id'];

    $query = "INSERT INTO blogs (title, content, image_url, author_id) VALUES ('$title', '$content', '$image_url', '$author_id')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: blogs.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<div class="container mt-5">
    <h2>Add a New Blog</h2>
    <form method="POST">
        <div class="form-group mb-3">
            <label for="title">Blog Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mb-3">
            <label for="content">Blog Content:</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="image">Image URL:</label>
            <input type="text" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Blog</button>
    </form>
</div>

<?php
include('../includes/footer.php');
?>
