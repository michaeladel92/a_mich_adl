<?php
$current = 'all_comments.php';
//header and asside 
include_once("include/header.php");

//check if user is admin or not 
if ($_SESSION['role'] == 'admin') {
  $msg = '';
  $delMsg = '';


  //DELETE COMMENT
if (isset($_GET['delCom'])) {
        $delCom = $_GET['delCom'];
        //check if it exists
        $check = mysqli_query($connect,"SELECT * FROM `comments` WHERE `com_id` = '$delCom'");
            if (mysqli_num_rows($check) == 0) {
               header('location:../404.php');
            }else{
                    //check if its Original Admin or NO 
                    if ($_SESSION['id'] == 1 AND $_SESSION['role'] == 'admin') {
                                $sql = mysqli_query($connect,"DELETE FROM `comments` WHERE `com_id` = '$delCom'");

                                  if (isset($sql)) {
                                     $delMsg = '<div class="alert alert-success" role="alert">Comment Successfuly deleted</div>';
                                       echo '<meta http-equiv="refresh" content="1; \'all_comments.php\'">';
                                  }
                          }else{
                            $delMsg = '<div class="alert alert-danger" role="alert">Comments can be deleted by Original Host Only!</div>';
                          }
                  
                
            }
}
?>
  


 <!-- lastest post -->
          <div class="col-md-10">
            <div class="text-center">
             <?php echo $delMsg;?>
              </div>
              <div class="panel panel-warning">
                  <div class="panel-heading" style="text-align: center;"><b class="h1">Comments</b></div>
                      <div class="panel-body table-responsive" style="padding: 0px; margin-top: -12px;">

            
               <table  class="table table-condensed  table-hover table-striped table-bordered ">
                      <thead>
                          <tr class="warning">
                              <th>#</th>
                              <th>User</th>
                              <th>Comment</th>
                              <th>View</th>
                              <th>Edit</th>
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
                        //get comments
                          $sql = mysqli_query($connect,"SELECT * FROM `comments` c
                                                          INNER JOIN `users` u
                                                           ON c.com_user_id = u.user_id
                                                           INNER JOIN `posts` p 
                                                           ON c.com_post_id = p.post_id
                                                           ORDER BY 
                                                           `com_id` DESC
                                                            LIMIT $start , $per_page
                                                                 ");
                             if (mysqli_num_rows($sql) == 0) {
                                $msg = '<h1 style="text-align: center;" class="alert alert-danger" role="alert">There is no Comments Written yet</h1>';
                             }else{
                             $num = 1;
                             while($comment = mysqli_fetch_assoc($sql)){

                        ?>
                        <tr >
                            <td style="width: 40px;" ><?php echo $num;?></td>
          <!--username  -->
                            <td style="width: 80px;">
                                  <a href="../profile.php?userId=<?php echo $comment['user_id'];?>">
                                    <?php echo $comment['username'];?>
                                  </a>
                            </td>
          <!-- comment -->
                           <td>
                             <p><?php echo (strlen($comment['comment']) < 99?
                              ''.strip_tags($comment['comment']).'':
                              ''.substr(strip_tags($comment['comment']), 0,100).'...'); ?>
                             </p>
                           </td>
          <!-- watch article -->
                            <td style="width: 70px;">
                                <a href="../article.php?id=<?php echo $comment['post_id'];?>" 
                                   class="btn btn-info btn-xs">
                                   <i class="far fa-eye"></i>
                                    View article
                                </a>
                            </td>
          <!-- Edit  -->
                            <td style="width: 70px;">
                              <a href="../edit_comment.php?comID=<?php echo $comment['com_id']
                                      .'&comUser='.$comment['user_id'] .'&page='. $page;?>"
                                 class="btn btn-warning btn-xs">
                                   <i class="fas fa-edit"></i> 
                              </a>
                            </td>
          <!-- Delete  -->
                            <td style="width: 70px;">
                               <a href="all_comments.php?delCom=<?php echo $comment['com_id'] .'&page='. $page;?>" 
                                  class="btn btn-danger btn-xs">
                                  <i class="fas fa-trash"></i>
                               </a>
                            </td>

                        </tr>

                     <?php
                        $num++;
                      }}
                     ?>
                       
                      </tbody>
               </table>
                <!-- pagination -->
<?php
    $sql_page = mysqli_query($connect,"SELECT * FROM `comments`");
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
                               echo '<li '.($page == $i ?'class="active"':'').'><a href="all_comments.php?page= '.$i.'" > '.$i.'</a></li>';
                               } ?>

                        </ul>
                    </nav>
                  <?php } ?>
                <?php 
                                     //if there are no comments availabe yet
                                     echo $msg;

                                     ?> 
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