<?php
require_once "../database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $imageName = $_FILES['photo']['name'];

  $target_dir = './uploads/';

  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
  }

  $extension = pathinfo($imageName, PATHINFO_EXTENSION);
  $newImageName = uniqid() . '.' . $extension;

  $target_file = $target_dir . $newImageName;
  move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

  // Prepare an SQL statement for execution
  $stmt = mysqli_prepare($conn, "INSERT INTO 2230511140_restorasi (name, price, photo) VALUES (?, ?, ?)");

  // Bind variables to a prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "sis", $name, $price, $newImageName);

  // Execute a prepared Query
  mysqli_stmt_execute($stmt);
  header('Location: index.php');
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Add Product</h1>
            <button onclick="window.location.href='index.php'">Back to Dashboard</button>
        </header>
        <main>
            <form id="productForm" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" id="photo" name="photo" required>
                </div>
                <button type="submit">Add Product</button>
            </form>
        </main>
    </div>
</body>
</html>
