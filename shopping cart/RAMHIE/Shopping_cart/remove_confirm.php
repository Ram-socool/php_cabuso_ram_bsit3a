<?php
session_start();

// Initialize the cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to find a product in the cart by ID
function findProductInCart($productId) {
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $productId) {
            return ['product' => $item, 'index' => $index];
        }
    }
    return null; // Return null if product not found
}

// Check if a product is being removed from the cart via GET request
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Find the product in the cart
    $productData = findProductInCart($productId);

    if ($productData) {
        $product = $productData['product'];
        $productIndex = $productData['index'];

        // Display confirmation page for product removal
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirm Removal - MALAN</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">

        </head>
        <body>
            <div class="container my-5">
                <div class="card shadow">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="images/<?php echo str_replace(' ', '_', htmlspecialchars($product['name'] ?? 'default_image')); ?>.png" alt="<?php echo htmlspecialchars($product['name'] ?? 'Unknown Product'); ?>" class="img-fluid rounded-start">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($product['name'] ?? 'Unknown Product'); ?></h3>
                                <p class="card-text"><strong>Size:</strong> <?php echo isset($product['size']) ? htmlspecialchars($product['size']) : 'Not specified'; ?></p>
                                <p class="card-text"><strong>Quantity:</strong> <?php echo isset($product['quantity']) ? htmlspecialchars($product['quantity']) : 'N/A'; ?></p>
                                <p class="card-text"><strong>Price:</strong> ₱ <?php echo isset($product['price']) ? number_format($product['price'], 2) : '0.00'; ?></p>
                                <p class="card-text"><strong>Total:</strong> ₱ <?php echo isset($product['price'], $product['quantity']) ? number_format($product['price'] * $product['quantity'], 2) : '0.00'; ?></p>
                                <form method="post" action="">
                                    <input type="hidden" name="index" value="<?php echo $productIndex; ?>">
                                    <button type="submit" name="confirm" class="btn btn-danger">Confirm Product Removal</button>
                                    <a href="cart.php" class="btn btn-secondary ms-2">CancelGIT </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Product not found in the cart.";
    }
} else {
    echo "Error: Invalid request. Product ID is missing.";
}

// Handle product removal confirmation when POST is received
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (isset($_POST['index']) && isset($_SESSION['cart'][$_POST['index']])) {
        $index = $_POST['index'];

        // Check if the index exists in the session before proceeding
        if (array_key_exists($index, $_SESSION['cart'])) {
            // Remove the product from the cart
            unset($_SESSION['cart'][$index]);

            // Re-index the array to maintain the integrity of the cart
            $_SESSION['cart'] = array_values($_SESSION['cart']);

            // Redirect back to the cart page
            header('Location: cart.php');
            exit();
        } else {
            echo "Invalid product selection. The item no longer exists in the cart.";
        }
    } else {
        echo "Invalid request. Please try again.";
    }
}
?>
