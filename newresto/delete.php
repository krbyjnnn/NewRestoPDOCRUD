<?php
require 'config.php';

if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->execute([$order_id]);

    header("Location: landing.php");
    exit();
}
?>
