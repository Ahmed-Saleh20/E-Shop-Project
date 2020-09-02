<?php

	session_start();
	$pageTitle = 'UserLogin';
	if(isset($_SESSION['userName'])){ header('Location:index.php'); }		
	include 'int.php';

	/* Check if User Coming From HTTP Post Request */
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     	if(isset($_POST['login'])){
			$user = $_POST['username'];  
			$pass = $_POST['password']; //'password' name of input password
			$hashedPass = sha1($pass);
			// echo $user . $pass ;
					
		/* Check if The User Exist In Database*/
			$stmt = $conn->prepare("SELECT 
										UserID,Username,Password 
									FROM 
										users 
									WHERE 
										Username = ? 
									AND 
										Password = ? ");
			$stmt->execute(array($user, $hashedPass));	// execute bt3rd el data
			$get = $stmt ->fetch();
			$count = $stmt->rowCount();                     //count of number's rows that is return in DB - Flag

		/* If Count > 0 This Mean The Database Contain Record About This Username*/
	    	if ($count > 0) {
 				$_SESSION['userName'] = $user; // Register Session Name
 				$_SESSION['uid'] = $get['UserID']; // Register Session Id
 				header('Location: index.php');
 				exit();
		    }
		}else{
			$fromErrors = array();
			$username   = $_POST['username'];
			$password   = $_POST['password'];
			$password2  = $_POST['password2'];
			$email      = $_POST['email'];
			//momken abdel kole el taht bel variable 
			if (isset($_POST['username'])){

				$filterdUser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
				if(strlen($filterdUser) < 4){
					$formErrors[] = 'Username Must Be Larger Than 4 Character';
				}

			}
			if (isset($_POST['password']) && isset($_POST['password2'])){

				if (empty($_POST['password'])){
					$formErrors[] = 'Sorry Password Can\'t Be Empty';
				}

				$pass1 = sha1($_POST['password']);
				$pass2 = sha1($_POST['password2']);

				if( $pass1 !== $pass2 ){
					$formErrors[] = 'Sorry Password Is Not Match';
				}
			}  	
			if (isset($_POST['email'])){
				$filterdEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
				if(filter_var($filterdEmail, FILTER_SANITIZE_EMAIL) != true ){
					$formErrors[] = 'This Email Is Not Valid';
				}
			} 	
			// Check If There's No Error Proceed The User Add
			if (empty($formErrors)){

				//Check If User Exist in Database
				$check = checkItem("Username","users", $username);
				if($check == 1 ){
					$formErrors[] = 'Sorry This User Is Exists';
				}else {

					// Insert New User Info In Database
					$stmt = $conn->prepare("
						INSERT INTO users(Username,Password,Email,RegStatus,Date)
						VALUES(:zuser, :zpass, :zmail ,0 ,now())") ;
					$stmt->execute(array(
						'zuser' => $username,
						'zpass' => sha1($password),
						'zmail' => $email
					));

					//Echo Success Message
					$SuccessMsg = 'Congrates you Are Now Registerd User'; 		
				}
			}			 
		}    
	 }
?>

	<div class="container login-page">
		<h1 class="text-center">
			<span class="selected" data-class="login" >Login</span> |
			<span data-class="signup">Signup</span>
		</h1>
		<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
				<input class="form-control" type="text" name="username" autocomplete="off" placeholder="UserName " required />
			</div>
			<div class="input-container">
				<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password" required/>
			</div>
			<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" / >
		</form>
		<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
				<input 	
					pattern=".{4,}"
					title="Username Must Be 4 Chars" 
					class="form-control" 
					type="text" 
					name="username" 
					autocomplete="off" 
					placeholder="UserName " 
					required />

			</div>
			<div class="input-container">
				<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password" required />
			</div>
			<div class="input-container">
				<input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Password Again" required/>
			</div>
			<div class="input-container">			
				<input class="form-control" type="email" name="email" autocomplete="off" placeholder="E-Mail " required/>	
			</div>	
			<input class="btn btn-primary btn-block" name="signup" type="submit" value="Signup" / >
		</form>
		<div class="the-errors text-center">
			<?php
				if(!empty($formErrors)){
					foreach ($formErrors as $error) {
						echo $error . '<br>' ;
					}
				}
				if(isset($SuccessMsg)){
				
					echo '<div class="msg success">' . $SuccessMsg .'</div>';
					
				}
			?>	 
		</div>
	</div>	
<?php

	include $tpl .'footer.php'; 

?>