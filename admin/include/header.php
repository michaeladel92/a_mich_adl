<?php
//start connection
include_once("connection.php");
session_start();
ob_start();

//get * data table settings
$settings = mysqli_query($connect,"SELECT * FROM `settings`");

$setting = mysqli_fetch_assoc($settings); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=  $setting['site_name'];?></title>
     <!-- 
      http://icoconvert.com[convert png image to small icon] for tab browser
      Favicon icon for your website
     -->
    <link rel="icon" type="image/png" href="../img/icon/one.ico">
    <!-- Bootstrap -->
   <!--  <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
          crossorigin="anonymous"> -->
          <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
          
    <link rel="stylesheet" 
          href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
          crossorigin="anonymous"><!-- fontawesome -->
    

          <!-- style -->
          <link rel="stylesheet" type="text/css" href="../css/style.css">
          <link rel="stylesheet" type="text/css" href="../css/responsive.css">
          
     
  </head>
  <body>
  <!-- navbar -->
  <nav class="navbar navbar-inverse">
      <div class="container-fluid">
          
          <div class="navbar-header">
              <button type="button"
                      class="navbar-toggle"
                      data-toggle="collapse"
                      data-target="#myNavbar" 
              >
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>   
                 <span class="icon-bar"></span>    
              </button>
                <a href="#" class="navbar-brand"><img class="img-responsive brandName" src="../img/logo/logo3.png"></a>
          </div>

          <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav navbar-right">
        
      <?php  
                      //Users setting
                    if (isset($_SESSION['id'])) { ?>        
                 <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ($_SESSION['gender'] == 'male'? '<i class="fas fa-male"></i>':'<i class="fas fa-female"></i>');?>

           <?php echo $_SESSION['user'];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
             <li><a href="../index.php"><i class="fas fa-home"></i> home</a></li>
            <li><a href="../profile.php?userId=<?php echo $_SESSION['id'];?>"><i class="fas fa-user-circle"></i> profile</a></li>
            <li><a href="../edit_profile.php?editId=<?php echo $_SESSION['id'];?>"><i class="fas fa-wrench"></i> setting</a></li>

      <?php 
                      //Admin Controls 
                    if ($_SESSION['role'] == 'admin') { ?>
            <li role="separator" class="divider"></li>
           <li class="dropdown-header"><strong style="color: #fff;">Admin Panel</strong></li>
            <li><a href="index.php"><i class="fas fa-cogs"></i> Controls</a></li>
      <?php } ?>
            <li role="separator" class="divider"></li>
            <li><a href="../logout.php?id=<?php echo $_SESSION['id'];?>"><i class="fas fa-sign-out-alt"></i> log out</a></li>
          </ul>
        </li>
                   <li><a href="../new_article.php"><i class="fas fa-plus-circle"></i> create</a></li>
                  <li><a href="../list_article.php"><i class="fas fa-book"></i> articles</a></li>
      <?php }else { // Visitor Options ?>
                  <li><a href="index.php"><i class="fas fa-home"></i> home</a></li>
                  <li><a href="list_article.php"><i class="fas fa-book"></i> articles</a></li>
                  <!-- login form -->
                  <?php include_once('login.php'); ?>
                  <!-- end login form -->
                <?php } ?>
              </ul>
          </div>
      </div>
  </nav><!--end nav-->
  <section class="container"  style="min-height: 450px;">
  <div class="row">
    <!-- asside -->
<aside  class="col-md-2">
    <div class="list-group">
        
        <b style="background-color: #222; color:#fff;" class="list-group-item">Controls</b>
        <a href="index.php" 
           class="list-group-item <?= ($current == 'index.php'? 'active':'')?>">
           <i class="fas fa-tachometer-alt "></i> Control Panel
        </a>
        
        <a href="setting.php" 
           class="list-group-item <?= ($current == 'setting.php'? 'active':'')?>">
           <i class="fas fa-clipboard-list"></i> setting
        </a>
        
        <a href="all_categories.php" 
           class="list-group-item <?= ($current == 'all_categories.php'? 'active':'')?>">
           <i class="fas fa-list"></i> Category
        </a>
        
        <a href="all_articles.php" 
           class="list-group-item <?= ($current == 'all_articles.php'? 'active':'')?>">
           <i class="fas fa-book"></i> Articles
        </a>
        
        <a href="all_members.php" 
           class="list-group-item <?= ($current == 'all_members.php'? 'active':'')?>">
           <i class="fas fa-users"></i> members
        </a>
        
        <a href="all_comments.php" 
           class="list-group-item <?= ($current == 'all_comments.php'? 'active':'')?>">
           <i class="fas fa-comment"></i> Comments
        </a> 
        <a href=""></a>       
    </div>
</aside>
<!--end asside -->