<?php
include('authentication.php');



// ADD PRODUCT
if(isset($_POST['add_pro']))
{
    $category_id = $_POST['category_id'];

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    // Rename image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;


    $query = "INSERT INTO products(category_id, name, description, price, image) VALUES ('$category_id', '$name', '$description', '$price', '$filename')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$filename);
        $_SESSION['message'] = "Product Added Successfully";
        header("Location: product-add.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: product-add.php");
        exit(0);
    
    }
}



// UDPATE PRODUCT
if(isset($_POST['update_pro']))
{
    $product_id = $_POST['product_id'];
    
    $category_id = $_POST['category_id'];

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $old_filename = $_POST['old_image'];
    $image = $_FILES['image']['name'];

    $update_filename = "";
    if($image != NULL)
    {
        // Rename image
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $filename = time().'.'.$image_extension;

        $update_filename = $filename;
    }
    else
    {
        $update_filename = $old_filename;
    }
    
    $query = "UPDATE products SET category_id='$category_id', name='$name', description='$description', price='$price', image='$update_filename' WHERE product_id='$product_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        if($image != NULL){
            if(file_exists('../uploads/'.$old_filename)){
                unlink("../uploads/".$old_filename);
            }
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$filename);
    }
        
        $_SESSION['message'] = "Updated Successfully";
        header("Location: product-edit.php?product_id=".$_POST['product_id']);
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: product-edit.php?product_id=".$_POST['product_id']);
        exit(0);
    
    }

}


// DELETE PRODUCT
if(isset($_POST['delete_pro']))
{
    $product_id = $_POST['delete_pro'];

    $delete_cart_items_query = "DELETE FROM cart_items WHERE product_id='$product_id'";
    $delete_cart_items_result = mysqli_query($con, $delete_cart_items_query);

    $delete_orders_query = "DELETE FROM orders WHERE product_id='$product_id'";
    $delete_orders_result = mysqli_query($con, $delete_orders_query);

    $delete_ratings_query = "DELETE FROM ratings WHERE product_id='$product_id'";
    $delete_ratings_result = mysqli_query($con, $delete_ratings_query);

    $delete_product_query = "DELETE FROM products WHERE product_id='$product_id'";
    $delete_product_result = mysqli_query($con, $delete_product_query);

    if($delete_product_result)
    {
        // Delete the image file
        $check_img_query = "SELECT * FROM products WHERE product_id='$product_id'";
        $img_res = mysqli_query($con, $check_img_query);
        $res_data = mysqli_fetch_array($img_res);
        $image = $res_data['image'];

        if(file_exists('../uploads/'.$image)){
            unlink("../uploads/".$image);
        }

        $_SESSION['message'] = "Product Deleted Successfully";
        header("Location: product-view.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: product-view.php");
        exit(0);
    }
}






// ADD CATEGORY
if(isset($_POST['add_cat']))
{
    $name = $_POST['name'];
    $description = $_POST['description'];

    $query = "INSERT INTO categories(name, description) VALUES ('$name', '$description')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Category Saved Successfully";
        header("Location: category-add.php?id=".$category_id);
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: category-add.php?id=".$category_id);
        exit(0);
    
    }
}

// UDPATE CATEGORY
if(isset($_POST['update_cat']))
{
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $query = "UPDATE categories SET name='$name', description='$description' WHERE category_id='$category_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Updated Successfully";
        header("Location: category-edit.php?category_id=".$category_id);
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: category-edit.php?category_id=".$category_id);
        exit(0);
    
    }


}


// DELETE CATEGORY
if(isset($_POST['delete_cat']))
{
    $category_id = $_POST['delete_cat'];

    $query = "DELETE FROM categories WHERE category_id='$category_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Deleted Successfully";
        header("Location: category-view.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: category-view.php");
        exit(0);
    
    }
}








// UPDATE ADMIN
if(isset($_POST['update_admin']))
{
    $user_id = $_POST['admin_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "UPDATE admins SET fullname='$fullname', email='$email', password='$password'
                WHERE admin_id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Updated Successfully";
        header("Location: user-view.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: user-view.php");
        exit(0);
    
    }

}

// ADD ADMIN
if(isset($_POST['add_admin']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO admins(fullname, email, password) VALUES ('$fullname', '$email', '$password')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Admin Added Successfully";
        header("Location: user-view.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: user-view.php");
        exit(0);
    
    }
}

// DELETE ADMIN
if(isset($_POST['delete_admin']))
{
    $user_id = $_POST['delete_admin'];

    $query = "DELETE FROM admins WHERE admin_id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Admin Deleted Successfully";
        header("Location: user-view.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: user-view.php");
        exit(0);
    
    }
}

// DELETE USER
if (isset($_POST['delete_cust'])) {
    $user_id = $_POST['delete_cust'];

    $delete_orders_query = "DELETE FROM orders WHERE cust_id='$user_id'";
    $delete_orders_result = mysqli_query($con, $delete_orders_query);

    $delete_destination_query = "DELETE FROM destination WHERE cust_id='$user_id'";
    $delete_destination_result = mysqli_query($con, $delete_destination_query);

    $delete_ratings_query = "DELETE FROM ratings WHERE cust_id='$user_id'";
    $delete_ratings_result = mysqli_query($con, $delete_ratings_query);

    $delete_customer_query = "DELETE FROM customers WHERE cust_id='$user_id'";
    $delete_customer_result = mysqli_query($con, $delete_customer_query);

    if ($delete_customer_result) {
        $_SESSION['message'] = "User Deleted Successfully";
        header("Location: user-view.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to delete user";
        header("Location: user-view.php");
        exit(0);
    }
}





// UPDATE USER
if(isset($_POST['update_cust']))
{
    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "UPDATE customers SET fullname='$fullname', email='$email', password='$password'
                WHERE cust_id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Updated Successfully";
        header("Location: user-view.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header("Location: user-view.php");
        exit(0);
    
    }

}

?>