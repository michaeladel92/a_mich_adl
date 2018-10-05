<?php

$current = 'all_articles.php';
//header and asside 
include_once("include/header.php");

//check if user is admin or not 
if ($_SESSION['role'] == 'admin') {

$msg = '';

//status controller
if (isset($_GET['status']) AND isset($_GET['post'])) {
        $sql = mysqli_query($connect,"UPDATE `posts` 
                                                      SET 
                                                        `status` = '$_GET[status]'
                                                      WHERE 
                                                        `post_id` ='$_GET[post]' 
                                                        ");
        }

//del_post
if (isset($_GET['del_post'])) {
        
            $check = mysqli_query($connect, "SELECT * FROM `posts` where `post_id` = '$_GET[del_post]'");
            if (mysqli_num_rows($check)  == 0 ) {
              header("location:../404.php");
            }else{
                   if ($_SESSION['role'] == 'admin') { 
                                //check if its original host
                                if($_SESSION['id'] == 1 AND $_SESSION['role'] == 'admin'){
                                        $sql = mysqli_query($connect,"DELETE FROM `posts` WHERE `post_id` = '$_GET[del_post]'");
                                        if (isset($sql)) {
                                         $msg = '<div style="text-align: center;" class="alert alert-success" role="alert">Post Successfuly deleted</div>';
                                              echo '<meta http-equiv="refresh" content="1; \'all_articles.php\'">';
                                            }
                                }else{
                                      $msg = '<div style="text-align: center;" class="alert alert-danger" role="alert">Sorry, Your not Authorized to delete an Article, only the Original host can do that!</div>';
                                }
                                        
               }else{
                    header("location:../404.php");
                  }
            }
      }


?>


      <!--articles list -->

          <div class="col-md-10">
            <?php echo $msg;?>
            <div class="text-center">
             
              </div>
              <div class="panel panel-warning">
                  <div class="panel-heading" style="text-align: center;"><b class="h1">Articles list</b></div>
                      <div class="panel-body table-responsive" style="padding: 0px; margin-top: -12px;">

            
               <table  class="table table-condensed  table-hover table-striped table-bordered ">
                      <thead>
                          <tr class="warning">
                              <th>#</th>
                              <th>Photo</th>
                              <th>Author</th>
                              <th>Title</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>Watch</th>
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
                          $posts = mysqli_query($connect," SELECT * FROM `posts` p 
                                                            INNER JOIN `users`u 
                                                            WHERE 
                                                              p.author_id = u.user_id
                                                              ORDER BY `post_id`
                                                              DESC
                                                              LIMIT $start , $per_page
                                                        ");
                          $num = 1;
                          if (mysqli_num_rows($posts) == 0) {
                            $msg = '<h1 style="text-align: center;" class="alert alert-danger" role="alert">There is no post available yet</h1>';
                          }
                          while($post = mysqli_fetch_assoc($posts)){
                        ?>
                        <tr >
                            <td ><?php echo $num;?></td>
                            <td><img src="../<?php echo $post['image'];?>" 
                                     class="img-responsive img-circle" 
                                     style="width: 100px; height: 100px;">
                            </td>
                            <td><a target="_blank" href="../profile.php?userId=<?php echo $post['user_id'];?>"><?php echo $post['username'];?></a></td>
                            <td><?php echo (strlen($post['title']) > 15 ? substr($post['title'],0, 15) . '...' : $post['title']);?></td>
                            <td><?php echo date('M j Y',strtotime($post['post_date']));?></td>
                            <td><a target="_blank" href="../article.php?id=<?php echo $post['post_id'];?>" class="btn btn-primary btn-xs"><i class="far fa-eye"></i> watch article</a></td>
                          
            <?php if($post['status'] == 'published'){?>               
                           <td>
                             <a href="all_articles.php?status=draft&post=<?php echo $post['post_id'] .'&page='.$page;?>" class="btn btn-info btn-xs"><i class="fas fa-thumbtack"></i> Disable</a>
                           </td>
            <?php }else{?>      
                           <td>
                            <a href="all_articles.php?status=published&post=<?php echo $post['post_id'] .'&page='.$page;?>" class="btn btn-success btn-xs"><i class="fas fa-check"></i> Publish</a>
                           </td>
            <?php } ?>    
                          
                            
                            <td><a href="all_articles.php?del_post=<?php echo $post['post_id'];?>" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></a></td>

                        </tr>
                        <?php
                          $num++;
                        }
                        ?>
                      </tbody>
               </table>
                <!-- pagination -->
<?php
    $sql_page = mysqli_query($connect,"SELECT * FROM `posts`");
    $count    = mysqli_num_rows($sql_page);
    $post     = mysqli_fetch_assoc($sql_page);
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
                               echo '<li '.($page == $i ?'class="active"':'').'><a href="all_articles.php?page= '.$i.'" > '.$i.'</a></li>';
                               } ?>

                        </ul>
                    </nav>
                          <?php } ?>
                                     <?php 
                                     //if there are no post availabe yet
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