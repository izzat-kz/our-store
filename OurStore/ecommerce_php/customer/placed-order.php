<?php
session_start();
include('includes/header.php');
include('../config/dbcon.php');

// Check if the cart session variable exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

$cust_id = $_SESSION['auth_user']['user_id'];

// Calculate the grand total
$grand_total = 0;
foreach ($cart as $product_id => $product) {
    $quantity = $product['quantity'];
    $total = $product['price'] * $quantity;
    $grand_total += $total;
}

// Insert the order details into the orders table
$insert_order_query = "INSERT INTO orders (product_id, cust_id, grand_total, created_at, status) VALUES ";
$values = array();
foreach ($cart as $product_id => $product) {
    $total = $product['price'] * $product['quantity'];
    $values[] = "('$product_id', '$cust_id', '$total', NOW(), 'Pending')";
}
$insert_order_query .= implode(", ", $values);


// Perform the database query
$result = mysqli_query($con, $insert_order_query);

if ($result) {
    // Clear the cart
    $_SESSION['cart'] = array();

    // Display the order confirmation message
    echo '<div class="text-center">
              <h2>YOUR ORDER HAS BEEN PLACED, THANK YOU</h2>
          </div>';
} else {
    // Display an error message if the order placement failed
    echo '<div class="text-center">
                <p>Sorry, something went wrong while placing your order. Please try again later.</p>
            </div>';
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>