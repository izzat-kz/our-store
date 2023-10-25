<?php 
include('authentication.php');
include('includes/header.php'); 
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Sales</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Order</li>
        <li class="breadcrumb-item">Sales</li>
    </ol>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Sales Made Today
                    <?php
                    $today = date('Y-m-d');
                    $total_sales_today_query = "SELECT SUM(grand_total) AS total_sales_today
                                                FROM orders
                                                WHERE DATE(created_at) = '$today'";
                    $total_sales_today_query_run = mysqli_query($con, $total_sales_today_query);

                    $total_sales_today = mysqli_fetch_assoc($total_sales_today_query_run)['total_sales_today'];

                    if ($total_sales_today) {
                        echo '<h4 class="mb-0">RM ' . $total_sales_today . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Sales</h4>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Sales Made This Month
                    <?php
                    $current_month = date('Y-m');
                    $total_sales_month_query = "SELECT SUM(grand_total) AS total_sales_month
                                                FROM orders
                                                WHERE DATE_FORMAT(created_at, '%Y-%m') = '$current_month'";
                    $total_sales_month_query_run = mysqli_query($con, $total_sales_month_query);

                    $total_sales_month = mysqli_fetch_assoc($total_sales_month_query_run)['total_sales_month'];

                    if ($total_sales_month) {
                        echo '<h4 class="mb-0">RM ' . $total_sales_month . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Sales</h4>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <?php include('message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <h4>Sales Made Today</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Total Price</th>                             
                                <th>Bought Products</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $today = date('Y-m-d');
                            $query = "SELECT o.order_id, o.cust_id, c.fullname, o.grand_total, p.price, 
                                      ROUND(o.grand_total / p.price) AS quantity,
                                      GROUP_CONCAT(p.name SEPARATOR ', ') AS bought_products
                                      FROM orders o
                                      INNER JOIN customers c ON c.cust_id = o.cust_id
                                      INNER JOIN products p ON p.product_id = o.product_id
                                      WHERE DATE(o.created_at) = '$today'
                                      GROUP BY o.order_id, o.cust_id";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $row['order_id'] ?></td>
                                        <td><?= $row['fullname'] ?></td>
                                        <td><?= $row['grand_total'] ?></td>                                        
                                        <td><?= $row['bought_products'] ?></td>
                                        <td><?= $row['quantity'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="6">No Sales Today</td>
                                </tr>
                                <?php   
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Sales This Month</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Total Price</th>                             
                                <th>Bought Products</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $current_month = date('Y-m');
                            $query = "SELECT o.order_id, o.cust_id, c.fullname, o.grand_total, p.price, 
                                      ROUND(o.grand_total / p.price) AS quantity,
                                      GROUP_CONCAT(p.name SEPARATOR ', ') AS bought_products
                                      FROM orders o
                                      INNER JOIN customers c ON c.cust_id = o.cust_id
                                      INNER JOIN products p ON p.product_id = o.product_id
                                      WHERE DATE_FORMAT(o.created_at, '%Y-%m') = '$current_month'
                                      GROUP BY o.order_id, o.cust_id";  
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $row['order_id'] ?></td>
                                        <td><?= $row['fullname'] ?></td>
                                        <td><?= $row['grand_total'] ?></td>                                        
                                        <td><?= $row['bought_products'] ?></td>
                                        <td><?= $row['quantity'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="6">No Sales This Month</td>
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
