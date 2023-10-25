<?php
include('authentication.php');
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        // Update the order status in the database
        $query = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['success'] = "Order status updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
    } else {
        $_SESSION['error'] = "Invalid request parameters.";
    }

    
    header("Location: order-state.php");
    exit(0);
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: order-state.php");
    exit(0);
}
?>
