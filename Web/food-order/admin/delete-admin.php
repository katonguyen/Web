<?php
    include('config/constants.php');

    // get Id of deleted Admin
    $id = $_GET['id'];

    // Create SQL Query
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute
    $res = mysqli_query($conn, $sql);

    // Check
    if ($res==TRUE)
    {
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');            
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    
?>