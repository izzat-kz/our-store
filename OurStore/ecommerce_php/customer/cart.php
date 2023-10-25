<?php
session_start();
include('../config/dbcon.php');
include('includes/header.php');

// Check if the cart session variable exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

$total = 0;
foreach ($cart as $product_id => $product) {
    // Retrieve the product details from the database
    $query = "SELECT price FROM products WHERE product_id = $product_id";
    $query_run = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($query_run);

    // Calculate the subtotal for each product
    $subtotal = $row['price'] * $product['quantity'];
    $total += $subtotal;
    
    // Update the subtotal in the cart session variable
    $cart[$product_id]['subtotal'] = $subtotal;
}

// Update the cart session variable with the updated subtotals
$_SESSION['cart'] = $cart;


?>

<div class="container-fluid px-4">
    <h1 class="mt-4">View Cart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Cart</li>
        <li class="breadcrumb-item">View Cart</li>
    </ol>
    <div class="row">

        <div class="col-md-12 mb-5">

            <?php include('message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <h4>Cart</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($cart)) : ?>
                        <p>Your cart is empty.</p>
                        <a href="products.php" class="btn btn-primary">Back to Shopping</a>
                    <?php else : ?>
                        <form method="POST" action="crud.php">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>SubTotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $product_id => $product) : ?>
                                        <tr>
                                            <td>
                                                <img src="../uploads/<?php echo $product['image']; ?>" alt="Product Image" style="max-width: 80px; max-height: 80px;">
                                                <p><?php echo $product['name']; ?></p>
                                            </td>
                                            <td>
                                                <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
                                                <input type="number" name="quantity[]" value="<?php echo $product['quantity']; ?>" min="0" style="width: 50px; height: 40px; padding-left: 10px; font-size: 20px; margin-right: 10px;">
                                            </td>
                                            <td>RM<?php echo $product['price']; ?></td>
                                            <td>RM<?php echo $product['subtotal']; ?></td>
                                            <td>
                                                <a href="crud.php?remove=true&product_id=<?php echo $product_id; ?>" class="btn btn-sm btn-danger">Remove</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total</strong></td>
                                        <td colspan="2"><strong>RM<?php echo $total; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                            <button type="submit" name="update_cart" class="btn btn-success">Update Cart</button>
                            <a href="checkout.php" class="btn btn-warning">Checkout</a>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
