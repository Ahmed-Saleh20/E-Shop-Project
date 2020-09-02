<?php

	/*
	 * ==================================================
	 * == Template Page
	 * ==================================================
	*/

	session_start();

	$pageTitle = "" ; 

	if(isset($_SESSION['adminName'])){

		include 'int.php';

		$do = isset($_GET['do']) ? $_GET['do'] : "manage";

		// Start Manage Page
		if ($do == 'manage'){ 

			echo 'WELCOME';

		}elseif ( $do == 'add') {


		}elseif ($do == 'insert') {
			

		}elseif ( $do == 'edit' ){ 


	    }elseif ( $do == 'update' ){ 


	    }elseif ( $do == 'delete'){


	    }elseif ( $do == 'active'){

	    
		}

 		// Start Footer

		include $tpl.'footer.php';

	}else{

		header('Location: index.php');

		exit();

	}
?>