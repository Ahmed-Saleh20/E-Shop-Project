<?php
	ob_start();
	session_start();
	$pageTitle = 'HomePage';
	include "int.php";
?>

<div class="container">
	<div class="row">
		<h1>Welcome To EC Shop</h1>
	<?php
		$allItems = getAllFrom('*','items','WHERE Approve = 1','','item_ID');
		foreach ($allItems as $item) {
			echo '<div class="col-sm-6 col-md-3">';
				echo '<div class="thumbnail item-box">';
					echo '<span class="price-tag">$' .$item['Price'] .'</span>';
					echo '<img class="img-responsive" alt="avater" src="includes/images/'.$item['Image'].'"/>';
					echo '<div class="caption">';
						echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">' .$item['Name']. '</a></h3>';
						echo '<p>' .$item['Description']. '</p>';
						echo '<div class="date">' .$item['Add_Date'] .'</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	?>
	</div>
</div>

<?php
		include $tpl.'footer.php';
		ob_end_flush();
?>
