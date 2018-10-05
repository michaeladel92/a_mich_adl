<?php

//start connection
include_once("connection.php");
session_start();
ob_start();
//get * data table settings
$settings = mysqli_query($connect,"SELECT * FROM `settings`");

$setting = mysqli_fetch_assoc($settings); 

$msgErr = '';
//if set login for mobile
if (isset($_POST['login'])) {

  $user = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['username'])) ;
  $password = md5($_POST['password']);

          if (empty($_POST['username']) OR empty($_POST['password'])) {

                        $msgErr = '  <div class="alert alert-danger" style="margin-bottom: 0px; font-size:15px;" role="alert">all inputs are requied </div>';

          }elseif (strlen($user) >= 50) {
            
                       $msgErr = '<div class="alert alert-danger" style="margin-bottom: 0px; font-size:15px;" role="alert">maxlength:50 char </div>';
          
            }else{
              $sql = mysqli_query($connect, "SELECT * FROM `users` WHERE
                                            (`username` = '$user'   AND `password` = '$password')
                                                             OR
                                            (`email`   = '$user'    AND `password` = '$password')   
                                             ");
                                  if (mysqli_num_rows($sql) != 1) {
                                      $msgErr = '<div class="alert alert-danger" style="margin-bottom: 0px; font-size:15px;" role="alert">wrong username or password </div>';
                                    }else{
                                    $user = mysqli_fetch_assoc($sql);
                                    
                                    $_SESSION['id']             = $user['user_id'];
                                    $_SESSION['user']           = $user['username'];
                                    $_SESSION['email']          = $user['email'];
                                    $_SESSION['gender']         = $user['gender'];
                                    $_SESSION['profile_photo']  = $user['profile_photo'];
                                    $_SESSION['about_user']     = $user['about_user'];
                                    $_SESSION['facebook']       = $user['facebook'];
                                    $_SESSION['linkdin']        = $user['linkdin'];
                                    $_SESSION['youtube']        = $user['youtube'];
                                    $_SESSION['role']           = $user['role'];
                                    $_SESSION['statusUser']     = $user['statusUser'];

                                
                                     header("location:index.php");
                                    }
                             }
                      }
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
    <link rel="icon" type="image/png" href="img/icon/one.ico">

    <!-- Bootstrap -->
   <!--  <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
          crossorigin="anonymous"> -->
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
          
    <link rel="stylesheet" 
          href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
          crossorigin="anonymous"><!-- fontawesome -->
    

          <!-- style -->
          <link rel="stylesheet" type="text/css" href="css/style.css">
          <link rel="stylesheet" type="text/css" href="css/responsive.css">
          
     
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
                <a href="#" class="navbar-brand"><img class="img-responsive brandName" src="img/logo/logo3.png"></a>
          </div>

          <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav navbar-right">
        
      <?php  
                      //Users setting
                    if (isset($_SESSION['id'])) {
                          $getUser = mysqli_query($connect,"SELECT * FROM `users` 
                                                                    WHERE 
                                                                    `user_id` = '$_SESSION[id]'
                                                                    ");
                            $user = mysqli_fetch_assoc($getUser);

                     ?>    

                 <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ($_SESSION['gender'] == 'male'? '<i class="fas fa-male"></i>':'<i class="fas fa-female"></i>');?>

           <?php echo $user['username'];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
             <li><a href="index.php"><i class="fas fa-home"></i> home</a></li>
            <li><a href="profile.php?userId=<?php echo $_SESSION['id'];?>"><i class="fas fa-user-circle"></i> profile</a></li>
            <li><a href="edit_profile.php?editId=<?php echo $_SESSION['id'];?>"><i class="fas fa-wrench"></i> setting</a></li>

      <?php 
                      //Admin Controls 
                    if ($_SESSION['role'] == 'admin') { ?>
            <li role="separator" class="divider"></li>
           <li class="dropdown-header"><strong style="color: #fff;">Admin Panel</strong></li>
            <li><a href="admin/index.php"><i class="fas fa-cogs"></i> Controls</a></li>
      <?php } ?>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php?id=<?php echo $_SESSION['id'];?>"><i class="fas fa-sign-out-alt"></i> log out</a></li>
          </ul>
        </li>
                   <li><a href="new_article.php"><i class="fas fa-plus-circle"></i> create</a></li>
                  <li><a href="list_article.php"><i class="fas fa-book"></i> articles</a></li>
      <?php }else { // Visitor Options ?>
                  <li><a href="index.php"><i class="fas fa-home"></i> home</a></li>
                  <li><a href="list_article.php"><i class="fas fa-book"></i> articles</a></li>
                  <!-- login form -->
                  <li class="hidden-md hidden-lg btn btn-default" style=text-decoration: none;color: #fff; text-align: left;"><a href="mobile_login.php"> <i class="fas fa-sign-in-alt"></i> login</a></li>
                                <!--large screen-->
                  <?php include_once('login.php'); ?>
                                    <!--small screen-->
                                    
                         
                        
                  <!-- end login form -->
                <?php } ?>
              </ul>
          </div>
      </div>
  </nav><!--end nav-->
<?php echo $msgErr;?>