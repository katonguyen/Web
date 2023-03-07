<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update food</h1>

        <br><br>

        <?php 

            //Check ID
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                //Create SQL Query
                $sql = "SELECT * FROM tbl_food WHERE id=$id";

                //Execute
                $res = mysqli_query($conn, $sql);
                
                $count = mysqli_num_rows($res);
                //Check
                if($count==1)
                {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $current_image = $row['image_name'];
                    $current_category = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    $_SESSION['no-food-found'] = "<div class='error'>Food Not Found</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
            else
            {
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" ><?php echo $description;?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 

                            if($current_image != "")
                            {
                                //Display Image
                                ?>
                                <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                echo "<div class='error'>Image not Added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php

                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                                
                                $res2 = mysqli_query($conn, $sql2);

                                $count2 = mysqli_num_rows($res2);

                                if($count2>0)
                                {

                                    while($row2=mysqli_fetch_assoc($res2))
                                    {
                                        $category_title = $row2['title'];
                                        $category_id = $row2['id'];
                                        
                                        ?>
                                            <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
                                        <?php

                                    }

                                }
                                else
                                {
                                    echo "<option value='0'>Category Not Available</option>";
                                }

                            ?>
                            
                        </select>
                    </td>
                </tr>            

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "Checked";}?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "Checked";}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "Checked";}?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "Checked";}?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>   
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">       
                        <input type="hidden" name="id" value="<?php echo $id;?>"> 
                        <input type="submit" name="submit" value="Update food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //Get from Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //Update New Image if selected
                //Check if Image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get Image Details
                    $image_name = $_FILES['image']['name'];

                    //Check if Available
                    if($image_name != "")
                    {
                        //Upload New Image

                        //Auto Rename Image
                        //Get Extension
                        $ext = end(explode('.',$image_name));
                        
                        //Rename Image
                        $image_name = "Food_Name_".rand(0000,9999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/food/".$image_name;

                        //Upload Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check Upload
                        if($upload==FALSE)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            //Redirect
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the Process
                            die();
                        }

                        //Remove Current Image
                        if($current_image != "")
                        {
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            //Check
                            if($remove==FALSE)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php'); 
                                die(); //Stop Process 
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //Update Database
                $sql3 = "UPDATE tbl_food SET
                    title='$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";

                //Execute
                $res3 = mysqli_query($conn, $sql3);

                //Check
                if($res3==TRUE)
                {
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>