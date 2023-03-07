<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">

        <h1>Add Food</h1>

        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <!-- Form -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="num" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 

                                //Create SQL to get all active Category from Database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //Execute
                                $res = mysqli_query($conn, $sql);

                                //Check 
                                $count = mysqli_num_rows($res);

                                if($count>0)
                                {
                                    $sn = 1;
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>
                                        <option value="<?php echo $sn++;?>"><?php echo $title;?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <option value="0">No Category Found</option>
                                    <?php
                                }
                                //Display

                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                //Get from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //Check Image
                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    //Upload the Image only if image is selected
                    if($image_name != "")
                    {

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
                            header('location:'.SITEURL.'admin/add-food.php');
                            //Stop the Process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name="";
                }

                 //Create SQL Query
                $sql2 = "INSERT INTO tbl_food SET
                    title ='$title',
                    description = '$description',
                    price = $price,
                    image_name='$image_name',
                    category_id = $category,
                    featured ='$featured',
                    active ='$active'
                ";

                //EXecute
                $res2 = mysqli_query($conn,$sql2);

                //Check
                if($res2==TRUE)
                {
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    //Redirect
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    //Redirect
                    header('location:'.SITEURL.'admin/add-food.php');
                }
            }

            
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>