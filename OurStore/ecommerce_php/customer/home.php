<?php
session_start();
include('includes/header.php');
include('../config/dbcon.php');

// Fetch products from the database
$products = mysqli_query($con, "SELECT * FROM products LIMIT 4");

?>

    <div class="container">
        <div class="welcome" Style="padding: 50px; width: 100%; box-sizing: border-box; background: linear-gradient(to top, lightblue, white); border-radius: 25px;">
            <div class="row">
                <div class="col-2">
                    <h1>Give Your Daily Life A New Style</h1>
                    <p>Discover trendy clothes and footwear to redefine<br>
                    your daily look. Elevate your fashion game and embrace a<br>
                    new style today!</p>
                    <br>
                    <br>
                    <a href="products.php" class="btn-explore">Explore Now &#8594;</a>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <br>

<!------ featured products ------>
<div class="small-container">
    <h2 class="title">Featured Products</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($products)) : ?>
            <div class="col-4">
                <a href="product-details.php?product_id=<?php echo $row['product_id']; ?>">
                    <img src="../uploads/<?php echo $row['image']; ?>">
                </a>
                <h4><?php echo $row['name']; ?></h4>
                <div class="rating">
                    <?php
                    $product_id = $row['product_id'];
                    $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE product_id = $product_id";
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

<!------ recently added products ------>
<div class="small-container">
    <h2 class="title">Recently Added</h2>
    <div class="row">
        <?php
        $recently_added = mysqli_query($con, "SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
        while ($row = mysqli_fetch_assoc($recently_added)) :
        ?>
            <div class="col-4">
                <a href="product-details.php?product_id=<?php echo $row['product_id']; ?>">
                    <img src="../uploads/<?php echo $row['image']; ?>">
                </a>
                <h4><?php echo $row['name']; ?></h4>
                <div class="rating">
                    <?php
                    $product_id = $row['product_id'];
                    $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE product_id = $product_id";
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
