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
                    <h4>Category
                        <a href="category-add.php" class="btn btn-primary float-end">Add Category</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created at</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM categories";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    ?>
                                        <tr>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['description'] ?></td>
                                            <td><?= $row['created_at'] ?></td>
                                            <td><a href="category-edit.php?category_id=<?=$row['category_id']?>" class="btn btn-success">Edit</a></td>
                                            <td>
                                                <form action="crud.php" method="post">   
                                            <button type="submit" name="delete_cat" value="<?=$row['category_id']?>" class="btn btn-danger">Delete</button></td>
                                                </form> 
                                        </tr>
                                    <?php

                                }
                            }
                            else
                            {
                             ?>
                                    <tr>
                                        <td coldspan="4">No Record Found</td>
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