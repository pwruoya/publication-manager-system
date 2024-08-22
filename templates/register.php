<?php
// Start the session
session_start();

// Include the database connection
require_once 'db.php';

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Author, Editor, Publisher, etc.

    // Server-side validation for password
    if (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters.";
    } elseif (strcasecmp($password, $name) == 0) {
        $error_message = "Password should not be the same as your name.";
    } else {
        // Hash the password before storing
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password_hashed, $role);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_role'] = $role;
            header("Location: profile.php");
            exit;
        } else {
            $error_message = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Publication System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        // Client-side password validation
        function validatePassword() {
            var name = document.getElementById('name').value;
            var password = document.getElementById('password').value;
            var error = '';

            if (password.length < 6) {
                error = 'Password must be at least 6 characters long.';
            } else if (password.toLowerCase() === name.toLowerCase()) {
                error = 'Password should not be the same as your name.';
            }

            if (error) {
                document.getElementById('passwordError').innerText = error;
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Publication System</a>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center">Register</h3>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="register.php" method="POST" onsubmit="return validatePassword();">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <small id="passwordError" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="role">Register As</label>
                    <select name="role" class="form-control" id="role" required>
                        <option value="Author">Author</option>
                        <option value="Editor">Editor</option>
                        <option value="Publisher">Publisher</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</div>

<footer class="footer mt-5 py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; 2024 Publication System</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
