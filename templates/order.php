<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db.php';

// Fetch sales information with manuscript details
$sales_query = "
    SELECT s.customer_name, s.contact_info, m.title AS manuscript_title, s.quantity, s.order_date, s.revenue
    FROM sales s
    LEFT JOIN manuscripts m ON s.manuscript_id = m.manuscript_id
";
$sales_result = $conn->query($sales_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the table in the viewport */
        .table-container {
            max-width: 1000px;
            margin: auto;
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

    <div class="container mt-5 table-container">
        <h2 class="mb-4">Sales Records</h2>
        <?php if ($sales_result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Contact Info</th>
                        <th>Manuscript Selected</th>
                        <th>Quantity Ordered</th>
                        <th>Date of Order</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $sales_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_info']); ?></td>
                            <td><?php echo htmlspecialchars($row['manuscript_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['revenue']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No sales records found.</p>
        <?php endif; ?>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            &copy; 2024 Publication System. All rights reserved.
        </div>
    </footer>
</body>
</html>
