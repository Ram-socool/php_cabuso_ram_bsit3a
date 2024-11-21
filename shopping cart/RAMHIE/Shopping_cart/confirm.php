<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart_quantity'])) {
    $_SESSION['cart_quantity'] = 0;
}

// Check if cart items are set and display them
if (isset($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];
} else {
    $cartItems = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - MALAN</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome and Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0e5d6; /* A soft beige color for a stylish look */
        }
        .confirmation-message {
            text-align: center;
            margin-top: 50px;
            font-size: 1.5rem;
            color: #333;
        }
        .btn-view-cart {
            background-color: black;
            color: white;
        }
        .btn-view-cart:hover {
            background-color: darkgray;
            color: white;
        }
        .btn-continue-shopping {
            background-color: red;
            color: white;
        }
        .btn-continue-shopping:hover {
            background-color: darkred;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Main container -->
    <div class="container mt-5">
        <!-- Header with Shop Name and Cart Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <span class="shop-logo"><i class="bi bi-cart-fill"></i></span>
                MALAN
            </h2>
            <a href="cart.php" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Cart <span class="badge bg-light text-dark"><?php echo $_SESSION['cart_quantity']; ?></span>
            </a>
        </div>

        <div class="confirmation-message">
            <p>Product Successfully Added to the Cart!</p>
            
            <!-- Displaying the cart items on the confirmation page -->
            <div class="cart-items">
               
                <ul class="list-group">
                    <?php foreach ($cartItems as $item): ?>
                       
                    <?php endforeach; ?>
                </ul>
            </div>

            <a href="cart.php" class="btn btn-view-cart mt-3">View Cart</a>
            <a href="shopping_cart.php" class="btn btn-continue-shopping ms-2 mt-3">Continue Shopping</a>
        </div>
    </div>

    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
