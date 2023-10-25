<?php
include('authentication.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">View Order</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Order</li>
        <li class="breadcrumb-item active">View Order</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <?php include('message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <h4>Order Details
                        <a href="order-state.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['order_id'])) {
                        $order_id = $_GET['order_id'];

                        // Fetch the order details from the database based on the order ID
                        $query = "SELECT o.*, p.name, p.price
                                  FROM orders o
                                  INNER JOIN products p ON p.product_id = o.product_id
                                  WHERE o.order_id = $order_id";
                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            $order = mysqli_fetch_assoc($query_run);
                            ?>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Order ID</th>
                                        <td><?= $order['order_id'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Customer ID</th>
                                        <td><?= $order['cust_id'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total</th>
                                        <td><?= $order['grand_total'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Quantity</th>
                                        <td><?= round($order['grand_total'] / $order['price']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Product Name</th>
                                        <td><?= $order['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td><?= $order['created_at'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><?= $order['status'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "Order not found.";
                        }
                    } else {
                        echo "Invalid order ID.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
