<?php
		
	session_start();
	$pageTitle = 'HomePage';
	include "int.php";
	if(isset($_SESSION['userName'])){
		
?>

<div class="container">
	<div class="row">
	<?php
		if(isset($_GET['name'])) {
			$tag = $_GET['name'];
			echo "<h1 class='text-center'>" . $tag . "</h1>";
			$tagItems = getAllFrom("*","items","WHERE tags Like '%$tag%'","AND Approve = 1","item_ID" );
			foreach ($tagItems as $item) {
				echo '<div class="col-sm-6 col-md-3">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">' .$item['Price'] .'</span>';
						echo '<img class="img-responsive" src="includes/images/1.jpg" alt="avater" />';
						echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">' .$item['Name']. '</a></h3>';
							echo '<p>' .$item['Description']. '</p>';
							echo '<div class="date">' .$item['Add_Date'] .'</div>';
						echo '</div>';	
					echo '</div>';
				echo '</div>';
			}
		}else{
			echo "You Must Enter Tag Name.";
		}
	?>
	</div>
</div>

<?php
	}else{
		header('Location:login.php');
		exit();
	}
	include $tpl.'footer.php';
    
?>