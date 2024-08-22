<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: db.php");
    exit;
}

// Include database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hash_password, $role);

    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        $error = "Error registering";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container form-container">
        <div class="card">
            <h2 class="text-center">Register</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="Author">Author</option>
                        <option value="Editor">Editor</option>
                        <option value="Publisher">Publisher</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="mt-3">Already Have an Account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

    <footer>
        <div class="text-center p-3">
            &copy; 2024 Publication System. All rights reserved.
        </div>
    </footer>

</body>

</html>
