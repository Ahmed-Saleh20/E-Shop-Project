<?php
	session_start();

	$noNavbar = ''; 		//That Make Navbar Not Apper Function In int.php
	$pageTitle = 'Login';

	if(isset($_SESSION['adminName'])){

	header('Location:Dashboard.php'); 		//Redirect To Admin Dashboard

	}

     // Include intialize File That Include All Includes File

		include "int.php";

	/* Check if Admin Coming From HTTP Post Request */

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$username = $_POST['user']; //'user' name of input username
			$password = $_POST['pass']; //'pass' name of input password
			$hashedPass = sha1($password);

		/* Check if The Admin Exist In Database*/

			$stmt = $conn->prepare("SELECT UserID,Username,Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1");
			$stmt->execute(array($username, $hashedPass));	// execute bt3rd el data
			$row = $stmt->fetch();	// fetch de btrga3 el data bta3et el admin ely e3ml login
			$count = $stmt->rowCount();                     //count of number's rows that is return in DB - Flag

		/* If Count > 0 This Mean The Database Contain Record About This Username*/

	    	if ($count > 0) {

 				$_SESSION['adminName'] = $username; // Register Session Name
 				//adminName -> username that login
 				$_SESSION['login_ID'] = $row['UserID']; // Register Session ID
 				//login_ID -> ID of user that login
 				header('Location: dashboard.php');

 				exit(); //tnhi 2i execute b3de7a

		    }
	 }
echo "Username: admin | Pass: 123" ;
?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

	    <h4 class="text-center">Admin Login</h4>

	    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
	    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>

	    <input class="btn btn-primary btn-block" type="submit" value="Login"/>

	</form>


<?php
include $tpl.'footer.php';

?>
