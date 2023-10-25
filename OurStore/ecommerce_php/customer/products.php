<?php
session_start();
include('includes/header.php');
include('../config/dbcon.php');

// Fetch products
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$sort_query = '';

if ($sort === 'price_asc') {
    $sort_query = 'ORDER BY price ASC';
} elseif ($sort === 'price_desc') {
    $sort_query = 'ORDER BY price DESC';
} elseif ($sort === 'name_asc') {
    $sort_query = 'ORDER BY name ASC';
} elseif ($sort === 'name_desc') {
    $sort_query = 'ORDER BY name DESC';
}

$product_query = "SELECT * FROM products $sort_query";

// Check if a search query is provided
$query = isset($_GET['query']) ? $_GET['query'] : '';
if (!empty($query)) {
    // Add the search condition to the query
    $product_query .= " WHERE name LIKE '%$query%'";
}

$product_result = mysqli_query($con, $product_query);
$product_count = mysqli_num_rows($product_result);
?>

<!------ product list ------>
<div class="small-container">
    <div class="row row-2">
        <h2>All Products</h2>
        <form action="" method="GET">
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">Default Sorting</option>
                <option value="price_asc" <?php if ($sort === 'price_asc') echo 'selected'; ?>>Sort By Price (Low to High)</option>
                <option value="price_desc" <?php if ($sort === 'price_desc') echo 'selected'; ?>>Sort By Price (High to Low)</option>
                <option value="name_asc" <?php if ($sort === 'name_asc') echo 'selected'; ?>>Sort By Name (A to Z)</option>
                <option value="name_desc" <?php if ($sort === 'name_desc') echo 'selected'; ?>>Sort By Name (Z to A)</option>
            </select>
        </form>
    </div>

    <div class="container">
        <?php if (!empty($query)) : ?>
            <p>Showing search results for: "<?php echo $query; ?>"</p>
        <?php endif; ?>

        <div class="row">
            <?php
            $column_count = 0;
            if ($product_count > 0) :
                while ($product_data = mysqli_fetch_assoc($product_result)) :
                    ?>
                    <div class="col-4">
                        <a href="product-details.php?product_id=<?php echo $product_data['product_id']; ?>">
                            <img src="../uploads/<?php echo $product_data['image']; ?>">
                        </a>
                        <h4><?php echo $product_data['name']; ?></h4>
                        <div class="rating">
                            <?php
                            $product_id = $product_data['product_id'];
                            $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE product_id = $product_id";
                            $rating_result = mysqli_query($con, $rating_query);
                            $rating_data = mysqli_fetch_assoc($rating_result);
                            $avg_rating = $rating_data['avg_rating'];
                            $filled_stars = ($avg_rating) ? floor($avg_rating) : 0;
                            $empty_stars = 5 - $filled_stars;

                            for ($i = 0; $i < $filled_stars; $i++) {
                                echo '<i class="fa fa-star"></i>';
                            }

                            for ($i = 0; $i < $empty_stars; $i++) {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                            ?>
                        </div>
                        <p>RM<?php echo $product_data['price']; ?></p>
                    </div>
                    <?php
                    $column_count++;
                    if ($column_count % 4 == 0) {
                        echo '</div><div class="row">'; // Start a new row after every 5 columns
                    }
                    ?>
            <?php endwhile; ?>
            <?php else : ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <br>
</div>

<?php include('includes/footer.php'); ?>
