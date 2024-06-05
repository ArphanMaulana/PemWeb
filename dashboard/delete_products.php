<?php
require_once "../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    $stmt = mysqli_prepare($conn, "DELETE FROM 2230511140_restorasi WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: manage_products.php');
        exit();
    } else {
        echo "Failed to delete product: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>