<?php 
session_start();

if(isset($_SESSION['auth'])){
    $_SESSION['message'] = "You are already logged in";
    header("Location: index.php");
    exit(0);
}

include('includes/header.php'); 
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <?php include('message.php'); ?>

                <div class="card">
                    <div class="card-header">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">

                    <form action="register-check.php" method="post" autocomplete="off">
                        <div class="form-group mb-3">
                            <label for="">Full Name</label>
                            <input required type="text" name="fullname" placeholder="Enter Full Name" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email Id</label>
                            <input required type="email" name="email" placeholder="Enter Email Address" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Password</label>
                            <input required type="password" name="password" placeholder="Enter Password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Confirm Password</label>
                            <input required type="password" name="cPassword" placeholder="Re-enter Password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="register_btn" class="btn btn-primary">Register Now</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>