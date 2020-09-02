<?php

	/*
	 * ==================================================
	 * == Template Page
	 * ==================================================
	*/

	session_start();

	$pageTitle = "" ; 

	if(isset($_SESSION['adminName'])){

		include 'int.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "manage";

		// Start Manage Page
		if ($do == 'manage'){ 


		//Select All Users Except Admin
		$stmt = $conn->prepare("

			SELECT items.* ,categories.Name AS Categoy_Name ,users.Username AS UserName From items
			JOIN categories ON Cat_ID = ID
			JOIN users ON UserID = Member_ID");

		// Execute The Statement
		$stmt -> execute();
		//Assign To Variable
		$items = $stmt->fetchAll();

?>
			
		<h1 class="text-center">Manage Items</h1>

		<?php if(!empty($items)) { ?>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Data</td>
							<td>UserName</td>
							<td>Category</td>
							<td>Control</td>
						</tr>
<?php

				foreach($items as $item){

						echo "<tr>"; 
							echo "<td>".$item['item_ID']."</td>";
							echo "<td>".$item['Name']."</td>";
							echo "<td>".$item['Description']."</td>";
							echo "<td>".$item['Price']."</td>";
							echo "<td>".$item['Add_Date']."</td>";
							echo "<td>".$item['UserName']."</td>";//Name of AS
							echo "<td>".$item['Categoy_Name']."</td>";
						    echo"<td>
							<a href='items.php?do=edit&itemid=".$item['item_ID']."'class='btn btn-success'>
							<i class= 'fa fa-edit'> </i> Edit </a> 
							<a href='items.php?do=delete&itemid=".$item['item_ID']."'class='btn btn-danger confirm'>
							<i class='fa fa-close'> </i> Delete </a>";

					//Appear Activation Button If RegStatus = 0 
					if($item['Approve'] == 0){			    	
					    	echo "<a 
					    	href='items.php?do=approve&itemid=".$item['item_ID']."'
					    	class='btn btn-info activate' >
					    	<i class='fa fa-check'></i>Approve</a>";
					    	 // activite To Edit It in Css

					}
							echo "</td>";
						echo "</tr>"; 
				}
?>
				</table>
			</div>

			<?php }else{

			echo "<div class='container'>";
				echo "<div class='nice-message'>";
					echo 'There\'s No item';
				echo "</div>";
			echo "</div>";
			}?>

			    <!-- Add New Member Button -->
				<div class='container'><a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item </a></div>		
		</div>			
<?php

		}elseif ( $do == 'add') {

	?>
			
		<h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=insert" method="POST">


				<!--Start Name of Categories Field-->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="true" 
								placeholder="Name Of The Item" />
						</div>
					</div>
				<!--End Name Field-->

			    <!--Start Description Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Description</label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="true" 
								placeholder="Description Of The Item" />
						</div>
					</div>
				<!--End Description Field-->

			    <!--Start Price Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Price </label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								required="true" 
								placeholder="Price Of The Item" />
						</div>
					</div>
				<!--End Price Field-->


			    <!--Start Country Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Country </label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								required="true" 
								placeholder="Country Of Made" />
						</div>
					</div>
				<!--End Country Field-->	

				<!--Start Status Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Status </label>	
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="status">
								<option value="0">...</option>		
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>					
							</select>
						</div>
					</div>
				<!--End Status Field-->

				<!--Start Members Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Member </label>
						
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="member">
								<option value="0">...</option>		
								<?php
									
									$stmt = $conn->prepare("SELECT * FROM users");
									$stmt ->execute();
									$users = $stmt->FetchAll();

									foreach ($users as $key => $user) {
										echo "<option value='" .$user['UserID']. "'>" .$user['Username'] ."</option>";
									}
								?>		
							</select>
						</div>
					</div>
				<!--End Members Field-->

				<!--Start Category Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Category </label>
						
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="category">
								<option value="0">...</option>		
								<?php
									$allCats = getAllFrom("*","categories","WHERE parent = 0","","ID");
									foreach ($allCats as $cat) {
										echo "<option value='" .$cat['ID']. "'>" .$cat['Name'] ."</option>";
										$childCats = getAllFrom("*","categories","WHERE parent = {$cat['ID']}","","ID");
										foreach ($childCats as $child) {
											echo "<option value='" .$child['ID']. "'>--- " .$child['Name'] ."</option>";
										}
									}
								?>		
							</select>
						</div>
					</div>
				<!--End Category Field-->			

			    <!--Start Tags Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Tags</label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="Separate Tags With Coma (,)" />
						</div>
					</div>
				<!--End Tags Field-->

				<!--Start Button Save-->
					<div class="form-group"> 
						<div class=" col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-sm"/>
						</div>
					</div>
				<!--End Button Save--> 

				</form>
			</div>

<?php


		}elseif ($do == 'insert') {


		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	    		
	    		echo "<h1 class='text-center'>Insert New Item</h1>";

	    		echo "<div class='container'>";

	    		// Get Variables From The Form

	    		$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat     	= $_POST['category'];
				$tags     	= $_POST['tags'];


				// Validate The Form

				$formErrors = array();

					if(empty($name)){//string lenght

						$formErrors[] = ' Name Can\'t be <strong> Empty</strong>'; //push error message in array

					}
					if(empty($desc)){

						$formErrors[] = 'Description Can\'t be <strong> Empty</strong>'; 

					}
					if(empty($price)){

						$formErrors[] = 'Price Can\'t be <strong> Empty</strong>'; 

					}
					if(empty($country)){

						$formErrors[] = 'Country Can\'t be <strong> Empty</strong>';

					}
					if($status == 0){ // 0 is The First Value Empity 


						$formErrors[] = 'You Must Choose The<strong> Status</strong>';

					}
					if($member == 0){ // 0 is The First Value Empity 


						$formErrors[] = 'You Must Choose The<strong> Member</strong>';

					}
					if($cat == 0){ // 0 is The First Value Empity 


						$formErrors[] = 'You Must Choose The<strong> Category</strong>';

					}

				// Loop Info Errors Array And Echo It
				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">' . $error. '</div>' ;
				}

				// Check If There's No Error Proceed The Update Operation
					if (empty($formErrors)){

					// Insert New Item Info In Database
						$stmt = $conn->prepare("INSERT INTO 

							items(Name,Description,Price,Country_Made,Status,Add_Date,Cat_ID,Member_ID,tags)
							VALUES(:zname, :zdesc, :zprice ,:zcountry ,:zstatus ,now(),:zcat,:zmember,:ztags)") ;

						$stmt->execute(array(

							'zname' 	=> $name,
							'zdesc' 	=> $desc,
							'zprice' 	=> $price,
							'zcountry'  => $country,
							'zstatus' 	=> $status,
							'zcat'      => $cat,
							'zmember' 	=> $member,
							'ztags' 	=> $tags

					));


					$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . 'Record Insert</div>';
					redirectHome($theMsg,'back');		

					
					}
	        }else{

	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome( $theMsg);
	    	}

	    	    echo "</div>";
		
			

		}elseif ( $do == 'edit' ){ 
			
			/* Edit page*/ 

			// Check If GET Request userid Is Numeric & GET The Integer Value Of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$stmt = $conn->prepare("SELECT * FROM items WHERE item_ID = ?");

			// Execute Query
			$stmt->execute(array($itemid));

 			// Fetch The Data
			$item = $stmt->fetch();

			//The item Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if($count > 0 )
			{

?> 			
			<!--close php to write free html-->

			<h1 class="text-center">Edit Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=update" method="POST">
			    <input type="hidden" name="itemid" value="<?php echo $itemid?>" />

				<!--Start Name of Categories Field-->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="true" 
								placeholder="Name Of The Item" 
								value="<?php echo $item['Name']?>" />
						</div>
					</div>
				<!--End Name Field-->

			    <!--Start Description Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Description</label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="true" 
								placeholder="Description Of The Item" 
								value="<?php echo $item['Description']?>"/>
						</div>
					</div>
				<!--End Description Field-->

			    <!--Start Price Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Price </label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								required="true" 
								placeholder="Price Of The Item" 
								value="<?php echo $item['Price']?>"/>
						</div>
					</div>
				<!--End Price Field-->


 			    <!--Start Country Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Country </label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								required="true" 
								placeholder="Country Of Made" 
								value="<?php echo $item['Country_Made']?>"/>
						</div>
					</div>
				<!--End Country Field-->	

				<!--Start Status Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Status </label>
						
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="status">

								<option value="1" <?php if($item['Status'] == 1) { echo 'selected' ;}?> >New</option>
								<option value="2" <?php if($item['Status'] == 2) { echo 'selected' ;}?>>Like New</option>
								<option value="3" <?php if($item['Status'] == 3) { echo 'selected' ;}?>>Used</option>
								<option value="4" <?php if($item['Status'] == 4) { echo 'selected' ;}?>>Very Old</option>					
							</select>
						</div>
					</div>
				<!--End Status Field-->

				<!--Start Members Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Member </label>
						
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="member">
								<option value="0">...</option>		
								<?php
									
									$stmt = $conn->prepare("SELECT * FROM users");
									$stmt ->execute();
									$users = $stmt->FetchAll();

									foreach ($users as $key => $user) {
									
										echo "<option value='" .$user['UserID']. "'"; 
										if($item['Member_ID'] == $user['UserID']) { echo 'selected' ;} 
										echo ">" .$user['Username'] ."</option>";
									}
								?>		
							</select>
						</div>
					</div>
				<!--End Members Field-->

				<!--Start Category Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Category </label>
						
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="category">	
								<?php
									
									$stmt2 = $conn->prepare("SELECT * FROM categories");
									$stmt2 ->execute();
									$cats = $stmt2->FetchAll();
									
									foreach ($cats as $key => $cat) {
										echo "<option value='" .$cat['ID']. "'";
										if($item['Cat_ID'] == $cat['ID']) { echo 'selected' ;}
										echo ">" . $cat['Name'] ."</option>";
									}
								?>		
							</select>
						</div>
					</div>
				<!--End Category Field-->			

			    <!--Start Tags Field-->
					<div class="form-group form-group-lg"> 
						<label class="col-sm-2 control-label">Tags</label>
						
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="Separate Tags With Coma (,)" 
								value="<?php echo $item['tags'] ?>" />
						</div>
					</div>
				<!--End Tags Field-->	
									
				<!--Start Button Save-->
					<div class="form-group"> 
						<div class=" col-sm-offset-2 col-sm-10">
							<input type="submit" value="Edit Item" class="btn btn-primary btn-sm"/>
						</div>
					</div>
				<!--End Button Save--> 

				</form>
						<?php

										//Select All Comments 
								$stmt = $conn->prepare("SELECT 
															comments.*, users.Username
														FROM
															comments 
														INNER join
														    	users
														ON
																users.UserID = comments.user_id	
														WHERE item_id = ? "											
														);
								// Execute The Statement
								$stmt -> execute(array($itemid));
								//Assign To Variable
								$rows = $stmt->fetchAll();

								if (! empty($rows)){

						?>
									
								<h1 class="text-center">Manage [ <?php echo $item['Name']?> ] Comments</h1>
										<div class="table-responsive">
											<table class="main-table text-center table table-bordered">
												<tr>
													<td>Comment</td>
													<td>User Name</td>
													<td>Add Data</td>
													<td>Control</td>
												</tr>
						<?php

										foreach($rows as $row){

												echo "<tr>"; 
													echo "<td>".$row['comment']."</td>";
													echo "<td>".$row['Username']."</td>";
													echo "<td>".$row['comment_date']."</td>";
												    echo"<td>
													<a href='comments.php?do=edit&comid=".$row['c_id']."'class='btn btn-success'>
													<i class= 'fa fa-edit'> </i> Edit </a> 
													<a href='comments.php?do=delete&comid=".$row['c_id']."'class='btn btn-danger confirm'>
													<i class='fa fa-close'> </i> Delete </a>";
											
											//Appear Approve Button If status = 0 
											if($row['status'] == 0){
														    	
											    	echo "<a href='comments.php?do=approve&comid=".$row['c_id']."'class='btn btn-info activate' >
											    <i class='fa fa-check'></i>Approve</a>";

											}


													echo "</td>";
												echo "</tr>"; 

										}

						?>
										</table>
									</div>
								<?php } ?>
			
			</div>			

<?php 

		// If There's No Such ID Show Error Message
	        
	    }else{

	        echo "<div class='container'>";

	        $theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
	        redirectHome($theMsg);

	        echo "</div>";
	    }



	    }elseif ( $do == 'update' ){ 


	    	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	    		
	    		echo "<h1 class='text-center'>Update Member</h1>";

	    		echo "<div class='container'>";

	    		// Get Variables From The Form

	    		$id 			= $_POST['itemid'];
	    		$name 			= $_POST['name'];
				$desc 			= $_POST['description'];
				$price 			= $_POST['price'];
	    		$country 		= $_POST['country'];
	    		$status 		= $_POST['status'];
				$member 		= $_POST['member'];
				$cat 			= $_POST['category'];
				$tags     		= $_POST['tags'];

				// Validate The Form

				$formErrors = array();

					if(empty($name)){//string lenght

						$formErrors[] = ' Name Can\'t be <strong> Empty</strong>'; //push error message in array

					}
					if(empty($desc)){

						$formErrors[] = 'Description Can\'t be <strong> Empty</strong>'; 

					}
					if(empty($price)){

						$formErrors[] = 'Price Can\'t be <strong> Empty</strong>'; 

					}
					if(empty($country)){

						$formErrors[] = 'Country Can\'t be <strong> Empty</strong>';

					}
					if($status == 0){ // 0 is The First Value Empity 


						$formErrors[] = 'You Must Choose The<strong> Status</strong>';

					}
					if($member == 0){ // 0 is The First Value Empity 


						$formErrors[] = 'You Must Choose The<strong> Member</strong>';

					}
					if($cat == 0){ // 0 is The First Value Empity 


						$formErrors[] = 'You Must Choose The<strong> Category</strong>';

					}

				// Loop Info Errors Array And Echo It
				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">' . $error. '</div>' ;
				}

				if (empty($formErrors)){

					//Update The Database With This Info
					$stmt = $conn->prepare("UPDATE 
												items 
											SET 
												Name = ? ,
												Description = ? ,
												Price = ? ,
												Country_Made = ? ,
												Status = ? ,
												Cat_ID = ? ,
												Member_ID = ? ,
												tags = ?
											WHERE 
												item_ID = ?") ;

					$stmt->execute(array($name,$desc,$price,$country,$status,$cat,$member,$tags,$id));

					// Echo Success Messsage

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record Updated</div>';	
					redirectHome($theMsg,'back');	

				}	

	    	}else{
	    		
	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome($theMsg);

	    	}

	    	    echo "</div>";



	    }elseif ( $do == 'delete'){

				//Delete User
	    		echo "<h1 class='text-center'>Deleted Item</h1>";

	    		echo "<div class='container'>";	    	

	    	// Check If GET Request itemid Is Numeric & GET The Integer Value Of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('Item_ID','items', $itemid);

			// If There's Such ID Show The Form
				if($check > 0 )
				{
					// echo 'Good This ID Is Exist' ;
					$stmt = $conn->prepare("DELETE FROM items WHERE item_ID = :zid") ;
					$stmt->bindParam(":zid", $itemid); // Rabt zid b el itemid ely geli.
					$stmt->execute(); 

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Deleted </div>';	
		    		redirectHome($theMsg,'back');

			}else{

				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}

		echo '</div>';


	    }elseif ( $do == 'approve'){

	    	//Approved Item
	    		echo "<h1 class='text-center'>Approved Item</h1>";

	    		echo "<div class='container'>";	    	

	    	// Check If GET Request itemid Is Numeric & GET The Integer Value Of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('item_ID','items', $itemid);

			// If There's Such ID Show The Form

			if($check > 0 )
			{
				// echo 'Good This ID Is Exist' ;

				$stmt = $conn->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ? ") ;
				$stmt->execute(array($itemid));

				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Approved </div>';	
	    		redirectHome($theMsg,'back');

				echo '</div>';

			}else{

				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}

	    
		}


 		// Start Footer

		include $tpl.'footer.php';

	}else{

		header('Location: index.php');

		exit();

	}
?>