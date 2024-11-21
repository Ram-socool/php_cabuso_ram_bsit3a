<?php
session_start();

$products = [
    1 => ['name' => 'Long Corduroy', 'price' => 1250, 'image' => 'Long_Corduroy.png', 'description' => 'Long corduroy sleeves for a stylish and comfortable look.'],
    2 => ['name' => 'Long Sleeve Black', 'price' => 1250, 'image' => 'Long_Sleeve_Black.png', 'description' => 'Classic long black sleeves for a versatile and casual style.'],
    3 => ['name' => 'Short Sleeve Black', 'price' => 1250, 'image' => 'Short_Sleeve_Black.png', 'description' => 'Short black sleeves that add a trendy and modern vibe to your outfit.'],
    4 => ['name' => 'Short Sleeve Blue', 'price' => 1250, 'image' => 'Short_Sleeve_Blue.png', 'description' => 'Short blue sleeves for a relaxed and fresh appearance.'],
    5 => ['name' => 'Short Sleeve Brown', 'price' => 1250, 'image' => 'Short_Sleeve_Brown.png', 'description' => 'Stylish short brown sleeves that give off a warm and cozy feel.'],
    6 => ['name' => 'Short Sleeve Maroon', 'price' => 1250, 'image' => 'Short_Sleeve_Maroon.png', 'description' => 'Trendy short maroon sleeves for a bold, yet comfortable look.'],
    7 => ['name' => 'Short Sleeve Mint', 'price' => 1250, 'image' => 'Short_Sleeve_Mint.png', 'description' => 'Cool and refreshing short mint sleeves for a unique and chic style.'],
    8 => ['name' => 'Short Sleeve Stripe', 'price' => 5000, 'image' => 'Short_Sleeve_Stripe.png', 'description' => 'Eye-catching short striped sleeves for an athletic and high-performance look.'],
];

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId < 1 || !isset($products[$productId])) {
    header('Location: index.php');
    exit();
}

$product = $products[$productId];

// Handle adding product to the cart
if (isset($_POST['quantity'])) {
    $quantity = intval($_POST['quantity']);
    $size = $_POST['size'];
    if ($quantity > 0 && $quantity <= 100) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId && $item['size'] == $size) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'size' => $size
            ];
        }
        $_SESSION['cart_quantity'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

        header('Location: confirm.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - MALAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background-color: whitesmoke;
        }
        .product-container {
            display: flex;
            max-width: 800px;
            margin: 0 auto;
            align-items: center;
        }
        .product-image {
            width: 300px;
            height: auto;
            object-fit: cover;
            margin-right: 20px;
        }
        .description {
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .btn-confirm, .btn-cancel {
            color: white;
            border: none;
        }
        .btn-confirm {
            background-color: black;
        }
        .btn-confirm:hover {
            background-color: darkgray;
        }
        .btn-cancel {
            background-color: red;
        }
        .btn-cancel:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-cart-fill"></i> MALAN</h2>
            <a href="cart.php" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Cart <span class="badge bg-light text-dark"><?php echo array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); ?></span>
            </a>
        </div>

        <div class="card">
            <div class="product-container">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" class="product-image" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?> - ₱ <?php echo number_format($product['price'], 2); ?></h5>
                    <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                    <form method="post" onsubmit="return confirmPurchase(event);">
                        <label for="size">Select Size:</label><br>
                        <?php foreach (['S', 'M', 'L', 'XL'] as $sizeOption): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="size" value="<?php echo $sizeOption; ?>" id="size<?php echo $sizeOption; ?>" required>
                                <label class="form-check-label" for="size<?php echo $sizeOption; ?>"><?php echo $sizeOption; ?></label>
                            </div>
                        <?php endforeach; ?>
                        <br><label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" class="form-control quantity" min="1" max="100" value="1" required>
                        <button type="submit" class="btn btn-confirm mt-3">Add to Cart</button>
                    </form>
                    <a href="shopping_cart.php" class="btn btn-cancel mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmPurchase(event) {
            event.preventDefault();
            var quantity = document.querySelector('.quantity').value;
            quantity = parseInt(quantity, 10);

            if (quantity < 1 || quantity > 100) {
                alert('Minimum purchase is 1 and maximum is 100');
                return false;
            }

            if (confirm("Are you sure you want to add this item to the cart?")) {
                event.target.submit();
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
