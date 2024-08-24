<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // Role can be Author, Editor, or Publisher

// Fetch user details
$user_query = $conn->prepare("SELECT name, email FROM users WHERE user_id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user_details = $user_result->fetch_assoc();

// Fetch summary details
$manuscripts_count = $conn->query("SELECT COUNT(*) as count FROM manuscripts")->fetch_assoc()['count'];

$auditors_result = $conn->query("SELECT COUNT(*) as count FROM contributor WHERE role = 'Author'");
$auditors_count = $auditors_result ? $auditors_result->fetch_assoc()['count'] : 'Error';

$editors_result = $conn->query("SELECT COUNT(*) as count FROM contributor WHERE role = 'Editor'");
$editors_count = $editors_result ? $editors_result->fetch_assoc()['count'] : 'Error';

$publishers_result = $conn->query("SELECT COUNT(*) as count FROM contributor WHERE role = 'Publisher'");
$publishers_count = $publishers_result ? $publishers_result->fetch_assoc()['count'] : 'Error';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .card-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px;
        }

        .card-summary:hover {
            transform: translateY(-5px);
        }

        .card-summary .card-body {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .card-summary .card-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .card-summary .card-text {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .card-header.bg-success {
            background: linear-gradient(90deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%);
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            gap: 10px;
        }
    </style>
</head>

<body>
    <!-- Navbar included -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

        <?php if ($user_role == 'Author'): ?>
            <h3>Your Manuscripts</h3>
            <a href="submit_manuscript.php" class="btn btn-primary">Submit New Manuscript</a>
        <?php elseif ($user_role == 'Editor'): ?>
            <h3>Manuscripts to Review</h3>
        <?php elseif ($user_role == 'Publisher'): ?>
            <h3>Published Books</h3>
        <?php endif; ?>

        <!-- User Details Card -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Your Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email']); ?></p>
            </div>
        </div>

        <!-- System Summary Cards -->
        <div class="row mt-4">
            <div class="col-md-3 mb-3">
                <div class="card card-summary text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manuscripts</h5>
                        <p class="card-text"><?php echo htmlspecialchars($manuscripts_count); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-summary text-center">
                    <div class="card-body">
                        <h5 class="card-title">Auditors</h5>
                        <p class="card-text"><?php echo htmlspecialchars($auditors_count); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-summary text-center">
                    <div class="card-body">
                        <h5 class="card-title">Editors</h5>
                        <p class="card-text"><?php echo htmlspecialchars($editors_count); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-summary text-center">
                    <div class="card-body">
                        <h5 class="card-title">Publishers</h5>
                        <p class="card-text"><?php echo htmlspecialchars($publishers_count); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer included -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            &copy; 2024 Publication System. All rights reserved.
        </div>
    </footer>

</body>

</html>
