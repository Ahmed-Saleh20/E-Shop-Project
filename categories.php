<?php
	session_start();
	$pageTitle = 'HomePage';
	include "int.php";
?>

<div class="container">
	<!-- 		str_replace(search, replace, subject) -> bt7oel el haga el haga tania -->
	<?php
		if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
			$catid = intval($_GET['pageid']);
			$cats = $conn -> prepare("SELECT * FROM categories WHERE ID=$catid ORDER BY ID");
			$cats -> execute();
			$cat = $cats -> Fetch();
		}
	?>
	<h1 class="text-center"><?php echo $cat['Name'] ?></h1>
	<div class="row">
	<?php
		if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
			$category = intval($_GET['pageid']);
			$allItems = getAllFrom("*","items","WHERE Cat_ID = {$category}","AND Approve = 1","item_ID" );
			foreach ($allItems as $item) {
				echo '<div class="col-sm-6 col-md-3">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">' .$item['Price'] .'</span>';
					  echo '<img class="img-responsive" alt="avater" src="includes/images/'.$item['Image'].'"/>';
						echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">' .$item['Name']. '</a></h3>';
							echo '<p>' .$item['Description']. '</p>';
							echo '<div class="date">' .$item['Add_Date'] .'</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		}else{
			echo "You Must Add Page Id.";
		}
	?>
	</div>
</div>

<?php

	include $tpl.'footer.php';

?>
