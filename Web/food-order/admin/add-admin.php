<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /><br />

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>UserName: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your UserName">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
    //Add Value to Database

    if(isset($_POST['submit']))
    {
        //Button Click
        //echo "Button Clicked";

        //Get Data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']); //Encryption
		$password = mysqli_real_escape_string($conn, $raw_password); 

        //SQL Query
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        //Execute Query and Save to Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //Check
        if($res==TRUE)
        {
            //echo "Data Inserted";
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
            //Redirect Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //echo "Failed";
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //Redirect Page
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>