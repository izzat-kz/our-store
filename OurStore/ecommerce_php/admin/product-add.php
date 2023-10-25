<?php 
include('authentication.php');
include('includes/header.php'); 
?>

<div class="container-fluid px-4">

    <div class="row mt-4">
        <div class="col-md-12">

        <?php include('message.php'); ?>
            <div class="card">
                <div class="card-header">
                    <h4>Add Product
                        <a href="product-view.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                <form action="crud.php" method="post" autocomplete="off" enctype="multipart/form-data">

                    <div class="row">  
                        <div class="col-md-6 mb-3">
                            <label for="">Category</label>
                            <?php
                            $category = "SELECT * FROM categories";
                            $category_run = mysqli_query($con, $category);

                            if(mysqli_num_rows($category_run) > 0)
                            {
                                ?>
                                <select name="category_id" class="form-control" required>
                                    <option value="">--Select Category--</option>
                                    
                                    <?php
                                        foreach($category_run as $category_item){
                                        ?>
                                        <option value="<?=$category_item['category_id']?>"><?=$category_item['name'] ?></option>
                                        <?php
                                        }
                                    ?>
                                </select>
                                <?php
                            }
                            else
                            {                               
                                echo "<h5>No Category Available</h5>";                               
                            }
                            ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Product Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>  
                        <div class="col-md-6 mb-3">
                            <label for="">Price</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" name="add_pro" class="btn btn-primary">Save Product</button>
                        </div>      
                    </div>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>    
                                
<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>