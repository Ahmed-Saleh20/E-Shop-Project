<?php
	ob_start();	
	session_start();
	$pageTitle = 'Show Items';
	include "int.php";

	// Check If GET Request userid Is Numeric & GET The Integer Value Of it
	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 

	$stmt = $conn->prepare("			
					SELECT 
						items.* ,categories.Name AS Category_Name ,users.Username AS UserName 
					From 
						items
					INNER JOIN 
						categories 
					ON 
						Cat_ID = ID
					JOIN 
						users 
					ON 
						UserID = Member_ID
					WHERE
						item_ID = ?
					AND
						Approve = 1");
	$stmt->execute(array($itemid));
	$count = $stmt->rowCount();
	if ($count > 0){
	$item = $stmt->fetch();
	
?>	
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class="img-responsive img-thumbnail center-block" src="includes/images/1.jpg" alt="Item">
		</div>
		<div class="col-md-9 item-info">
			<h2><?php echo $item['Name']?></h2>
			<p><?php echo $item['Description']?></p>
			<ul class="list-unstyled">
			<li><span>Added Date:</span> <?php echo $item['Add_Date']?></li>
			<li><span>Price:</span> $<?php echo $item['Price']?></li>
			<li><span>Made In:</span> <?php echo $item['Country_Made']?></li>
			<li><span>Category:</span> <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"> <?php echo $item['Category_Name']?></li></a>
			<li><span>Add By:</span> <a href="#"> <?php echo $item['UserName']?></li></a>
			<li><span>Tags:</span> <a href="#"> 
			<?php 
				$allTags = explode(",", $item['tags']);
				foreach ($allTags as $tag) {
					$tag = str_replace(' ','',$tag);
					$lowertag = strtolower($tag);
					if(! empty($tag)){
						echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a> | ' ;	
					}
				}	
			?></li></a>
	</ul>
		</div>
	</div>
	<hr class="custom-hr">
	<?php if(isset($_SESSION['userName'])){ ?>
	<!-- Start Add Comment Section -->
	<div class="row">
		<div class="col-md-offset-3">
			<div class="add-comment">
			<h3>Add Your Comment</h3>
				<form action="<?php echo $_SERVER['PHP_SELF'] .'?itemid='.$item['item_ID']?>" method="POST">
					<textarea name="comment" required></textarea>
					<input class="btn btn-primary" type="submit" value="Add Comment">
				</form>
				<?php
					if($_SERVER['REQUEST_METHOD'] == 'POST'){
			    		$comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
			    		$itemid  = $item['item_ID'];
			    		$userid  = $_SESSION['uid'];
			    		if(! empty($comment)){
			    			$stmt = $conn->prepare("
			    				INSERT INTO
			    				comments(comment,status,comment_date,item_id,user_id)
			    				VALUES(:zcomment, 0, now(),:zitemid, :zuserid)");
			    			$stmt->execute(array(
			    				'zcomment' 	=> $comment,
			    				'zitemid' 	=> $itemid,
			    				'zuserid'	=> $userid
			    			));

			    			if ($stmt){
			    				echo '<div class="alert alert-success">Comment Added</div>';
			    			}
			    		}
					}
				?>
			</div>
		</div>
	</div>
	<!-- End Add Comment Section -->
	<?php }else{
		echo '<a href="login.php">Login</a> Or <a href="login.php">Register</a> To Add Comment.';
	} ?>
	<hr class="custom-hr">
	<?php
	//Select All Comments 
	$stmt = $conn->prepare("SELECT 
								comments.*, users.Username AS Member
							FROM
								comments 
							INNER join
							    	users
							ON
									users.UserID = comments.user_id	
							WHERE 
								item_id = ? 
							AND 
								status = 1	
							ORDER BY 
								c_id DESC											
							");

	// Execute The Statement
	$stmt -> execute(array($itemid));
	//Assign To Variable
	$comments = $stmt->fetchAll();
	?>
	<?php foreach ($comments as $comment) { ?>
	<div class="comment-box">
		<div class="row">
			<div class="col-md-2 text-center">
				<img class="img-responsive img-thumbnail img-circle center-block" src="includes/images/1.jpg" alt="" />
				<?php echo $comment['Member']?>		
			</div>
			<div class="col-md-10">
				<p class="lead"><?php echo $comment['comment']?></p>
			</div>
		</div>
	</div>
	<hr class="custom-hr">
	<?php } ?>
</div>
	
<?php
	}else{
		echo '<div class="container">';
			echo '<div class="alert alert-danger">Therr\'s no Such ID Or This Item Is Waiting Approval';
		echo '</div>';
	}
	include $tpl.'footer.php';
  	ob_end_flush();	
?>