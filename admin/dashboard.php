<?php
	   /*
		*
		*   Admin Dashboard
		*
		*/

ob_start(); // Output Buffering Statr

session_start();

	if(isset($_SESSION['adminName'])){

		$pageTitle = 'Admin Dashboard';
		include 'int.php';

		// echo "Welcome " .$_SESSION['adminName'] ;

			/* Start Admin Dashboard */

		$numUsers = 5; //<!-- Number Of Latest Users -->
		$latestUsers = getLatest("*","users","UserID",$numUsers); // Latest User Array
		$numItems = 5;
		$latestItems = getLatest("*","items","Item_ID",$numItems);
		$comentnum = 5;

		?>
		    <div class="home-stats">
				<div class="container text-center">
					<h1>Dashboard</h1>
					<div class="row">
						<div class="col-md-6">
							<div class="stat st-pending">
								<i class="fa fa-user-plus"></i>
								<div class="info">
								Pending Members
								<span><a href="Members.php?do=manage&page=Pending"><?php echo checkItem('RegStatus','users',0) ?></a></span> <!-- We Can Use any function to do action whatever its name-->
							</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="stat st-comments">
							<i class="fa fa-comments "></i>
								<div class="info">
								Total Comments
								<span><a href="comments.php"><?php echo countItems('c_id','comments') ?></a></span>
							</div>
						</div>
						</div>
					</div>
				</div>
		    </div>

			<div class=" latest">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-users"></i> Latest  <?php echo $numUsers ?> Registerd Users
									<span class="toggle-info pull-right">
										<i class="fa fa-minus fa-lg"></i>
									</span>
								</div>
								<div class="panel-body">

								<ul class="list-unstyled latest-users">
								<?php
									if(!empty($latestUsers)){
										foreach ($latestUsers as $key => $user) {
											echo '<li>';
									 			echo $user['Username'];
												echo '<a href="members.php?do=edit&userid='.$user['UserID'].'"';
													echo '<span class="btn btn-success pull-right">'; //pull-right to align right
														echo '<i class="fa fa-edit"></i>Edit';

															if($user['RegStatus'] == 0){

							    								echo "<a href='members.php?do=active&userid=".$user['UserID']."'class='btn btn-info pull-right activate' >
							    								<i class='fa fa-close'></i>Activate</a>"; // activite To Edit It in Css

															}

													echo '</span>';
												echo '</a>';
											echo '</li>';
										}
									}else{
											echo 'There\'s No Users Yet';
									}
								?>
								</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-tag"></i>  Latest  <?php echo $numItems ?> Items
									<span class="toggle-info pull-right">
										<i class="fa fa-minus fa-lg"></i>
									</span>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled latest-users">
								<?php
										if(! empty($latestItems)){
											foreach ($latestItems as $key => $item) {

											echo '<li>';
									 			echo $item['Name'];
												echo '<a href="items.php?do=edit&itemid='.$item['item_ID'].'"';
													echo '<span class="btn btn-success pull-right">'; //pull-right to align right
														echo '<i class="fa fa-edit"></i>Edit';

															if($item['Approve'] == 0){

							    								echo "<a href='items.php?do=approve&itemid=".$item['item_ID']."'class='btn btn-info pull-right activate' >
							    								<i class='fa fa-check'></i>Approve</a>"; // activite To Edit It in Css

															}

													echo '</span>';
												echo '</a>';
											echo '</li>';
											}
										}else{
											echo 'There\'s No Items Yet';
										}

								?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-users"></i> Latest  <?php echo $comentnum ?> Comments
									<span class="toggle-info pull-right">
										<i class="fa fa-minus fa-lg"></i>
									</span>
								</div>
								<div class="panel-body">

								<ul class="list-unstyled latest-users">

								</ul>
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
																ORDER BY
																	c_id DESC
																LIMIT $comentnum" );

										// Execute The Statement
										$stmt -> execute();
										//Assign To Variable
										$comments = $stmt->fetchAll();

										if (!empty($comments)){

											foreach ($comments as $key => $comment) {
												echo '<div class="comment-box">';
													echo '<Span class="member-n">' . $comment['Username']  . '</span>';
													echo '<p class="member-c">'    . $comment['comment'] . '</p>';
												echo '</div>';
											}
										}else{
											echo 'There\'s No Comments Yet';
										}
									?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
		/* End Admin Dashboard */
		include $tpl.'footer.php';

	}else{

	    // echo "You Are Not Authorized To View This Page";

		header('Location: index.php');
		exit();

	}

	ob_end_flush(); //Release The Output
?>
