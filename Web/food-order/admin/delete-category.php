<?php
    include('config/constants.php');

    //Check ID and Image_name
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove Physical Image File
        if($image_name != "")
        {
            $path = "../images/category/".$image_name;
            //Remove Image
            $remove = unlink($path);
            
            //Check
            if($remove==FALSE)
            {
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                //Redirect
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop Process
                die();
            }
        }

        //Delete from Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute
        $res = mysqli_query($conn, $sql);

        //Check 
        if($res==TRUE)
        {
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            //Redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
            //Redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>
