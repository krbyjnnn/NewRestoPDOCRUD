<?php
require 'config.php';
require 'insert.php';
require 'update.php';
require 'delete.php';
require 'select.php';

$editOrder = null;
if (isset($_GET['edit'])) {
    $order_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT orders.*, customers.*, menuitems.* FROM orders 
                           JOIN customers ON orders.customer_id = customers.customer_id 
                           JOIN menuitems ON orders.item_id = menuitems.item_id 
                           WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $editOrder = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>JollicDO</title>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2><?= $editOrder ? 'Update Order' : 'Add New Order' ?></h2>
        <form method="POST">
            <?php if (!empty($editOrder)): ?>
                <input type="hidden" name="order_id" value="<?= $editOrder['order_id'] ?>">
                <input type="hidden" name="customer_id" value="<?= $editOrder['customer_id'] ?>">
                <input type="hidden" name="item_id" value="<?= $editOrder['item_id'] ?>">
            <?php endif; ?>

            <div class="input-group">
                <label>Existing Customer</label>
                <select name="existing_customer_id">
                    <option value="">-- New Customer --</option>
                    <?php foreach ($customer_options as $c): ?>
                        <option value="<?= $c['customer_id'] ?>" <?= ($editOrder && $editOrder['customer_id'] == $c['customer_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>First Name</label>
                <input type="text" name="first_name" value="<?= $editOrder ? $editOrder['first_name'] : '' ?>">

                <label>Last Name</label>
                <input type="text" name="last_name" value="<?= $editOrder ? $editOrder['last_name'] : '' ?>">

                <label>Phone Number</label>
                <input type="text" name="phone_number" value="<?= $editOrder ? $editOrder['phone_number'] : '' ?>">
            </div>

            <div class="input-group dish">
                <label>Existing Dish</label>
                <select name="existing_item_id">
                    <option value="">-- New Dish --</option>
                    <?php foreach ($menu_options as $opt): ?>
                        <option value="<?= $opt['item_id'] ?>" <?= ($editOrder && $editOrder['item_id'] == $opt['item_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($opt['dish_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Dish Name</label>
                <input type="text" name="dish_name" value="<?= $editOrder ? $editOrder['dish_name'] : '' ?>">

                <label>Category</label>
                <input type="text" name="category" value="<?= $editOrder ? $editOrder['category'] : '' ?>">

                <label>Price</label>
                <input type="number" step="0.01" name="price" value="<?= $editOrder ? $editOrder['price'] : '' ?>">
            </div>

            <div class="input-group">
                <label>Quantity</label>
                <input type="number" name="quantity" value="<?= $editOrder ? $editOrder['quantity'] : '1' ?>">
            </div>

            <button type="submit" name="<?= $editOrder ? 'update' : 'add' ?>">
                <?= $editOrder ? 'UPDATE ORDER' : 'PLACE ORDER' ?>
            </button>
            
            <?php if ($editOrder): ?>
                <a href="landing.php" class="cancel-link">Cancel Edit</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <h2>Order History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Order Details</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td style="font-size: 11px; color: #95a5a6;">
                        <?= date("M d, Y", strtotime($user['order_date'])) ?><br>
                        <?= date("h:i A", strtotime($user['order_date'])) ?>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong>
                        </td>
                    <td>
                        <span class="badge"><?= htmlspecialchars($user['category']) ?></span><br>
                        <?= htmlspecialchars($user['dish_name']) ?>
                    </td>
                    <td>x<?= $user['quantity'] ?></td>
                    <td>$<?= number_format($user['price'] * $user['quantity'], 2) ?></td>
                    <td>
                        <a href="?edit=<?= $user['order_id'] ?>">Edit</a> | 
                        <a href="?delete=<?= $user['order_id'] ?>" style="color: #e74c3c;" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
