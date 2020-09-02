


	<!--This File Include Head Part icludes CSS & Font-Awesome File-->

<!DOCTYPE html>
<html>
	<!-- Start Head -->
	<head>
		<meta charset="UTF-8"/>
		<title><?php getTitle()?></title>
        <link rel="stylesheet" href="layout/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="layout/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="layout/css/front.css"/>
	</head>
	<!-- End Head -->
	<body>
    <div class="upper-bar">
      <div class="container">
        <?php if (isset($_SESSION['userName'])){ ?>
				<div class='pull-right'>	
	        <img class="my-image img-thumbnail img-circle" src="includes/images/1.jpg" alt="" />
	        <div class="btn-group my-info">
	            <span class="btn dropdown-toggle" data-toggle="dropdown">
	                <?php echo $_SESSION['userName'] ?>
	                <span class="caret"></span>
	            </span>
	            <ul class="dropdown-menu">
	              <li><a href="profile.php">My Profile</a></li>
	              <li><a href="newad.php">New Item</a></li>
	              <li><a href="profile.php#my-ads">My Items</a></li>
	              <li><a href="logout.php">Logout</a></li>
	            </ul>
	        </div>
			  </div>
        <?php }else{
          echo "<a href='login.php'><span class='pull-right'>Login | Signup</span></a>";
        }?>
      </div>
    </div>

    <nav class="navbar navbar-inverse">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">E-Shop</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="app-nav">

          <ul class="nav navbar-nav navbar-right">
            <?php
              $allCats = getAllFrom("*","categories","WHERE parent = 0","","ID","ASC" );
              foreach ( $allCats as $cat) {
                echo '<li><a href="categories.php?pageid='.$cat['ID'].'">' .$cat['Name'] . '</a></li>';
              }
            ?>
          </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
