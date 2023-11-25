<?php
include('includes/header.php');
include('db/database.php');

if (!isset($_GET['blog_id'])) {
    // Redirect to blogs.php if no blog_id is set
    header("Location: blogs.php");
    exit();
}

$blog_id = $_GET['blog_id'];

?>

<div class="container mt-5">
    <h2>Comments</h2>

    <?php
    $query = "SELECT * FROM comments WHERE blog_id = $blog_id AND parent_comment_id IS NULL";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th scope='col'>Comment ID</th><th scope='col'>Comment</th><th scope='col'>Comment Author</th></tr></thead>";
        echo "<tbody>";

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['comment_id'] . "</td>";
            echo "<td>" . $row['comment'] . "</td>";

            // Display the comment author's name if the user is an admin
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $admin_query = "SELECT is_admin FROM users WHERE user_id = $user_id";
                $admin_result = mysqli_query($conn, $admin_query);

                if ($admin_result && mysqli_num_rows($admin_result) > 0) {
                    $admin_row = mysqli_fetch_assoc($admin_result);

                    if ($admin_row['is_admin']) {
                        $author_id = $row['author_id'];
                        $author_query = "SELECT name FROM users WHERE user_id = $author_id";
                        $author_result = mysqli_query($conn, $author_query);

                        if ($author_result && mysqli_num_rows($author_result) > 0) {
                            $author_row = mysqli_fetch_assoc($author_result);
                            echo "<td>Comment by: " . $author_row['name'] . "</td>";
                        } else {
                            echo "<td>Unknown</td>";
                        }
                    } else {
                        // For non-admin users, display as "Anonymous"
                        echo "<td>Anonymous</td>";
                    }
                }
            }

            // Display replies for the current comment
            $comment_id = $row['comment_id'];
            $reply_query = "SELECT * FROM replies WHERE comment_id = $comment_id";
            $reply_result = mysqli_query($conn, $reply_query);

            if ($reply_result && mysqli_num_rows($reply_result) > 0) {
                foreach ($reply_result as $reply_row) {
                    echo "<tr>";
                    echo "<td>" . '' . "</td>";
                    echo "<td>Reply: " . $reply_row['reply'] . "</td>";

                    // Display the reply author's name if the user is admin
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $admin_query = "SELECT is_admin FROM users WHERE user_id = $user_id";
                        $admin_result = mysqli_query($conn, $admin_query);

                        if ($admin_result && mysqli_num_rows($admin_result) > 0) {
                            $admin_row = mysqli_fetch_assoc($admin_result);

                            if ($admin_row['is_admin']) {
                                $author_id = $reply_row['author_id'];
                                $author_query = "SELECT name FROM users WHERE user_id = $author_id";
                                $author_result = mysqli_query($conn, $author_query);

                                if ($author_result && mysqli_num_rows($author_result) > 0) {
                                    $author_row = mysqli_fetch_assoc($author_result);
                                    echo "<td>Reply by: " . $author_row['name'] . "</td>";
                                } else {
                                    echo "<td>Unknown</td>";
                                }
                            } else {
                                // For non-admin users, display as "Anonymous"
                                echo "<td>Anonymous</td>";
                            }
                        }
                    }

                    echo "</tr>";
                }
            }

            // Display reply form for logged-in users
            if (isset($_SESSION['user_id'])) {
                echo "<tr>";
                echo "<td colspan='3'>";
                echo "<form method='POST' action='functions/add_reply.php'>";
                echo "<input type='hidden' name='comment_id' value='" . $row['comment_id'] . "'>";
                echo "<input type='hidden' name='blog_id' value='" . $blog_id . "'>";
                echo "<div class='form-group'>";
                echo "<label for='reply'>Your Reply:</label>";
                echo "<textarea class='form-control mt-2' id='reply' name='reply' rows='2' required></textarea>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary mt-2'>Add Reply</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        }

        echo "</tbody></table>";

    } else {
        echo "<p>No comments available.</p>";
    }
    ?>

    <!-- Add Comment Section -->
    <form method="POST" action="functions/add_comment.php" class="mt-4">
        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
        <div class="form-group">
            <label for="comment">Your Comment:</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>
</div>

<?php
include('includes/footer.php');
mysqli_close($conn);
?>
