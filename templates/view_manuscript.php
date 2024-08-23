<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

// Handle approve action
if (isset($_GET['approve_id'])) {
    $manuscript_id = $_GET['approve_id'];
    $stmt = $conn->prepare("UPDATE manuscripts SET status = 'Approved' WHERE manuscript_id = ?");
    $stmt->bind_param("i", $manuscript_id);
    $stmt->execute();
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $manuscript_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM manuscripts WHERE manuscript_id = ?");
    $stmt->bind_param("i", $manuscript_id);
    $stmt->execute();
}

// Fetch all manuscripts
$result = $conn->query("SELECT m.manuscript_id, m.title, m.submission_date, m.due_date, m.status, c.name AS author, e.name AS editor 
                        FROM manuscripts m
                        LEFT JOIN contributor c ON m.author_id = c.id
                        LEFT JOIN contributor e ON m.editor_id = e.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Manuscripts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar included -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Manuscripts</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Submission Date</th>
                    <th>Due Date</th>
                    <th>Editor</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['editor']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php else: ?>
                                <span class="badge bg-success">Approved</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="view_manuscript.php?approve_id=<?php echo $row['manuscript_id']; ?>" class="btn btn-success btn-sm">Approve</a>
                            <?php endif; ?>
                            <a href="view_manuscript.php?delete_id=<?php echo $row['manuscript_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this manuscript?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            &copy; 2024 Publication System. All rights reserved.
        </div>
    </footer>

</body>
</html>
