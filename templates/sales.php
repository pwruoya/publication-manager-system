<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

// Initialize message variable
$message = '';

// Fetch manuscripts for the dropdown
$manuscripts = [];
$manuscript_query = "SELECT manuscript_id, title FROM manuscripts";
$result = $conn->query($manuscript_query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $manuscripts[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $contact_info = $_POST['contact_info'];
    $quantity = $_POST['quantity'];
    $order_date = $_POST['order_date'];
    $revenue = $_POST['revenue'];
    $manuscript_id = isset($_POST['manuscript_id']) ? $_POST['manuscript_id'] : null;

    // Validate manuscript_id
    if ($manuscript_id === null || !is_numeric($manuscript_id)) {
        $message = '<div class="alert alert-warning" role="alert">Please select a valid manuscript.</div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO sales (customer_name, contact_info, quantity, order_date, revenue, manuscript_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssidsi", $customer_name, $contact_info, $quantity, $order_date, $revenue, $manuscript_id);
        
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success" role="alert">Sale record added successfully.</div>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the form card in the viewport */
        .card-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        /* Add some space between the card header and body */
        .card-header {
            margin-bottom: 15px;
        }

        /* Add some padding to the card body */
        .card-body {
            padding: 20px;
        }

        /* Style the footer */
        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar included -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <?php echo $message; // Display message ?>
        <div class="card card-container">
            <div class="card-header">
                <h2 class="mb-0">Enter Sales Information</h2>
            </div>
            <div class="card-body">
                <form action="sales.php" method="post">
                    <div class="mb-3">
                        <label for="manuscript_id" class="form-label">Select Manuscript</label>
                        <select class="form-select" id="manuscript_id" name="manuscript_id" required>
                            <option value="">Select a manuscript</option>
                            <?php foreach ($manuscripts as $manuscript): ?>
                                <option value="<?php echo htmlspecialchars($manuscript['manuscript_id']); ?>">
                                    <?php echo htmlspecialchars($manuscript['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_info" class="form-label">Contact Info</label>
                        <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity Ordered</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="order_date" class="form-label">Date of Order</label>
                        <input type="date" class="form-control" id="order_date" name="order_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="revenue" class="form-label">Revenue Generated</label>
                        <input type="number" class="form-control" id="revenue" name="revenue" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
