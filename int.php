<?php


	// Error Reporting

	ini_set('display_errors','On');
	error_reporting(E_ALL);
    
    
    	include 'admin/connect.php';

    	$sessionUser = '';
    	if (isset($_SESSION['userName'])) {
    		$sessionUser = $_SESSION['userName'];
    	}

    
    // Routes
    
	    $tpl  = 'includes/templates/';  // Templates Directory
	    $lang = 'includes/languages/';  // languages Directory
	    $func = 'includes/functions/';  // Function Directory
	    $css  = 'layout/css/';          // Css Directory
	    $js   = 'layout/js/';           // js Directory
	    


    // Include The Important File

	    include $lang .  'english.php';
	    include $func .  'functions.php';
	    include $tpl  .  'header.php'; 
	

?> 