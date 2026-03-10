<?php
if (isset($_POST['update'])) {
    require 'config.php';
    
    $o_id = $_POST['order_id'];
    $c_id = $_POST['customer_id'];
    $i_id = $_POST['item_id'];
    
    $final_customer_id = !empty($_POST['existing_customer_id']) ? $_POST['existing_customer_id'] : $c_id;
    $final_item_id = !empty($_POST['existing_item_id']) ? $_POST['existing_item_id'] : $i_id;

    // 1. Update Order link and quantity
    $stmtOrder = $pdo->prepare("UPDATE orders SET customer_id = ?, item_id = ?, quantity = ? WHERE order_id = ?");
    $stmtOrder->execute([$final_customer_id, $final_item_id, $_POST['quantity'], $o_id]);

    // 2. Update Customer info (including phone)
    if ($final_customer_id == $c_id) {
        $stmtCust = $pdo->prepare("UPDATE customers SET first_name = ?, last_name = ?, phone_number = ? WHERE customer_id = ?");
        $stmtCust->execute([$_POST['first_name'], $_POST['last_name'], $_POST['phone_number'], $c_id]);
    }

    // 3. Update Menu Item info
    if ($final_item_id == $i_id) {
        $stmtMenu = $pdo->prepare("UPDATE menuitems SET dish_name = ?, price = ?, category = ? WHERE item_id = ?");
        $stmtMenu->execute([$_POST['dish_name'], $_POST['price'], $_POST['category'], $i_id]);
    }

    header("Location: landing.php");
    exit;
}
?>
