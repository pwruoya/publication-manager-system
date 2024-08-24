<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publication System</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .navbar {
      background-color: #003366; /* Navy blue background color */
    }
    .navbar-brand {
      color: #fff !important;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
      font-size: 16px;
      transition: background-color 0.3s, color 0.3s;
    }
    .navbar-nav .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.3); /* Light hover effect */
      border-radius: 5px;
    }
    .navbar-nav .nav-link.btn {
      background-color: #dc3545; /* Red background for logout button */
      padding: 5px 15px;
      border-radius: 5px;
    }
    .navbar-nav .nav-link.btn:hover {
      background-color: #c82333; /* Darker red for hover */
    }
    .navbar-nav.mx-auto {
      flex-grow: 1;
      justify-content: center; /* Center the nav items */
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Publication System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto"> <!-- Center align the navbar items -->
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add_contributor.php">Add Contributor</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="submit_manuscript.php">Submit Manuscript</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_manuscript.php">View Manuscript</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sales.php">Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="order.php">Order</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
