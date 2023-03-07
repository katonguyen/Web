<?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Food</h1>

            <br /><br />

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize'];
                    unset($_SESSION['unauthorize']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['remove']))
                {
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['failed-remove']))
                {
                    echo $_SESSION['failed-remove'];
                    unset($_SESSION['failed-remove']);
                }

                if(isset($_SESSION['no-food-found']))
                {
                    echo $_SESSION['no-food-found'];
                    unset($_SESSION['no-food-found']);
                }
            
            ?>
            
            <br /><br />
            <!-- Button Add Admin -->
            <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>
            
            <br /><br /><br />

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>

                <?php 
                    
                    //Query to Get all Category
                    $sql = "SELECT * FROM tbl_food";

                    //Execute
                    $res = mysqli_query($conn, $sql);

                    //Check 
                    if($res==TRUE)
                    {
                        $count = mysqli_num_rows($res);
                        $sn = 1;

                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $title =$row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++ ?></td>
                                        <td><?php echo $title ?></td>
                                        <td><?php echo $price ?></td>
                                        <td>

                                            <?php 
                                            
                                                //Check Image
                                                if($image_name!="")
                                                {

                                                    //Display Image
                                                    ?>
                                                    <img src="<?php echo SITEURL;  ?>images/food/<?php echo $image_name;?>" width="100px">
                                                    <?php

                                                }
                                                else
                                                {
                                                    echo "<div class='error'>Image not Added</div>";
                                                }

                                            ?>

                                        </td>
                                        <td><?php echo $featured ?></td>
                                        <td><?php echo $active ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update food</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name ?>"class="btn-danger">Delete food</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {
                            ?>

                                <tr>
                                    <td colspan="7"><div class="error">No Food Added</div></td>
                                </tr>

                            <?php
                        }
                    }
                ?>

            </table>
        </div>
    </div>
<?php include('partials/footer.php'); ?>