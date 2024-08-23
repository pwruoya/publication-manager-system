<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $editor_id = $_POST['editor_id'];
    $submitted_date = $_POST['submitted_date'];
    $due_date = $_POST['due_date'];
    $remarks = $_POST['remarks'];

    $stmt = $conn->prepare("INSERT INTO manuscripts (title, author_id, editor_id, submitted_date, due_date, remarks) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $author_id, $editor_id, $submitted_date, $due_date, $remarks);

    if ($stmt->execute()) {
        $success = "Manuscript submitted successfully!";
    } else {
        $error = "Error submitting manuscript";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Manuscript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar included -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="card-title mb-0">Submit Manuscript</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php elseif (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Manuscript Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="author_id" class="form-label">Select Author</label>
                                <select class="form-control" id="author_id" name="author_id" required>
                                    <!-- Options should be populated dynamically from the database -->
                                    <?php
                                    $result = $conn->query("SELECT id, name FROM contributor WHERE role='Author'");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editor_id" class="form-label">Select Editor</label>
                                <select class="form-control" id="editor_id" name="editor_id" required>
                                    <!-- Options should be populated dynamically from the database -->
                                    <?php
                                    $result = $conn->query("SELECT id, name FROM contributor WHERE role='Editor'");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="submitted_date" class="form-label">Submitted Date</label>
                                <input type="date" class="form-control" id="submitted_date" name="submitted_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Manuscript</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            &copy; 2024 Publication System. All rights reserved.
        </div>
    </footer>

</body>
</html>
