<?php

		session_start();

		$pageTitle = 'HomePage';

		include "int.php";

		if(isset($_SESSION['userName'])){

			$getUser = $conn->prepare("SELECT * FROM users WHERE Username = ?");
			$getUser ->execute(array($sessionUser));
			$info = $getUser->fetch();
			$userid = $info['UserID'];

?>

	<h1 class="text-center"> My Profile </h1>

	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"> My Information </div>
				<div class="panel-body">
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-unlock-alt fa-fw"></i>
							<span>Name</span>: <?php echo $info['Username'] ?>
						</li>
						<li>
							<i class="fa fa-envelope-o fa-fw"></i>
							<span>Email</span>: <?php echo $info['Email'] ?>
						</li>
						<li>
							<i class="fa fa-user fa-fw"></i>
							<span>Full Name</span>: <?php echo $info['FullName'] ?>
						</li>
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Register Date</span>: <?php echo $info['Date'] ?>
						</li>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Fav Category</span>:
						</li>
					</ul>
					<a href="#" class="btn btn-default">Edit Information</a>
				</div>
			</div>
		</div>
	</div>

	<div class="my-ads block" id="my-ads">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"> My Ads </div>
				<div class="panel-body">
				<?php
				$myItems = getAllFrom("*","items"," WHERE Member_ID = $userid","","item_ID");
				if (! empty($myItems)){
					echo '<div class="row">';
					foreach ($myItems as $item) {

						echo '<div class="col-sm-6 col-md-3">';

							echo '<div class="thumbnail item-box">';
							if( $item['Approve'] == 0 ){
								echo '<span class="approve-status">Waiting Approval</span>';
							}
								echo '<span class="price-tag">$' .$item['Price'] .'</span>';

								echo '<img class="img-responsive" alt="avater" src="includes/images/'.$item['Image'].'"/>';
									echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">' .$item['Name'] .'</a></h3>';
									echo '<p>' .$item['Description'] .'</p>';
									echo '<div class="date">' .$item['Add_Date'] .'</div>';

							echo '</div>';

						echo '</div>';
					}
					echo '</div>';
				}else{
					echo 'There\'s No Ads to show,Create <a href="newad.php">New Ad</a>';
				}
				?>
				</div>
			</div>
		</div>
	</div>

	<div class="my-comments block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"> Latest Comments </div>
				<div class="panel-body">
					<?php
					$myComments = getAllFrom("*","comments","WHERE user_id = $userid","","c_id");

					// $stmt = $conn->prepare("SELECT comment FROM comments WHERE user_id = ?");
					// $stmt ->execute(array($info['UserID']));
					// $comments = $stmt->fetchAll();

					if (!empty($myComments)){
						foreach ($myComments as $comment) {
							echo '<p>' .$comment['comment'] . '</p>';
						}

					} else {
						echo 'There\'s No Comments to show';
					}
					?>
				</div>
			</div>
		</div>
	</div>
<?php

	}else{
		header('Location:login.php');
		exit();
	}

		include $tpl.'footer.php';

?>
