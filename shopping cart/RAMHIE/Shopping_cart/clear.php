<?php
// Start the session
session_start();

// Display confirmation message and clear the cart
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']); // Clear the cart after checkout
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Successful - MALAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .confirmation-container {
            text-align: center;
            margin-top: 100px;
        }
        .confirmation-icon {
            font-size: 50px;
            color: green;
        }
        .btn-container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container confirmation-container">
        <h2>Online Shopping Successful!</h2>
        <div class="confirmation-icon">
            <span class="bi bi-check-circle"></span>
        </div>
        <div class="btn-container">
            <a href="shopping_cart.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
