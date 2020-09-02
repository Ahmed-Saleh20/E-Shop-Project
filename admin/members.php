<?php

	/*
	 * ==================================================
	 * == Manage Members Page
	 * == You Can Add | Edit | Delete Members From Here
	 * ==================================================
	*/

	session_start();
	$pageTitle = "Members" ;
	if(isset($_SESSION['adminName'])){
		include 'int.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "manage";

		// Start Manage Page
		if ($do == 'manage'){ // Manage Page == Home

			$query = '';

			if( isset($_GET['page']) && $_GET['page'] == 'Pending'){

				$query = 'AND RegStatus = 0';

			}

		//Select All Users Except Admin
		$stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
		// Execute The Statement
		$stmt -> execute();
		//Assign To Variable
		$rows = $stmt->fetchAll();

?>

		<h1 class="text-center">Manage Memers</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registerd Data</td>
							<td>Control</td>
						</tr>
<?php

			foreach($rows as $row){

				echo "<tr>";
					echo "<td>".$row['UserID']."</td>";
					echo "<td>".$row['Username']."</td>";
					echo "<td>".$row['Email']."</td>";
					echo "<td>".$row['FullName']."</td>";
					echo "<td>".$row['Date']."</td>";
				    echo"<td>
					<a href='members.php?do=edit&userid=".$row['UserID']."'class='btn btn-success'>
					<i class= 'fa fa-edit'> </i> Edit </a>
					<a href='members.php?do=delete&userid=".$row['UserID']."'class='btn btn-danger confirm'>
					<i class='fa fa-close'> </i> Delete </a>";

				//Appear Activation Button If RegStatus = 0
				if($row['RegStatus'] == 0){

				    	echo "<a href='members.php?do=active&userid=".$row['UserID']."'class='btn btn-info activate' >
				    <i class='fa fa-check'></i>Activate</a>"; // activite To Edit It in Css

				}
						echo "</td>";
					echo "</tr>";
			}

?>
				</table>
			</div>
			    <!-- Add New Member Button -->
				<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
		</div>


<?php

		}elseif ( $do == 'add') {

       // Add Page
?>

			<h1 class="text-center">Add New Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">

					<!--Start Username Field-->
						<div class="form-group"> <!-- form-group-> class main form have input and label together -->
							<label class="col-sm-2 control-label">Username</label>

							<div class="col-sm-10">
								<input type="text" name="username" class="form-control" autocomplete="off" required="required"
								placeholder="UserName To Login" />
							</div>
						</div>
					<!--End Username Field-->

					<!--Start Password Field-->
						<div class="form-group"> <!-- form-group-> class main form have input and label together -->
							<label class="col-sm-2 control-label">Password</label>

							<div class="col-sm-10">
								<input type="password" name="password" class="form-control password" autocomplete="new-password" required="required" placeholder="Password Should Be Strong" />
								<i class="fa fa-eye fa-2x  show-pass"></i>
							</div>
						</div>
					<!--End Password Field-->

					<!--Start E-mail Field-->
						<div class="form-group"> <!-- form-group-> class main form have input and label together -->
							<label class="col-sm-2 control-label">E-mail</label>

							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" required="required" placeholder="E-mail Must Be Valid"/>
							</div>
						</div>
					<!--End E-mail Field-->

				    <!--Start FullName Field-->
						<div class="form-group"> <!-- form-group-> class main form have input and label together -->
							<label class="col-sm-2 control-label">FullName</label>

							<div class="col-sm-10">
								<input type="text" name="fullname" class="form-control" required="required"
								placeholder="FullName Appeare In Your Profile"/>
							</div>
						</div>
					<!--End FullName Field-->

				    <!--Start Avatar Field-->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input
									type="file"
								 	name="avatar"
								 	class="form-control"
								 	required="required"
								/>
							</div>
						</div>
					<!--End Avatar Field-->

					<!--Start Button Save-->
						<div class="form-group"> <!-- form-group-> class main form have input and label together -->
							<div class=" col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Member" class="btn btn-primary"/>
							</div>
						</div>
					<!--End Button Save-->

					</form>
				</div>

<?php

		}elseif ($do == 'insert') {

		// Insert Page

			if($_SERVER['REQUEST_METHOD'] == 'POST'){


	    		echo "<h1 class='text-center'>Insert New Member</h1>";
	    		echo "<div class='container'>";

	    		// Upload Variables

	    		$avatarName = $_FILES['avatar']['name'];
	    		$avatarSize = $_FILES['avatar']['size'];
	    		$avatarTmp  = $_FILES['avatar']['tmp_name'];
	    		$avatarType = $_FILES['avatar']['type'];

	    		// 	List Of Allowed File Typed To Upload

	    		$avatarAllowedExtension = array("jpeg","jpg","png","gif");

	    		// Get Avatar Extension

	    		$avaterExtension = strtolower( end( explode('.',$avatarName) ) );


	    		// Get Variables From The Form

	    		$user = $_POST['username'];//name of the field in form
				$pass = $_POST['password'];
				$email = $_POST['email'];
				$name = $_POST['fullname'];

				$hashpass = sha1($_POST['password']) ;

				// Validate The Form

				$formErrors = array();

					if(strlen($user) < 4){//string lenght

						$formErrors[] = 'Username Cant Be Less Than 4 Character '; //push error message in array

					}

					if(empty($user)){

						$formErrors[] = 'Username Cant Be Empty';

					}
					if(empty($pass)){

						$formErrors[] = 'Password Cant Be Empty';

					}
					if(empty($email)){

						$formErrors[] = 'E-mail Cant Be Empty';

					}
					if(empty($name)){

						$formErrors[] = 'FullName Cant Be Empty';

					}
					if(empty($avatarName)){

						$formErrors[] = 'Avatar Is Required';

					}
					if($avatarSize > 4194304 ){

						$formErrors[] = 'Avatar Can\'t Be Larger Than 4MG';

					}
					if( !empty( $avatarName ) && !in_array( $avaterExtension , $avatarAllowedExtension ) ){

						$formErrors[] = 'This Extension Is Not Allowed';

					}


				// Loop Info Errors Array And Echo It
				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">' . $error. '</div>' ;
				}

					// Check If There's No Error Proceed The Update Operation
					if (empty($formErrors)){

						$avatar = rand(0,1000) . '_' . $avatarName;
						move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar );
						//Check If User Exist in Database
							$check = checkItem("Username","users", $user);

							if($check == 1 ){

							$theMsg = '<div class="alert alert-danger"> Sorry This User Is Exist</div>';
				    		redirectHome( $theMsg, 'back');

					}else {

					// Insert New Member Info In Database
						$stmt = $conn->prepare("
							INSERT INTO users(Username,Password,Email,FullName,RegStatus,Date,avatar)
							VALUES(:zuser, :zpass, :zmail ,:zname ,1 ,now(),:zavatar)") ;

						$stmt->execute(array(

							'zuser'   => $user,
							'zpass'   => $hashpass,
							'zmail'   => $email,
							'zname'   => $name,
							'zavatar' => $avatar
					));

					// INSERT INTO users(Username,Password,Email,FullName)
					// 	VALUES(?,?,?,?)") ;
					// $stmt->execute(array($user,$email,$name, $haspass));
					// Echo Success Messsage

					$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . 'Record Insert</div>';
					redirectHome($theMsg,'back');

					}
					}
	        }else{

	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome( $theMsg);
	    	}

	    	    echo "</div>";

		}elseif ( $do == 'edit' ){

			/* Edit page
			// echo 'Welcome in Edit Profile Your ID Is : ' .$_GET['userid'];// userid that i write in edit profile href*/

			// Check If GET Request userid Is Numeric & GET The Integer Value Of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ? LIMIT 1 ");

			// Execute Query
			$stmt->execute(array($userid));

 			// Fetch The Data
			$row = $stmt->fetch();

			//The Row Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if($count = $stmt->rowCount() > 0 )
			{

?>
			<!--close php to write free html-->

			<h1 class="text-center">Edit Member</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="userid" value="<?php echo $userid?>"/>

				<!--Start Username Field-->
					<div class="form-group">
					<!-- form-group-> class main form have input and label together -->
						<label class="col-sm-2 control-label">Username</label>

						<div class="col-sm-10">
							<input type="text" name="username" value="<?php echo $row['Username']?>" class="form-control" autocomplete="off" required="required"  />
						</div>
					</div>
				<!--End Username Field-->

				<!--Start Password Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label">Password</label>

						<div class="col-sm-10">
							<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>" class="form-control"/>

							<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave It Lank If You Dont Want to Change Password" />
						</div>
					</div>
				<!--End Password Field-->

				<!--Start E-mail Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label">E-mail</label>

						<div class="col-sm-10">
							<input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control" required="required"/>
						</div>
					</div>
				<!--End E-mail Field-->

				<!--Start FullName Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label">FullName</label>

						<div class="col-sm-10">
							<input type="text" name="fullname" value="<?php echo $row['FullName']?>" class="form-control" required="required"/>
						</div>
					</div>
				<!--End FullName Field-->

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


	    		echo "<h1 class='text-center'>Update Member</h1>";

	    		echo "<div class='container'>";

	    		// Get Variables From The Form

	    		$id = $_POST['userid'];//name of the field in form
	    		$user = $_POST['username'];
				$email = $_POST['email'];
				$name = $_POST['fullname'];

				// Password Trick

				$pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']) ;

				// if(empty($_POST['newpassword'])){
				// 	$pass = $_POST['oldpassword'];
				// }else{
				// 	$pass = sha1($_POST['newpassword']);
				// }
				//echo $user . $id . $email . $name . $pass;


				// Validate The Form
				$formErrors = array();

				if(strlen($user) < 4){//string lenght

					$formErrors[] = '<div class="alert alert-danger"> Username Cant Be Less Than 4 Character </div>'; //push error message in array

				}

				if(empty($user)){

					$formErrors[] = '<div class="alert alert-danger"> Username Cant Be Empty </div>';

				}
				if(empty($email)){

					$formErrors[] = '<div class="alert alert-danger">E-mail Cant Be Empty </div>';

				}
				if(empty($name)){

					$formErrors[] = '<div class="alert alert-danger">FullName Cant Be Empty </div>';

				}

				// Loop Info Errors Array And Echo It
				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">' . $error . '</div>' ;
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)){

					$stmt2 = $conn->prepare("SELECT
												*
											 FROM
												users
										   	 WHERE
												Username = ?
						 					 AND
												UserID != ?");

					$stmt2->execute(array($user,$id));
					$count = $stmt2->rowCount();

					if ($count == 1){

						$theMsg = "<div class='alert alert-danger'>".'Sorry This User Is Exist'.'</div>';
						redirectHome($theMsg,'back');

					}else{

						//Update The Database With This Info
						$stmt = $conn->prepare("UPDATE users SET Username = ? ,Email = ? ,FullName = ? ,Password = ? WHERE UserID = ?") ;
						$stmt->execute(array($user,$email,$name, $pass,$id));

						// Echo Success Messsage

						$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record Updated</div>';
						redirectHome($theMsg,'back');

					}
				}

	    	}else{

	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome($theMsg);

	    	}

	    	    echo "</div>";

	    }elseif ( $do == 'delete'){

	    	//Delete User
	    		echo "<h1 class='text-center'>Deleted Member</h1>";

	    		echo "<div class='container'>";

	    	// Check If GET Request userid Is Numeric & GET The Integer Value Of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('userid','users', $userid);


            // We can replace this code with checkitem function
			//$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ? ");
			// Execute Query
			//$stmt->execute(array($userid));

 			// Fetch The Data
			//$row = $stmt->fetch();

			//The Row Count
			//$count = $stmt->rowCount();

			// If There's Such ID Show The Form
				if($check > 0 )
				{
					// echo 'Good This ID Is Exist' ;
					$stmt = $conn->prepare("DELETE FROM users WHERE UserID = :zuser") ;
					$stmt->bindParam(":zuser", $userid); // Rabt zuser b el userid ely geli.
					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Deleted </div>';
		    		redirectHome($theMsg,'back');

				}else{

					$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    			redirectHome($theMsg);
				}

		echo '</div>';

	    }elseif ( $do == 'active'){

	    	//Activation User
	    		echo "<h1 class='text-center'>Activated Member</h1>";

	    		echo "<div class='container'>";

	    	// Check If GET Request userid Is Numeric & GET The Integer Value Of it

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; // intvalue
			// Select All Data Depend On This ID
			$check = checkItem('userid','users', $userid);
			// If There's Such ID Show The Form
			if($check > 0 )
			{
				// echo 'Good This ID Is Exist' ;
				$stmt = $conn->prepare("UPDATE users SET RegStatus = 1 WHERE UserId = ? ") ;
				$stmt->execute(array($userid));

				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Activeted </div>';
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
