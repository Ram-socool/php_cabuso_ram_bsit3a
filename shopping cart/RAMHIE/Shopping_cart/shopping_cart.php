<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if an item is added to the cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Sample product data (can be moved to a database or separate file)
    $products = [
        1 => ['name' => 'Long Corduroy', 'price' => 1250],
        2 => ['name' => 'Long Sleeve Black', 'price' => 1250],
        3 => ['name' => 'Short Sleeve Black', 'price' => 1250],
        4 => ['name' => 'Short Sleeve Blue', 'price' => 1250],
        5 => ['name' => 'Short Sleeve Brown', 'price' => 1250],
        6 => ['name' => 'Short Sleeve Maroon', 'price' => 1250],
        7 => ['name' => 'Short Sleeve Mint', 'price' => 1250],
        8 => ['name' => 'Short Sleeve Stripe', 'price' => 4000],
    ];

    if (isset($products[$productID])) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productID) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $productID,
                'name' => $products[$productID]['name'],
                'price' => $products[$productID]['price'],
                'quantity' => 1
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malan Online Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            position: relative;
            border: none;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: opacity 0.3s ease-in-out;
        }
        .product-image-hover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .product-card:hover .product-image-hover {
            opacity: 1;
        }
        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
            height: 50px;
            padding: 5px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .product-card:hover .overlay {
            opacity: 1;
        }
        .add-to-cart-btn,
        .view-details-btn {
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            padding: 8px 12px;
            border: 1px solid #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }
        .add-to-cart-btn:hover,
        .view-details-btn:hover {
            background-color: #fff;
            color: #000;
        }
        .price-badge {
            background-color: #333;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>
                <span class="shop-logo"><i class="fas fa-store"></i></span> MALAN
            </h2>
            <a href="cart.php" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Cart 
                <span class="badge bg-light text-dark">
                    <?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?>
                </span>
            </a>
        </div>

        <div class="row">
            <?php
            $products = [
                ['id' => 1, 'name' => 'Long Corduroy', 'price' => 1250, 'image' => 'Long_Corduroy.png', 'hover_image' => 'Long_Corduroy2.png'],
                ['id' => 2, 'name' => 'Long Sleeve Black', 'price' => 1250, 'image' => 'Long_Sleeve_Black.png', 'hover_image' => 'Long_Sleeve_Black2.png'],
                ['id' => 3, 'name' => 'Short Sleeve Black', 'price' => 1250, 'image' => 'Short_Sleeve_Black.png', 'hover_image' => 'Short_Sleeve_Black2.png'],
                ['id' => 4, 'name' => 'Short Sleeve Blue', 'price' => 1250, 'image' => 'Short_Sleeve_Blue.png', 'hover_image' => 'Short_Sleeve_Blue2.png'],
                ['id' => 5, 'name' => 'Short Sleeve Brown', 'price' => 1250, 'image' => 'Short_Sleeve_Brown.png', 'hover_image' => 'Short_Sleeve_Brown2.png'],
                ['id' => 6, 'name' => 'Short Sleeve Maroon', 'price' => 1250, 'image' => 'Short_Sleeve_Maroon.png', 'hover_image' => 'Short_Sleeve_Maroon2.png'],
                ['id' => 7, 'name' => 'Short Sleeve Mint', 'price' => 1250, 'image' => 'Short_Sleeve_Mint.png', 'hover_image' => 'Short_Sleeve_Mint2.png'],
                ['id' => 8, 'name' => 'Short Sleeve Stripe', 'price' => 4000, 'image' => 'Short_Sleeve_Stripe.png', 'hover_image' => 'Short_Sleeve_Stripe2.png'],
            ];

            foreach ($products as $product) {
                echo '
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <a href="details.php?id=' . $product['id'] . '">
                            <img src="images/' . $product['image'] . '" class="product-image" alt="' . $product['name'] . '">
                        </a>
                        <img src="images/' . $product['hover_image'] . '" class="product-image-hover" alt="' . $product['name'] . '">
                        <div class="overlay">
                            <a href="shopping_cart.php?action=add&id=' . $product['id'] . '" class="add-to-cart-btn">Add to Cart</a>
                            <a href="details.php?id=' . $product['id'] . '" class="view-details-btn">View Details</a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">' . $product['name'] . '</h5>
                            <span class="price-badge">₱ ' . number_format($product['price'], 2) . '</span>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
