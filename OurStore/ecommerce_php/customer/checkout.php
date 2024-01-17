<?php
session_start();
include('includes/header.php');
include('../config/dbcon.php');

$cust_id = $_SESSION['auth_user']['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkout'])) {
        $grand_total = $_POST['grand_total'];

        $check_customer_query = "SELECT * FROM customers WHERE cust_id = '$cust_id'";
        $check_customer_result = mysqli_query($con, $check_customer_query);
        $customer = mysqli_fetch_assoc($check_customer_result);

        if (!$customer) {
            $_SESSION['message'] = "Invalid customer";
            header("Location: checkout.php");
            exit(0);
        }

        $result = mysqli_query($con, $insert_order_query);

        if ($result) {
            $_SESSION['cart'] = array();
            header("Location: placed_order.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Something Went Wrong";
            header("Location: checkout.php");
            exit(0);
        }
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Checkout</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Cart</li>
        <li class="breadcrumb-item active">Order</li>
        <li class="breadcrumb-item">Checkout</li>
    </ol>
    <div class="row">
        <div class="col-md-8 m-5">
    <?php include('message.php'); ?>
    <div class="card">
        <div class="card-header">
            <h4>Destinations</h4>
        </div>
        <div class="card-body">
            <?php
            $query = "SELECT * FROM destination where cust_id = $cust_id";
            $result = mysqli_query($con, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $location = $row['location'];
                $address = $row['address'];

                echo '<div class="form-check">';
                echo "<input class='form-check-input' type='radio' name='destination' id='$location' value='$address' required>";
                echo "<label class='form-check-label' for='$location'><h4>$location</h4></label>";
                echo '</div>';
                echo "<p class='small'>$address</p>";
            }
            ?>
            <form action="destination-add-2.php" method="post">
                <button name="add_destination2" class="btn btn-secondary">+ Add Destination</button>
            </form>
        </div>
    </div>
</div>


        <div class="col-md-8 m-5">
            <div class="card">
                <div class="card-header">
                    <h4>Payment Options</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="radio" class='form-check-input' name="payment_option" value="cash_on_delivery" id="cash_on_delivery" required>
                        <label for="cash_on_delivery"><h4>CASH ON DELIVERY</h4></label>
                    </div>
                    <div class="form-group">
                        <br><input type="radio" class='form-check-input' name="payment_option" value="online_banking" id="online_banking" required>
                        <label for="online_banking"><h4>ONLINE BANKING</h4></label>
                    </div>
                    <div class="form-group">
                        <br><input type="radio" class='form-check-input' name="payment_option" value="debit_credit_card" id="debit_credit_card" required>
                        <label for="debit_credit_card"><h4>DEBIT/CREDIT CARD</h4></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="row justify-content-left">
        <div class="col-md-8 mb-5">
        <form action="placed-order.php" method="post">
            <button type="submit" name="place_order" class="btn btn-success">Place Order</button>
        </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>