<?php 
include('authentication.php');
include('includes/header.php'); 
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Category</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Category</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
        <?php include('message.php'); ?>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Category
                    <a href="category-view.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?php
                    if(isset($_GET['category_id']))
                    {
                        $category_id = $_GET['category_id'];
                        $cat = "SELECT * FROM categories WHERE category_id='$category_id' ";
                        $cat_run = mysqli_query($con, $cat);

                        if(mysqli_num_rows($cat_run) > 0)
                        {
                            foreach($cat_run as $category)
                            {
                            ?>

                <form action="crud.php" method="post" autocomplete="off">
                    <input type="hidden" name="category_id" value="<?=$category['category_id'];?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Category Name</label>
                            <input type="text" name="name" value="<?=$category['name'];?>" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?=$category['description'];?></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" name="update_cat" class="btn btn-primary">Update Category</button>
                        </div>      
                    </div>
                </form>

                        <?php
                                }
                            }
                        else
                        {
                            echo "<h4>No Record Found</h4>";
                        }
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