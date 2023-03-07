<?php include('partials-front/menu.php'); ?>

<?php 

	if(isset($_GET['category_id']))
	{
		$category_id = $_GET['category_id'];

		$sql = "SELECT title FROM tbl_category WHERE id=$category_id";

		$res = mysqli_query($conn, $sql);

		//Get value from Database
		$row = mysqli_fetch_assoc($res);
		//Get Title
		$category_title = $row['title'];
	}
	else
	{
		//Redirect
		header('location:'.SITEURL);
	}
?>

		<!-- Food Search -->
		<section class="food-search text-center">
			<div class="container">
				<h2>Foods on <a href="#" class="text-white">"<?php echo $category_title?>"</a></h2>
			</div>
		</section>
		<!-- Food Search -->

		<!-- Food MEnu -->
		<section class="food-menu">
			<div class="container">
				<h2 class="text-center">Food Menu</h2>

				<?php 

					//SQL Query based on Selected Category
					$sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

					$res2 = mysqli_query($conn, $sql2);

					$count2 = mysqli_num_rows($res2);

					//Check 
					if($count2>0)
					{
						while($row2=mysqli_fetch_assoc($res2))
						{
							$id = $row2['id'];
							$title = $row2['title'];
							$price = $row2['price'];
							$description = $row2['description'];
							$image_name = $row2['image_name'];
							?>
							<div class="food-menu-box">
								<div class="food-menu-img">
									<?php 
										if($image_name=="")
										{
											echo "<div class='error'>Image not Available</div>";
										}
										else
										{
											?>
												<img
												src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>"
												alt=""
												class="img-responsive img-curve"
												/>
											<?php
										}

									?>
								</div>

								<div class="food-menu-desc">
									<h4><?php echo $title;?></h4>
									<p class="food-price">$<?php echo $price;?></p>
									<p class="food-detail">
										<?php echo $description;?>
									</p>
									<br />

									<a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
								</div>
							</div>
							<?php
						}
					}
					else
					{
						echo "<div class='error'>Food not Available.</div>";
					}

				?>

				<div class="clearfix"></div>
			</div>
		</section>
		<!-- Food Menu -->

<?php include('partials-front/footer.php'); ?>