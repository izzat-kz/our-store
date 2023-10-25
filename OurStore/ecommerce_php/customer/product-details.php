<?php
session_start();
include('includes/header.php');
include('../config/dbcon.php');

// Fetch single product details
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
if (!$product_id) {
    $_SESSION['message'] = "Invalid product ID";
    header("Location: products.php");
    exit(0);
}
$product_query = "SELECT p.*, c.name AS category_name FROM products p
                    INNER JOIN categories c ON p.category_id = c.category_id
                    WHERE p.product_id = $product_id";
$product_result = mysqli_query($con, $product_query);
$product_data = mysqli_fetch_assoc($product_result);

// Check if the user is logged in
$user_id = isset($_SESSION['auth_user']['user_id']) ? $_SESSION['auth_user']['user_id'] : null;

// Add rating functionality
if (isset($_POST['submit_rating'])) {
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Insert the rating into the database
    $insert_rating_query = "INSERT INTO ratings (product_id, cust_id, rating, review, created_at) VALUES ($product_id, $user_id, $rating, '$review', NOW())";
    mysqli_query($con, $insert_rating_query);

    // Redirect back to the product details page
    header("Location: product-details.php?product_id=$product_id");
    exit();
}
?>

<!------ single product details ------>
<div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="../uploads/<?php echo $product_data['image']; ?>" width="100%">
        </div>
        <div class="col-2">
            <p>Home / <?php echo $product_data['category_name']; ?></p>
            <h1><?php echo $product_data['name']; ?></h1>
            <h4>RM<?php echo $product_data['price']; ?></h4>
            <form method="POST" action="crud.php">
                <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
                <input type="number" name="quantity" value="1" min="0">
                <button type="submit" name="add_to_cart" class="btn btn-primary">Add To Cart</button>
            </form>
            <br>
            <h3>Product Details <i class="fa fa-indent"></i></h3>
            <br>
            <p><?php echo $product_data['description']; ?></p>
        </div>
    </div>
</div>

<!------ rating card ------>
<div class="small-container">
    <div class="row">
        <div class="col-6 my-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Rate this product</h3>
                    <form method="POST" action="crud.php?product_id=<?php echo $product_id; ?>">
                        <div class="rating">
                            <input type="radio" name="rating" id="rating5" value="5" required>
                            <label for="rating5">5<i class="fa fa-star"></i></label>
                            <input type="radio" name="rating" id="rating4" value="4" required>
                            <label for="rating4">4<i class="fa fa-star"></i></label>
                            <input type="radio" name="rating" id="rating3" value="3" required>
                            <label for="rating3">3<i class="fa fa-star"></i></label>
                            <input type="radio" name="rating" id="rating2" value="2" required>
                            <label for="rating2">2<i class="fa fa-star"></i></label>
                            <input type="radio" name="rating" id="rating1" value="1" required>
                            <label for="rating1">1<i class="fa fa-star"></i></label>
                        </div>
                        <textarea name="review" rows="3" placeholder="Write a review"></textarea><br><br>
                        <button type="submit" name="submit_rating" class="btn btn-warning">Submit Rating</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="card-title">Reviews</h3>
                    <?php
                    $ratings_query = "SELECT r.*, c.fullname FROM ratings r
                                        INNER JOIN customers c ON r.cust_id = c.cust_id
                                        WHERE r.product_id = $product_id";
                    $ratings_result = mysqli_query($con, $ratings_query);
                    if (mysqli_num_rows($ratings_result) == 0) {
                        echo '<p>This product has no ratings.</p>';
                    } else {
                        while ($rating_data = mysqli_fetch_assoc($ratings_result)) :
                    ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $rating_data['fullname']; ?></h5>
                                    <p class="card-text">
                                        <strong>Rating:</strong> <?php echo $rating_data['rating']; ?> <i class="fa fa-star"></i>
                                    </p>
                                    <p class="card-text">
                                        <strong>Review:</strong> <?php echo $rating_data['review']; ?>
                                    </p>
                                    <?php if ($rating_data['cust_id'] === $user_id) : ?>
                                        <form method="POST" action="crud.php?product_id=<?php echo $product_id; ?>">
                                            <input type="hidden" name="remove_rating" value="<?php echo $rating_data['rating_id']; ?>">
                                            <button type="submit" class="btn btn-danger">Remove Rating</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                    <?php endwhile;
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>




<!------ title ------>
<div class="small-container">
    <div class="row row-2">
        <h2>Related Products</h2>
        <p>View More</p>
    </div>
</div>

<!------ related products ------>
<div class="small-container">
    <div class="row">
        <?php
        $related_products_query = "SELECT * FROM products WHERE category_id = {$product_data['category_id']} AND product_id != $product_id LIMIT 4";
        $related_products_result = mysqli_query($con, $related_products_query);
        while ($row = mysqli_fetch_assoc($related_products_result)) :
        ?>
            <div class="col-4">
                <a href="product-details.php?product_id=<?php echo $row['product_id']; ?>">
                    <img src="../uploads/<?php echo $row['image']; ?>">
                </a>
                <h4><?php echo $row['name']; ?></h4>
                <div class="rating">
                    <?php
                    $related_product_id = $row['product_id'];
                    $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE product_id = $related_product_id";
                    $rating_result = mysqli_query($con, $rating_query);
                    $rating_data = mysqli_fetch_assoc($rating_result);
                    $avg_rating = $rating_data['avg_rating'];
                    $filled_stars = floor($avg_rating);
                    $empty_stars = 5 - $filled_stars;

                    for ($i = 0; $i < $filled_stars; $i++) {
                        echo '<i class="fa fa-star"></i>';
                    }

                    for ($i = 0; $i < $empty_stars; $i++) {
                        echo '<i class="fa fa-star-o"></i>';
                    }
                    ?>
                </div>
                <p>RM<?php echo $row['price']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
