<?php

$current = 'all_members.php';
//header and asside 
include_once("include/header.php");

//check if user is admin or not 
if ($_SESSION['role'] == 'admin') {
$msg = '';
//SWITCH  ban /safe
  if (isset($_GET['statusUser']) AND isset($_GET['user'])) {

     if ($_GET['user'] == '1')  {
            $msg = '<div style="text-align:center;" class="alert alert-danger" role="alert">Sorry, the Original Host can\'t be banned from comment</div>';
        }else{ 
        $sql = mysqli_query($connect,"UPDATE `users`
                                                  SET
                                                  `statusUser` = '$_GET[statusUser]'
                                                  WHERE
                                                  `user_id`    = '$_GET[user]'
          ");
            if (isset($sql)) {
              //to get updated result
              $Updateuser = mysqli_query($connect,"SELECT * FROM `users` WHERE `user_id` = '$_GET[user]'");
              $user = mysqli_fetch_assoc($Updateuser); 
            }
    }
  }


  //SWITCH Admin / writer 
   if (isset($_GET['roleId']) AND isset($_GET['user'])) {

        if ($_GET['user'] == '1') {
            $msg = '<div style="text-align:center;" class="alert alert-danger" role="alert">Sorry, the Original Host can\'t be switch to writer</div>';
        }else{

        $sql = mysqli_query($connect,"UPDATE `users`
                                                  SET
                                                  `role` = '$_GET[roleId]'
                                                  WHERE
                                                  `user_id`    = '$_GET[user]'
          ");
            if (isset($sql)) {
              //to get updated result
              $Updateuser = mysqli_query($connect,"SELECT * FROM `users` WHERE `user_id` = '$_GET[user]'");
              $user = mysqli_fetch_assoc($Updateuser); 
            }
      }
  }

//del_user
if (isset($_GET['del_user'])) {
          $check = mysqli_query($connect,"SELECT * FROM `users` WHERE `user_id` = '$_GET[del_user]'");
            if (mysqli_num_rows($check) == 0) {
                      header("location:../404.php");
            }else{
                  if ($_SESSION['role'] == 'admin') {
                        if($_GET['del_user'] == '1' OR $_SESSION['id'] != 1){
                            $msg = '<div style="text-align:center;" class="alert alert-danger" role="alert">Sorry, Your not Authorized to do that, Only The Original Host can Delete an Account </div>';
                        }else{
                        $sql = mysqli_query($connect,"DELETE FROM `users` WHERE `user_id` = '$_GET[del_user]'");
                          if (isset($sql)) {
                                      $msg = '<div style="text-align: center;" class="alert alert-success" role="alert">User Successfuly deleted</div>';
                                      echo '<meta http-equiv="refresh" content="1; \'all_members.php\'">';
                          }
                      }
                  }else{
                    header("location:../404.php");
                  }
            }
}



?>
  


 <!-- newest members  -->

  <div class="col-md-10 ">
          <?php echo $msg;?>
              <div class="panel panel-warning">
                  <div class="panel-heading" style="text-align: center;"><b class="h1">Newest members</b></div>
                      <div class="panel-body  table-responsive" style="padding: 0px; margin-top: -12px;">

            
               <table  class="table table-condensed  table-hover table-striped table-bordered ">
                      <thead>
                          <tr class="warning">
                              <th>#</th>
                              <th>Profile</th>
                              <th>username</th>
                              <th>Email</th>
                              <th>gender</th>
                              <th>role</th>
                              <th>Comment</th>
                              <th>delete</th>
                          </tr>
                      </thead>
                      <tbody>
                  <?php
                   //pagination
                                    $per_page = 5;
                                    if (!isset($_GET['page'])) {
                                      $page = 1;
                                    }else{
                                      $page = (int)$_GET['page'];
                                    }
                                    $start = ($page - 1) * $per_page;
                    //GET LATEST USERS
                    $users = mysqli_query($connect,"SELECT * FROM `users` 
                                                             ORDER BY `user_id`
                                                              DESC
                                                               LIMIT $start , $per_page"
                                                             );
                    $num = 1;
                    while($user=mysqli_fetch_assoc($users)){
                  ?>
                        <tr>
                            <td style="width: 50px;" ><?php echo $num; ?></td>
                            <td style="width: 120px;"><img src="../<?php echo $user['profile_photo'];?>" 
                                     class="img-responsive img-circle" 
                                     style="width: 100px; height: 100px;">
                            </td>
                            <td style="width: 150px;"><a href="../profile.php?userId=<?php echo $user['user_id'];?>" target="_blank"><?php echo $user['username'];?></a></td>
                            <td style="width: 180px;"><?php echo $user['email'];?></td>
                           <td style="width: 60px;"><?php echo ($user['gender'] == 'male'?
                                '<img src="../img/gender/male.png" class="img-responsive img-circle"style="width: 58px; height: 35px;"> ':
                                '<img src="../img/gender/female.png" class="img-responsive img-circle"style="width: 52px; height: 35px;"> ');?>
                             
                           </td>
    <!-- user role -->
              <?php if($user['role'] == 'writer') {?>              
                            <td style="width: 110px;"><a href="all_members.php?roleId=admin&user=<?php echo $user['user_id'].'&page='.$page;?>" class="btn btn-warning btn-xs">writer</a>
                            </td>
              <?php }else {?>
                            <td style="width: 110px;"><a href="all_members.php?roleId=writer&user=<?php echo $user['user_id'].'&page='.$page;?>" class="btn btn-success btn-xs">admin</a>
                            </td>
            <?php } ?>
    <!-- user safe to comment or ban from comment  -->
           <?php if($user['statusUser'] == 'safe'){?>               
                           <td>
                             <a href="all_members.php?statusUser=banned&user=<?php echo $user['user_id'] .'&page='.$page;?>" class="btn btn-danger btn-xs"><i class="fas fa-thumbtack"></i> Ban</a>
                           </td>
            <?php }else{?>      
                           <td>
                            <a href="all_members.php?statusUser=safe&user=<?php echo $user['user_id'] .'&page='.$page;?>" class="btn btn-success btn-xs"><i class="fas fa-check"></i> Unban</a>
                           </td>
            <?php } ?>  
                            <td style="width: 150px;"><a href="all_members.php?del_user=<?php echo $user['user_id'].'&page='.$page;?>" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a></td>

                        </tr>
                  <?php 
                      $num ++;
                    }
                  ?>      

                     
                       
                      </tbody>
               </table>
                               <!-- pagination -->
<?php
    $sql_page = mysqli_query($connect,"SELECT * FROM `users`");
    $count    = mysqli_num_rows($sql_page);
    $user     = mysqli_fetch_assoc($sql_page);
    $total    = ceil($count / $per_page);
?>

                <?php if ($count < 4) {
                      echo '';
                    }else{
                  ?>
                 <nav  class="text-center">
                        <ul class="pagination">
                          <?php 
                            for($i = 1; $i <= $total; $i++){ 
                               echo '<li '.($page == $i ?'class="active"':'').'><a href="all_members.php?page= '.$i.'" > '.$i.'</a></li>';
                               } ?>

                        </ul>
                    </nav>
                  <?php } ?>
        </div>                 
        </div>
      </div>















  </div>
</section>
<!-- footer -->
<?php
include_once("include/footer.php");
}else{
  header("location:../404.php");
}
?>