<?php
require 'config.php';

$sql = "SELECT orders.order_id, orders.quantity, orders.order_date,
               customers.customer_id, customers.first_name, customers.last_name, customers.phone_number,
               menuitems.item_id, menuitems.dish_name, menuitems.price, menuitems.category
        FROM orders
        INNER JOIN customers ON orders.customer_id = customers.customer_id
        INNER JOIN menuitems ON orders.item_id = menuitems.item_id
        ORDER BY orders.order_id DESC";

$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$customer_options = $pdo->query("SELECT * FROM customers GROUP BY first_name, last_name ORDER BY first_name ASC")->fetchAll(PDO::FETCH_ASSOC);
$menu_options = $pdo->query("SELECT * FROM menuitems GROUP BY dish_name ORDER BY dish_name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
