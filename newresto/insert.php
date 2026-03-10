<?php
require 'config.php';

if (isset($_POST['add'])) {
    $customer_id = null;
    $item_id = null;

    // 1. Handle Customer Logic
    if (!empty($_POST['existing_customer_id'])) {
        $customer_id = $_POST['existing_customer_id'];
    } elseif (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
        $stmt1 = $pdo->prepare("INSERT INTO customers (first_name, last_name, phone_number) VALUES (?, ?, ?)");
        $stmt1->execute([$_POST['first_name'], $_POST['last_name'], $_POST['phone_number']]);
        $customer_id = $pdo->lastInsertId();
    }

    // 2. Handle Item Logic
    if (!empty($_POST['existing_item_id'])) {
        $item_id = $_POST['existing_item_id'];
    } elseif (!empty($_POST['dish_name']) && !empty($_POST['price'])) {
        $stmt2 = $pdo->prepare("INSERT INTO menuitems (dish_name, price, category) VALUES (?, ?, ?)");
        $stmt2->execute([$_POST['dish_name'], $_POST['price'], $_POST['category']]);
        $item_id = $pdo->lastInsertId();
    }

    // 3. Only Create Order if we have both IDs
    if ($customer_id && $item_id) {
        $stmt3 = $pdo->prepare("INSERT INTO orders (customer_id, item_id, order_date, quantity) VALUES (?, ?, NOW(), ?)");
        $stmt3->execute([$customer_id, $item_id, $_POST['quantity']]);
    }

    header("Location: landing.php");
    exit;
}
?>
