<?php

/*

	Categories -> [ Manage | Edit | Update | Add | Delete | Stats ]

	condition ? True : False

	'do' momkn tt8er le 'action' aw ei haga tania

*/

	//	$do = isset($_GET['do']) ? $_GET['do'] : "Manage";

		$do = '';

		if ( isset( $_GET['do'] ) ) {

			$do = $_GET['do'];

		} else {

			$do = 'Manage';
		}

   // If The Page Is Main Page 

		if ($do == 'Manage'){

			echo 'Welcome You Are In Manage Category Page';
			echo '</br> <a href="page.php?do=add"> Add New Category </a>';
		//	echo '</br> <a href="?do=add"> Add New Category </a>'; //hea hea

		} elseif ($do == 'add') {

				echo 'Welcome You Are In Add Category Page';

		}elseif ($do == 'edit') {

				echo 'Welcome You Are In Edit Category Page';

		}else{
			echo 'Error 404 :Page Not Found ';
		}

?>s