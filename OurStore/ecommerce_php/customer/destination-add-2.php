<?php
session_start();
include('includes/header.php'); 
?>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12 mb-5 mt-5">
        <?php include('message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <h4>Add Address
                        <a href="checkout.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="crud.php?cust_id=<?= $_SESSION['auth_user']['user_id']; ?>" method="post" autocomplete="off">
                        <div class="row">
                            <input type="hidden" name="cust_id" value="<?= $_SESSION['auth_user']['user_id']; ?>">
                            <div class="col-md-6 mb-3">
                                <label for="">Location Name</label>
                                <input type="text" name="location" class="form-control">
                            </div>
                            <div class="col-md-10 mb-3">
                                <label for="">Address</label>
                                <textarea name="address" class="form-control" required rows="4"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="add_destination2" class="btn btn-primary">Add Destination</button>
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
?>