<?php
require_once "../database.php";

$product = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id']); // Ensure $id is an integer to prevent SQL injection
  $name = $_POST['name'];
  $price = $_POST['price'];
  $image = $_FILES['photo']['name'];

  $target_dir = './uploads/';

  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
  }

  // If an image was uploaded, delete the old image and use the new image.
  if (!empty($image)) {
    $result = mysqli_query($conn, "SELECT * FROM 2230511140_restorasi WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    $oldImage = $product['photo'];

    // Delete the old image file
    if (file_exists($target_dir . $oldImage)) {
      unlink($target_dir . $oldImage);
    }

    // Generate a unique name for the image
    $extension = pathinfo($image, PATHINFO_EXTENSION);
    $newImageName = uniqid() . '.' . $extension;

    $target_file = $target_dir . $newImageName;
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
  } else {
    $result = mysqli_query($conn, "SELECT * FROM 2230511140_restorasi WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    $target_file = $product['photo'];
  }

  // Prepare an SQL statement for execution
  $stmt = mysqli_prepare($conn, "UPDATE 2230511140_restorasi SET name = ?, price = ?, photo = ? WHERE id = ?");

  // Bind variables to a prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "sssi", $name, $price, $newImageName, $id);

  // Execute a prepared Query
  mysqli_stmt_execute($stmt);

  header('Location: manage_products.php');
  exit();
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']); // Ensure $id is an integer to prevent SQL injection
  $result = mysqli_query($conn, "SELECT * FROM 2230511140_restorasi WHERE id = $id");
  $product = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Dashboard Produk</h1>
        <form id="productForm" method="post" enctype="multipart/form-data" action="">
            <input type="hidden" id="productId" name="id" value="<?= $product['id']?>">
            <div>
                <label for="productName">Name:</label>
                <input type="text" id="productName" name="name" required value="<?= $product['name']?>">
            </div>
            <div>
                <label for="productPrice">Price:</label>
                <input type="number" id="productPrice" name="price" required value="<?= $product['price']?>">
            </div>
            <div>
                <label for="productImage">Photo:</label>
                <input type="file" id="productImage" accept="image/*" name="photo" value="<?= $product['photo']?>" required>
            </div>
            <button type="submit" name="submit">Ubah</button>
        </form>
</body>
</html>