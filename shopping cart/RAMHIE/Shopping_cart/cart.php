<?php
session_start();

// Initialize the cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to add a product to the cart
function addToCart($productId, $name, $size, $quantity, $price) {
    $found = false;

    // Check if the item already exists in the cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId && $item['size'] == $size) {
            $item['quantity'] += $quantity; // Update quantity
            $found = true;
            break;
        }
    }

    // If the item does not exist, add it to the cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'name' => $name,
            'size' => $size,
            'quantity' => $quantity,
            'price' => $price
        ];
    }
}

// Check if a product is being added to the cart via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $name = $_POST['product_name'];
    $size = $_POST['product_size'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Add the product to the cart
    addToCart($productId, $name, $size, $quantity, $price);
}

// Calculate total quantity and amount
$totalQuantity = 0;
$totalAmount = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalQuantity += $item['quantity'];
    $totalAmount += $item['quantity'] * $item['price'];
}

// Function to handle checkout
if (isset($_POST['checkout'])) {
    unset($_SESSION['cart']); // Clear cart after checkout
    header('Location: clear.php'); // Redirect to confirmation page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALAN - Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-container { max-width: 900px; margin: auto; }
        .cart-header { display: flex; justify-content: space-between; align-items: center; }
        .cart-btn { margin: 20px 10px; }
        .product-image { width: 50px; height: auto; margin-right: 10px; }
        .table td, .table th { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container cart-container mt-5">
        <div class="cart-header">
            <h2>MALAN</h2>
            <button class="btn btn-primary">Cart <span class="badge bg-light text-dark"><?php echo $totalQuantity; ?></span></button>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <tr>
                        <td>
                            <img src="images/<?php echo str_replace(' ', '_', $item['name']); ?>.png" alt="<?php echo htmlspecialchars($item['name']); ?>" class="product-image">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </td>
                        <td><?php echo isset($item['size']) ? htmlspecialchars($item['size']) : 'N/A'; ?></td>
                        <td>
                            <input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="form-control quantity-input" style="width: 70px;"
                                   data-price="<?php echo $item['price']; ?>"
                                   data-index="<?php echo $index; ?>">
                        </td>
                        <td>₱ <?php echo number_format($item['price'], 2); ?></td>
                        <td class="item-total">₱ <?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                        <td>
                            <a href="remove_confirm.php?id=<?php echo urlencode($item['id'] ?? ''); ?>&size=<?php echo urlencode($item['size'] ?? ''); ?>&quantity=<?php echo urlencode($item['quantity'] ?? ''); ?>" class="btn btn-danger">DELETE</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">Total</td>
                    <td colspan="2" id="grand-total">₱ <?php echo number_format($totalAmount, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-danger cart-btn" onclick="window.location.href='shopping_cart.php'">Continue Shopping</button>
            <button class="btn btn-success cart-btn" onclick="alert('Update functionality coming soon!')">Update Cart</button>
            <form method="post" class="d-inline">
                <button type="submit" name="checkout" class="btn btn-primary cart-btn">Checkout</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function() {
                const price = parseFloat(this.getAttribute('data-price'));
                const quantity = parseInt(this.value);
                const index = this.getAttribute('data-index');

                // Calculate the total for this item
                const itemTotal = price * quantity;
                this.closest('tr').querySelector('.item-total').textContent = '₱ ' + itemTotal.toFixed(2);

                // Update the grand total
                let grandTotal = 0;
                document.querySelectorAll('.item-total').forEach(total => {
                    grandTotal += parseFloat(total.textContent.replace('₱ ', '').replace(',', ''));
                });
                document.getElementById('grand-total').textContent = '₱ ' + grandTotal.toFixed(2);
            });
        });
    </script>
</body>
</html>
