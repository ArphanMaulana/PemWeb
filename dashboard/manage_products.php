<?php
require_once "../database.php";

// Fetch products from the database
$result = mysqli_query($conn, "SELECT * FROM 2230511140_restorasi");

$products = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
} else {
    echo "Error fetching products: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="../assets/css/style2.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Manage Products</h1>
            <button onclick="window.location.href='index.php'">Back to Dashboard</button>
        </header>
        <main>
            <div id="productList">
                <?php if (count($products) > 0): ?>
                    <ul>
                        <?php foreach ($products as $product): ?>
                            <li>
                                <?php if ($product['photo']): ?>
                                    <img src="./uploads/<?= $product['photo']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                                <h3><?= $product['name']; ?></h3>
                                <p>Price: $<?= $product['price']; ?></p>
                                <div class="actions">
                                    <form method="get" action="edit_product.php">
                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                        <button type="submit">Edit</button>
                                    </form>

                                    <form method="POST" action="delete_products.php">
                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                        <button type="submit">Delete</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
