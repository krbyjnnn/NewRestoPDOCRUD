<?php
require 'config.php';

if (isset($_POST['add'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $pnumber = $_POST['phone_number'];
    $dishname = $_POST['dish_name'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $qty = $_POST['quantity'];

    $stmt1 = $pdo->prepare("INSERT INTO customers (first_name, last_name, phone_number) VALUES (?, ?, ?)");
    $stmt1->execute([$fname, $lname, $pnumber]);
    $customer_id = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare("INSERT INTO menuitems (dish_name, price, category) VALUES (?, ?, ?)");
    $stmt2->execute([$dishname, $price, $cat]);
    $item_id = $pdo->lastInsertId();

    $stmt3 = $pdo->prepare("INSERT INTO orders (customer_id, item_id, order_date, quantity) VALUES (?, ?, ?)");
    $stmt3->execute([$customer_id, $item_id, $qty]);

    echo "Order request succesfully!";
}
?>