<?php 
include('authentication.php');
include('includes/header.php'); 
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">View Orders</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Order</li>
        <li class="breadcrumb-item">View Orders</li>
    </ol>
    <div class="row">

        <div class="col-md-12">

            <?php include('message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <h4>Orders</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer ID</th>
                                <th>Grand Total</th>
                                <th>Quantity</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT o.order_id, o.cust_id, o.grand_total, p.price, 
                                      ROUND(o.grand_total / p.price) AS quantity,
                                      o.created_at, o.status
                                      FROM orders o
                                      INNER JOIN products p ON p.product_id = o.product_id";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    ?>
                                        <tr>
                                            <td><?= $row['order_id'] ?></td>
                                            <td><?= $row['cust_id'] ?></td>
                                            <td><?= $row['grand_total'] ?></td>
                                            <td><?= $row['quantity'] ?></td>
                                            <td><?= $row['created_at'] ?></td>
                                            <td>
                                                <form action="update-status.php" method="post">
                                                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                                    <div class="input-group">
                                                        <select class="form-select" name="status">
                                                            <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                                            <option value="Cancelled" <?= $row['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="order-view.php?order_id=<?= $row['order_id'] ?>" class="btn btn-info">View</a>
                                            </td>
                                        </tr>
                                    <?php

                                }
                            }
                            else
                            {
                             ?>
                                    <tr>
                                        <td colspan="7">No orders found</td>
                                    </tr>
                             <?php   
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>    

<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>
