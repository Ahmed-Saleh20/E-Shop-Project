


      <!--This File Include Footer Part icludes jequery & Bootstrap icluding-->



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
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('Home_Admin')?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">

      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('Categories_Admin')?></a></li>
        <li><a href="items.php"><?php echo lang('Items_Admin')?></a></li>
        <li><a href="members.php"><?php echo lang('Members_Admin')?></a></li>
        <li><a href="#"><?php echo lang('Statistics_Admin')?></a></li>
        <li><a href="comments.php"><?php echo lang('Comments_Admin')?></a></li>
        <li><a href="#"><?php echo lang('Logs_Admin')?></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php"><?php echo lang('Shop_Admin')?></a></li>
            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['login_ID'] ?>"><?php echo lang('EditProfile_Admin')?></a></li>
            <li><a href="#"><?php echo lang('Setting_Admin')?></a></li>
            <li><a href="logout.php"><?php echo lang('Logout_Admin')?></a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
