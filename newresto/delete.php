<?php
require 'config.php';

if (isset($_GET['delete'])) {
    $c_id = $_GET['delete'];

    $stmt1 = $pdo->prepare("DELETE FROM orders WHERE customer_id = ?");
    $stmt1->execute(['c_id']);

    $stmt2 = $pdo->prepare("DELETE FROM customers WHERE customer_id = ?");
    $stmt2->execute(['c_id']);

    header("Location: landing.php");
    exit();
}
?>