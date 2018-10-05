<?php
//check if user is admin or not 
$current = 'index.php';
include_once("include/header.php");
if ($_SESSION['role'] == 'admin') {

$msg = '';
//Get total posts
$posts = mysqli_query($connect,"SELECT * FROM `posts`");
$post  =mysqli_num_rows($posts);

//Get total users
$users = mysqli_query($connect,"SELECT * FROM `users`");
$user  = mysqli_num_rows($users);


//Get total comments
$comments = mysqli_query($connect,"SELECT * FROM `comments`");
$comment  = mysqli_num_rows($comments);
?>
<!-- control panel -->

<!-- Number blogs -->

          <div class="col-md-3">
                     <div class="panel panel-warning">
                         <div class="panel-heading">blogs</div>
                         <div class="panel-body">
                             <div class="col-md-8">
                                 <i class="far fa-list-alt fa-5x" style="color: #8a6d3b;"></i>
                             </div>
                             <div class="col-md-4">
                                 <h1 style="font-weight: bolder; font-size:50px;"><?php echo $post;?></h1>
                             </div>
                         </div>
                         <div class="panel-footer text-center"> <i class="far fa-eye"> </i> <a href="all_articles.php"><b>list</b></a> </div>
                     </div>
                 </div>
<!--Comments-->
                 <div class="col-md-3">
                     <div class="panel panel-success">
                         <div class="panel-heading">total comments</div>
                         <div class="panel-body">
                             <div class="col-md-8">
                                 <i class="fas fa-comments fa-5x" style="color:#3c763db3; "></i>
                             </div>
                             <div class="col-md-4">
                                <h1 style="font-weight: bolder; font-size:50px;"><?php echo $comment;?></h1>
                             </div>
                         </div>
                         <div class="panel-footer text-center"> <i class="far fa-eye"> </i> <a href="all_comments.php"><b>list</b></a> </div>
                     </div>
                 </div>
<!--Members-->
                 <div class="col-md-3">
                     <div class="panel panel-danger">
                         <div class="panel-heading">Members</div>
                         <div class="panel-body">
                             <div class="col-md-8">
                                 <i class="fas fa-users fa-5x" style="color:#7d2220d9; "></i>
                             </div>
                             <div class="col-md-4">
                               <h1 style="font-weight: bolder; font-size:50px;"><?php echo $user;?></h1>

                             </div>
                         </div>
                         <div class="panel-footer text-center"> <i class="far fa-eye"> </i> <a href="all_members.php"><b>list</b></a> </div>
                     </div>
                 </div>

      <!-- lastest post -->

          <div class="col-md-10">
            <?php echo $msg;?>
            <div class="text-center">
             
              </div>
              <div class="panel panel-warning">
                  <div class="panel-heading" style="text-align: center;"><b class="h1">lastest post</b></div>
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
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                          $posts = mysqli_query($connect," SELECT * FROM `posts` p 
                                                            INNER JOIN `users`u 
                                                            WHERE 
                                                              p.author_id = u.user_id
                                                              ORDER BY `post_id`
                                                              DESC
                                                              LIMIT 5
                                                        ");
                             if (mysqli_num_rows($posts) == 0) {
                            $msg = '<h1 style="text-align: center;" class="alert alert-danger" role="alert">There is no post available yet</h1>';
                          }
                          $num = 1;
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
                          
            <?php if($post['status'] == 'draft'){?>               
                           <td>
                             <a href="all_articles.php" class="btn btn-info btn-xs"><i class="fas fa-thumbtack"></i> Pending</a>
                           </td>
            <?php }else{?>      
                           <td>
                            <a href="all_articles.php" class="btn btn-success btn-xs"><i class="fas fa-check"></i> published</a>
                           </td>
            <?php } ?>    

                        </tr>
                        <?php
                          $num++;
                        }
                        ?>
                      </tbody>
               </table>
                <?php 
                                     //if there are no post availabe yet
                                     echo $msg;

                                     ?> 
        </div>                 
     </div>
  </div>


<!-- newest members  -->

  <div class="col-md-10 col-md-offset-2">
          
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
                          </tr>
                      </thead>
                      <tbody>
                  <?php
                    //GET LATEST USERS
                    $users = mysqli_query($connect,"SELECT * FROM `users`  ORDER BY `user_id` DESC LIMIT 5");
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
                            <td style="width: 110px;"><a href="" class="btn btn-info btn-xs"><?php echo $user['role'];?></a></td>
                        </tr>
                  <?php 
                      $num ++;
                    }
                  ?>              
                      </tbody>
               </table>
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