<?php

	/*
	 * ==================================================
	 * == Manage Comments Page
	 * == You Can Edit | Delete | Approve Comments From Here
	 * ==================================================
	*/

	session_start();

	$pageTitle = "Comments" ;

	if(isset($_SESSION['adminName'])){

		include 'int.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "manage";

		// Start Manage Page
		if ($do == 'manage'){ // Manage Page == Home

		//Select All Comments
		$stmt = $conn->prepare("SELECT
									comments.*, items.Name , users.Username
								FROM
									comments
								INNER join
								    	items
								ON
										items.item_ID = comments.item_id
								INNER join
								    	users
								ON
										users.UserID = comments.user_id
								ORDER BY
									c_id DESC
								");

		// Execute The Statement
		$stmt -> execute();
		//Assign To Variable
		$rows = $stmt->fetchAll();

?>

		<h1 class="text-center">Manage Comments</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Add Data</td>
							<td>Control</td>
						</tr>
<?php

				foreach($rows as $row){

						echo "<tr>";
							echo "<td>".$row['c_id']."</td>";
							echo "<td>".$row['comment']."</td>";
							echo "<td>".$row['Name']."</td>";
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

		</div>


<?php

		}elseif ( $do == 'edit' ){

			/* Edit page */

			// Check If GET Request comid Is Numeric & GET The Integer Value Of it

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$stmt = $conn->prepare("SELECT * FROM comments WHERE c_id = ? ");

			// Execute Query
			$stmt->execute(array($comid));

 			// Fetch The Data
			$row = $stmt->fetch();

			//The Row Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if($count > 0 )
			{

?>
			<!--close php to write free html-->

			<h1 class="text-center">Edit Comment</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="comid" value="<?php echo $comid?>"/>

				<!--Start Comment Field-->
					<div class="form-group">
					<!-- form-group-> class main form have input and label together -->
						<label class="col-sm-2 control-label">Comment</label>

						<div class="col-sm-10 col-md-6">
							<textarea name="comment" class="form-control"><?php echo $row['comment'] ?></textarea>
						</div>
					</div>
				<!--End Comment Field-->

				<!--Start Button Save-->
					<div class="form-group">
						<div class=" col-sm-offset-2 col-sm-10">
							<input type="submit" value="Save" class="btn btn-primary"/>
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


	    		echo "<h1 class='text-center'>Update Comment</h1>";

	    		echo "<div class='container'>";

	    		// Get Variables From The Form

	    		$id 	 = $_POST['comid'];
	    		$comment = $_POST['comment'];

				// Validate The Form
				$formErrors = array();


				if(empty($comment)){

					$formErrors[] = '<div class="alert alert-danger"> Comment Cant Be Empty </div>';

				}

				// Loop Info Errors Array And Echo It
				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">' . $error . '</div>' ;
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)){

					//Update The Database With This Info
					$stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE c_id = ?") ;
					$stmt->execute(array($comment,$id));

					// Echo Success Messsage

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg,'back');

				}

	    	}else{

	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome($theMsg);

	    	}

	    	    echo "</div>";

	    }elseif ( $do == 'delete'){

	    	//Delete Comment
	    		echo "<h1 class='text-center'>Deleted Comment</h1>";

	    		echo "<div class='container'>";

	    	// Check If GET Request comid Is Numeric & GET The Integer Value Of it

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('c_id','comments', $comid);

			// If There's Such ID Show The Form
				if($check > 0 )
				{
					// echo 'Good This ID Is Exist' ;
					$stmt = $conn->prepare("DELETE FROM comments WHERE c_id = :zid") ;
					$stmt->bindParam(":zid", $comid);
					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Deleted </div>';
		    		redirectHome($theMsg,'back');

			}else{

				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}

		echo '</div>';

	    }elseif ( $do == 'approve'){

	    	//Approve Comment
	    		echo "<h1 class='text-center'>Approve Comment</h1>";

	    		echo "<div class='container'>";

	    	// Check If GET Request userid Is Numeric & GET The Integer Value Of it

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('c_id','comments', $comid);

			// If There's Such ID Show The Form

			if($check > 0 )
			{
				// echo 'Good This ID Is Exist' ;

				$stmt = $conn->prepare("UPDATE comments SET status = 1 WHERE c_id = ? ") ;
				$stmt->execute(array($comid));

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
