<?php
include('includes/header.php');
include('db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists.')</script>";
        header("Refresh: 1; url=register.php");
        exit();
    }

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    
    // Check if the query is successful
    
    if ($conn) {
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error connecting to the database.";
    }
}

mysqli_close($conn);
?>

<div class="container mt-5">
    <h2>Register</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php
include('includes/footer.php');
?>
