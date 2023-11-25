<?php
include('../db/database.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blog_id = mysqli_real_escape_string($conn, $_POST['blog_id']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $author_id = $_SESSION['user_id'];

    $query = "INSERT INTO comments (blog_id, comment, author_id) VALUES ('$blog_id', '$comment', '$author_id')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: ../comments.php?blog_id=".$blog_id);
        exit();
    } else {
        echo "An error occured. Please try again.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>