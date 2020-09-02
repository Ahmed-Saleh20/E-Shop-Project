<?php

	/*
	** Get All Function v2.0
	** Function To Get All Records From Any Database Table 
	*/

	function getAllFrom($field,$table,$where = NULL,$and = NULL ,$orderfield,$ordering = "DESC" ){

		global $conn;

		$getAll = $conn -> prepare("SELECT $field FROM $table  $where $and ORDER BY $orderfield $ordering");

		$getAll -> execute();
		
		$all = $getAll -> FetchAll();

		return $all;

	}


	// /*
	// ** Get All Function v1.0
	// ** Function To Get All Records From Any Database Table 
	// */

	// function getAllFrom($tableName,$orderBy,$where = NULL ){

	// 	global $conn;

	// 	$sql = $where == NULL ? '' : $where ;

	// 	$getAll = $conn -> prepare("SELECT * FROM $tableName $sql ORDER BY $orderBy DESC");

	// 	$getAll -> execute();
		
	// 	$all = $getAll -> FetchAll();

	// 	return $all;

	// }


	// Replace with getAllFrom($field,$table,$where = NULL,$and = NULL ,$orderfield,$ordering = "DESC" )
	/*
	** Get Records Function v1.0
	** Function To Get Categories From Database
	** 
	*/

	// function getCat(){

	// 	global $conn;

	// 	$getCat = $conn -> prepare("SELECT * FROM categories ORDER BY ID ASC ");

	// 	$getCat -> execute();
		
	// 	$cats = $getCat -> FetchAll();

	// 	return $cats;

	// }

	// Replace with getAllFrom($field,$table,$where = NULL,$and = NULL ,$orderfield,$ordering = "DESC" )
	/*
	** Get AD Records Function v1.0
	** Function To Get AD Items From Database
	** 
	*/

	// function getItems($where,$value,$approve = NULL){

	// 	global $conn;

	// 	if ($approve == NULL){
	// 		$sql = 'AND Approve = 1';
	// 	}else{
	// 		$sql = NULL;
	// 	}

	// 	$getItems = $conn -> prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY item_ID DESC ");

	// 	$getItems -> execute(array($value));
		
	// 	$items = $getItems -> FetchAll();

	// 	return $items;

	// }

	/*
	**
	** Check If User Is Not Active v1.0
	** Function To Check The RegStatus Of The User
	**
	*/

	function checkUserStatus($user){

		global $conn;

		$stmtx = $conn->prepare("SELECT 
									Username,RegStatus 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									RegStatus  = 0 ");

		$stmtx->execute(array($user));	

		$status = $stmtx->rowCount();

		return $status;           

	}


	/*
	** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parmeters ]
	** $select = The Item To Select [ Example: username, item, category ] iN DATABASE
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: Ahmed, Box, Electronics ]
	*/

	function checkItem($select,$from,$value){

		global $conn ;

		$statement = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count ;
	}






























	/***********************************************************/

    /*
	* 	
	* This File Include The Global Function Of Website That Uses
	*
	*/

	/* 
	** Title Function V0.1
	**
	*/

    // Title Function That Echo The Page Title In Case The Page Has The Variable $PageTitle And Echo Defult Title For Other Pages Which Make Denamic Title That Changing Automatic In Every Page

		function getTitle(){

			global $pageTitle ;

			if (isset($pageTitle)){  // IF The Page Include Variable Named '$pageTitle' Make it The Title Of Page

				echo $pageTitle;
			}else{

				echo 'Default Title';
			}
		}

		// /*
		// ** Home Redirect Function v1.0
		// ** This Function Accept Parameters
		// ** $errorMsg = Echo The Error Message 
		// ** $seconds = seconds Before Redirecting
		// */

		// function redirectHome($errorMsg, $seconds = 3){

		// 	echo "<div class='alert alert-danger'>$errorMsg</div> ";
		// 	echo "<div class='alert alert-info'>You Will Be Redirected to Homepage After $seconds Seconds.</div>";
		// 	header("refresh:$seconds;url=index.php");//used refresh bdal location 3lshan el Dilay el h3mlo Abl EL Redirecting

		// 	exit(); //3lshan menfzsh aeh haga tani b3d el header
		// }
		
		/*
		** Home Redirect Function v2.0
		** This Function Accept Parameters
		** $theMsg = Echo The Message  [ Error | Success | Warning ]
		** $url = The Link You Want To Redirect To
		** $seconds = seconds Before Redirecting
		*/ 

		function redirectHome( $theMsg, $url= null, $seconds = 3 ){

			if ($url === null){

				$url = 'index.php';
				$link = 'Homepage';

			}else{

				if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

					$url = $_SERVER['HTTP_REFERER'];
					$link = 'Previous Page';

				}else{

					$url = 'index.php';
				 	$link = 'Homepage';

				}
			}
			echo $theMsg ;

			echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";

			header("refresh:$seconds;url=$url");

		    exit(); 
		}



		/*
		** Count Number Of Items Function v1.0
		** Function To Count Number Of Items Rows
		** $item = The Item To Count
		** $table = The Table To Choose From
		*/

		function countItems($item, $table){

			global $conn ;

			$stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table");

			$stmt2 -> execute();

			return $stmt2->fetchColumn();

		}

		/*
		** Get Latest Records Function v1.0
		** Function To Get Latest Items From Database [ Users , Items , Comments ]
		** $select = Faild To Select
		** $table  = The table to Choose Form 
		** $order  = The Ordering by
		** $limit  = Number Of Records To Get
		*/

		function getLatest( $select, $table, $order, $limit = 5 ){

			global $conn;

			$getStmt = $conn ->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

			$getStmt -> execute();
			$rows = $getStmt -> FetchAll();
			return $rows;

		}

?>