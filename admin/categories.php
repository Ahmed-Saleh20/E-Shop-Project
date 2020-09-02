<?php

	/*
	 * ==================================================
	 * == Categories Page
	 * ==================================================
	*/

	session_start();

	$pageTitle = "Categories Page" ; 

	if(isset($_SESSION['adminName'])){

		include 'int.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "manage";

		// Start Manage Page
		if ($do == 'manage'){ 

			$sort = 'ASC';

			$sort_array = array('ASC','DESC');

			if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){ // in_array(needle, haystack) --> bbhs 3n el ebra fe koma el ash
				$sort = $_GET['sort'];
			}

			$stmt2 = $conn->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

			$stmt2->execute();

			$cats = $stmt2->FetchAll(); ?>

			<h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
					<i class="fa fa-edit"></i> Manage Categories
						<div class="option pull-right">
							<i class="fa fa-sort"></i> Ordering: [
							<a class="<?php if($sort == 'ASC') { echo 'active';}?>" href="?sort=ASC">ASC</a> |
							<a class="<?php if($sort == 'DESC') { echo 'active';}?>" href="?sort=DESC">DESC</a> ]
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full"> Full </span> |
							<span data-view="classic"> Classic </span> ]
						</div>	
					</div>
					<div class="panel-body">
					<?php
					foreach ($cats as $cat) {
					 	echo "<div class='cat'>";
					 		echo "<div class='hidden-buttons'>";
					 			echo "<a href='categories.php?do=edit&catid=".$cat['ID']."'class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
					 			echo "<a href='categories.php?do=delete&catid=".$cat['ID']."' class='btn btn-xs btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";							 			
					 		echo "</div>";
						 	echo "<h3>" . $cat['Name'] . '</h3>';

						 	echo "<div class='full-view'";
							 	echo "<p>";
								 	if( $cat['Description'] == ''){
								 	 echo 'This Category has no Description';
								 	} else {
								 	 echo $cat['Description'];}
							 	echo "</p>";
							 	if($cat['Visibility'] == 1 ){ echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden </span>' ;}
							 	if($cat['Allow_Comment'] == 1 ){ echo '<span class="commenting"><i class="fa fa-close"></i> Commment Disabled </span>' ;}
							 	if($cat['Allow_Ads'] == 1 ){ echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled</span>' ;}
						        // Start Sub Categories
						        $childCats = getAllFrom("*","categories","WHERE parent = {$cat['ID']}","","ID","ASC" );
						        if(!empty($childCats)){
						        	echo "<h4 class='child-head'>Child Categories</h4>";
						        	echo "<ul class='list-unstyled child-cats'>";
						        foreach ( $childCats as $c) {
						        	echo "<li class='child-link'>
						        	<a href='categories.php?do=edit&catid=".$c['ID']."'>".$c['Name']."</a>
						        	<a href='categories.php?do=delete&catid=".$c['ID']."' class='show-delete confirm'> Delete</a>
						        	</li>";
						        }
						        echo "</ul>";
							 	}
							 	// End Sub Categories
						 	echo "</div>";
					 	echo "</div>";
					 echo "<hr>";
					}
					?>
					</div>	
				</div>	
				<a class=" addbtn btn btn-primary" href="categories.php?do=add"><i class="fa fa-plus"></i> Add New Category</a>
			</div>	
			<?php

		}elseif ( $do == 'add') {
       // Add Page
?>
			
			<h1 class="text-center">Add New Category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=insert" method="POST">

					<!--Start Name of Categories Field-->
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" autocomplete="off" required="required" 
								placeholder="Name Of Categories" />
							</div>
						</div>
					<!--End Name Field-->

					<!--Start Description Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Description</label>
							
							<div class="col-sm-10">
								<input type="text" name="description" class="form-control" placeholder="Description About Categories" />
							</div>
						</div>
					<!--End Description Field-->

					<!--Start Ordering Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Ordering</label>
							
							<div class="col-sm-10">
								<input type="text" name="ordering" class="form-control"  placeholder="Ordering Categories"/>
							</div>
						</div>
					<!--End Ordering Field-->

					<!--Start Category Type-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Parent?</label>
							
							<div class="col-sm-10 ">
								<select class="form-control" name="parent">
									<option value="0">None</option>
									<?php
										$allCats = getAllFrom("*","categories","WHERE parent = 0","","ID","ASC");
										foreach($allCats as $cat){
											echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--End Category Type-->

				    <!--Start Visibility Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="vis-yes" type="radio" name="Visibility" value="0" checked />
									<label for="vis-yes">Yes</label>
								</div>	
								<div>
									<input id="vis-no" type="radio" name="Visibility" value="1" />
									<label for="vis-no">No</label>
								</div>	
							</div>
						</div>
					<!--End Visibility Field-->

					<!--Start Commenting Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Allow Comenting</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="com-yes" type="radio" name="comenting" value="0" checked />
									<label for="com-yes">Yes</label>
								</div>	
								<div>
									<input id="com-no" type="radio" name="comenting" value="1" />
									<label for="com-no">No</label>
								</div>	
							</div>
						</div>
					<!--End Commenting Field-->

					<!--Start Ads Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" checked />
									<label for="ads-yes">Yes</label>
								</div>	
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" />
									<label for="ads-no">No</label>
								</div>	
							</div>
						</div>
					<!--End Ads Field-->

					<!--Start Button Save-->
						<div class="form-group"> 
							<div class=" col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Category" class="btn btn-primary"/>
							</div>
						</div>
					<!--End Button Save-->

					</form>
				</div>

<?php
		}elseif ($do == 'insert') {
					// Insert Page
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

	    		
	    		echo "<h1 class='text-center'>Insert New Category</h1>";

	    		echo "<div class='container'>";

	    		// Get Variables From The Form

	    		$name    	= $_POST['name'];
				$desc    	= $_POST['description'];
				$parent    	= $_POST['parent'];
				$order   	= $_POST['ordering'];
				$Visible	= $_POST['Visibility'];
				$comment 	= $_POST['comenting'];
				$ads     	= $_POST['ads'];

				//Check If Category Exist in Database

				$check = checkItem("Name","Categories", $name);

				if($check == 1 ){

					$theMsg = '<div class="alert alert-danger"> Sorry This Category Is Exist</div>';
				
					redirectHome( $theMsg, 'back');

				}else {

				// Insert Cat Info In Database
				
				 $stmt = $conn->prepare("
							INSERT INTO categories(Name,Description,parent,Ordering,Visibility,Allow_Comment,Allow_Ads)
							VALUES(:zname, :zdesc, :zparent, :zorder,:zvisible ,:zcomment ,:zads) ") ;

						$stmt->execute(array(

							'zname'    => $name,
							'zdesc'    => $desc,
							'zparent'  => $parent,
							'zorder'   => $order,
							'zvisible' => $Visible,
							'zcomment' => $comment,
							'zads'     => $ads,						
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

			// Check If GET Request Catid Is Numeric & GET The Integer Value Of it

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$stmt = $conn->prepare("SELECT * FROM categories WHERE ID = ?");

			// Execute Query
			$stmt->execute(array($catid));

 			// Fetch The Data
			$cat = $stmt->fetch();

			//The Row Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if($count > 0 )

			{

?> 			
			<!--close php to write free html-->

			<h1 class="text-center">Edit Category</h1>
			<div class="container">
			<form class="form-horizontal" action="?do=update" method="POST">
					<input type="hidden" name="catid" value="<?php echo $catid?>"/>

					<!--Start Name of Categories Field-->
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" required="required" 
								placeholder="Name Of Categories" value="<?php echo $cat['Name'] ?>"/>
							</div>
						</div>
					<!--End Name Field-->

					<!--Start Description Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Description</label>
							
							<div class="col-sm-10">
								<input type="text" name="description" class="form-control" placeholder="Description About Categories" value="<?php echo $cat['Description'] ?>" />
							</div>
						</div>
					<!--End Description Field-->

					<!--Start Ordering Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Ordering</label>
							
							<div class="col-sm-10">
								<input type="text" name="ordering" class="form-control"  placeholder="Ordering Categories" value="<?php echo $cat['Ordering'] ?>"/>
							</div>
						</div>
					<!--End Ordering Field-->

					<!--Start Category Type-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Parent?</label>
							
							<div class="col-sm-10 ">
								<select class="form-control" name="parent">
									<option value="0">None</option>
									<?php
										$allCats = getAllFrom("*","categories","WHERE parent = 0","","ID","ASC");
										foreach($allCats as $c){
											echo "<option value='".$c['ID']."'";
											if($cat['parent'] == $c['ID']){ echo 'selected';}
											echo ">".$c['Name']."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--End Category Type-->					

				    <!--Start Visibility Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0){ echo 'checked';}?> />
									<label for="vis-yes">Yes</label>
								</div>	
								<div>
									<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1){ echo 'checked';}?> />
									<label for="vis-no">No</label>
								</div>	
							</div>
						</div>
					<!--End Visibility Field-->

					<!--Start Commenting Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Allow Comenting</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="com-yes" type="radio" name="comenting" value="0" <?php if ($cat['Allow_Comment'] == 0){ echo 'checked';}?> />
									<label for="com-yes">Yes</label>
								</div>	
								<div>
									<input id="com-no" type="radio" name="comenting" value="1" <?php if ($cat['Allow_Comment'] == 1){ echo 'checked';}?>/>
									<label for="com-no">No</label>
								</div>	
							</div>
						</div>
					<!--End Commenting Field-->

					<!--Start Ads Field-->
						<div class="form-group"> 
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0){ echo 'checked';}?> />
									<label for="ads-yes">Yes</label>
								</div>	
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1){ echo 'checked';}?> />
									<label for="ads-no">No</label>
								</div>	
							</div>
						</div>
					<!--End Ads Field-->

					<!--Start Button Save-->
						<div class="form-group"> 
							<div class=" col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Category" class="btn btn-primary"/>
							</div>
						</div>
					<!--End Button Save-->

					</form>
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

	    		$id 	 = $_POST['catid'];
	    		$name 	 = $_POST['name'];
				$desc 	 = $_POST['description'];
				$order 	 = $_POST['ordering'];
				$parent  = $_POST['parent'];
	    		$Visible = $_POST['visibility'];
				$comment = $_POST['comenting'];
				$ads 	 = $_POST['ads'];				


				// Check If There's No Error Proceed The Update Operation


					//Update The Database With This Info
					$stmt = $conn->prepare("UPDATE 
										categories 
										SET Name = ? ,Description = ? ,Ordering = ?,parent = ? ,Visibility = ?,Allow_Comment = ?,Allow_Ads = ? 
										WHERE 
											ID = ?") ;

					$stmt->execute(array($name,$desc,$order,$parent, $Visible,$comment,$ads,$id));

					// Echo Success Messsage

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record Updated</div>';	
					redirectHome($theMsg,'back');	



	    	}else{
	    		
	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome($theMsg);

	    	}

	    	    echo "</div>";



	    }elseif ( $do == 'delete'){


	    	//Delete User
	    		echo "<h1 class='text-center'>Deleted Category</h1>";

	    		echo "<div class='container'>";	    	

	    	// Check If GET Request catid Is Numeric & GET The Integer Value Of it

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('ID','categories', $catid);

			// If There's Such ID Show The Form
				if($check > 0 )
				{
					// echo 'Good This ID Is Exist' ;
					$stmt = $conn->prepare("DELETE FROM categories WHERE ID = :zid") ;
					$stmt->bindParam(":zid", $catid); 
					$stmt->execute(); 

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Deleted </div>';	
		    		redirectHome($theMsg,'back');

			}else{

				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}

		echo '</div>';


	    }elseif ( $do == 'active'){

	    
		}

 		// Start Footer

		include $tpl.'footer.php';

	}else{

		header('Location: index.php');

		exit();

	}
?>