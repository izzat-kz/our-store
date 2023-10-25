<?php
session_start();
include('../config/dbcon.php');

$cust_id = $_SESSION['auth_user']['user_id'];

// Fetch customer profile details
$query = "SELECT * FROM customers WHERE cust_id = '$cust_id'";
$result = mysqli_query($con, $query);
$customer = mysqli_fetch_assoc($result);

// Fetch past orders
$order_query = "SELECT o.order_id, p.name AS product_name, o.grand_total, o.created_at, o.status, p.price
                FROM orders o 
                INNER JOIN products p ON o.product_id = p.product_id
                WHERE o.cust_id = '$cust_id' 
                ORDER BY o.created_at DESC";
$order_result = mysqli_query($con, $order_query);

// Fetch customer's destinations
$destination_query = "SELECT * FROM destination WHERE cust_id = '$cust_id'";
$destination_result = mysqli_query($con, $destination_query);

// Fetch ratings and reviews
$ratings_query = "SELECT r.*, p.name FROM ratings r
                    INNER JOIN products p ON r.product_id = p.product_id
                    WHERE r.cust_id = '$cust_id'";
$ratings_result = mysqli_query($con, $ratings_query);

include('includes/header.php');
?>

<div class="row">
    <div class="col-md-9 mx-auto my-5">
    <?php include('message.php'); ?>
        <div class="card">
            <div class="card-header">
                <h4>Profile</h4>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <?php echo $customer['email']; ?></p>
                <p><strong>Full Name:</strong> <?php echo $customer['fullname']; ?></p>
                <p><strong>Created At:</strong> <?php echo $customer['created_at']; ?></p>
                <a href="profile-edit.php?id=<?php echo $_SESSION['auth_user']['user_id']; ?>" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="col-md-9 mx-auto my-5">
        <div class="card">
            <div class="card-header">
                <h4>Past Purchases</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Grand Total</th>
                        <th>Quantity</th>
                        <th>Created At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($order_result)) { ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['grand_total']; ?></td>
                            <td><?php echo round($row['grand_total'] / $row['price']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-9 mx-auto my-5">
        <div class="card">
            <div class="card-header">
                <h4>Destinations
                    <a href="destinations.php" class="btn btn-primary float-end">View</a>
                </h4>
            </div>
            <div class="card-body">
                <?php while ($destination = mysqli_fetch_assoc($destination_result)) { ?>
                    <p><strong>Address:</strong> <?php echo $destination['address']; ?></p>
                    <a href="destination-edit.php?destination_id=<?php echo $destination['destination_id']; ?>" class="btn btn-warning">&#9998;</a>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-9 mx-auto my-5">
        <div class="card">
            <div class="card-header">
                <h4>Ratings and Reviews</h4>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($ratings_result) > 0) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rating_data = mysqli_fetch_assoc($ratings_result)) { ?>
                                <tr>
                                    <td><?php echo $rating_data['name']; ?></td>
                                    <td>
                                        <?php
                                        $rating = $rating_data['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '&#9733;'; // Filled star
                                            } else {
                                                echo '&#9734;'; // Empty star
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $rating_data['review']; ?></td>
                                    <td><?php echo $rating_data['created_at']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No ratings and reviews made.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
