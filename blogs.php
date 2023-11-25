<?php
include('includes/header.php');
include('db/database.php');
?>

<div class="container mt-5">
    <h2>Blog Page</h2>

    <a href="functions/add_blog.php" class="btn btn-primary mt-3">Add New Blog</a>

    <?php
    $query = "SELECT * FROM blogs";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        foreach ($result as $row) {
            echo "<div class='card mt-3'>";
            echo "<img src='" . $row['image_url'] . "' class='card-img-top' alt='Image'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
            echo "<p class='card-text'>" . $row['content'] . "</p>";
            echo "<a href='comments.php?blog_id=" . $row['blog_id'] . "' class='btn btn-primary'>View Comments</a>";
            echo "</div></div>";
        }
    } else {
        echo "<p>No blogs available.</p>";
    }
    ?>
    
</div>

<?php
include('includes/footer.php');
mysqli_close($conn);
?>