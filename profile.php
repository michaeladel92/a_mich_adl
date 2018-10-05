<!-- 
  header 
        -->
<?php
include_once("include/header.php");

/*
 * GET userId as identifier profile 
 */
$msg= ''; //for the purpose of delete
$msgPost = ''; //if the post has zero rows 
if (isset($_GET['userId'])) {
 $id = (int)$_GET['userId'];

$user_info = mysqli_query($connect,"SELECT * FROM `users` WHERE `user_id` = '$id'");
    
      if (mysqli_num_rows($user_info) != 1) {
        header("location:404.php");
      }
 $user = mysqli_fetch_assoc($user_info);   

}



 /**
  * Get delete  as identifier of post_id
  */
 if (isset($_GET['delete'])) {
              //check first if the GET id exists
              $check = mysqli_query($connect, "SELECT * FROM `posts` WHERE `post_id` = '$_GET[delete]'");
              if (mysqli_num_rows($check) == 1) {
                    $author = mysqli_fetch_assoc($check); 
                    //make sure if current user is the same author who created arricle
                  if ($_SESSION['id'] == $author['author_id'] ) {
                      $sql = mysqli_query($connect, "DELETE FROM `posts` WHERE `post_id` = '$_GET[delete]'");
              
                         if (isset($sql)){

                                       $msg = "<div class=\"alert alert-success\" role=\"alert\">Post Successfuly deleted</div>";
                                  }
                             }else{
                                 header("location:404.php");
                             }
              
              }else{
                header("location:404.php");
              }



             
          

            }
?>

<!-- profile -->
<section class="container" >
            
         
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-1 toppad" >
        <?php echo $msg;?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><b class="h3" style="color: #d40b0b;">Welcome <?php echo ucwords($user['username']);?></b> </h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> 
            <!-- profile_photo -->
                  <img alt="<?php echo $user['username'];?>" src="<?php echo $user['profile_photo'];?>" class="img-circle img-responsive" style="width: 199px; max-width: 199px; height: 199px; max-height: 199px;"> </div>
                
                <div class=" col-md-9 col-lg-9 table-responsive"> 
                  <table class="table table-user-information">
                    <tbody>
             <!-- username -->
                      <tr>
                          <td><b>UserName:</b></td>
                          <td><?php echo strip_tags(ucwords($user['username']));?></td>
                      </tr>
              <!-- email -->
                      <tr>
                          <td><b>Email:</b></td>
                          <td><?php echo $user['email'];?></td>
                      </tr>
              <!-- gender  -->
                      <tr>
                          <td><b>Gender:</b></td>
                          <td><?php echo ($user['gender'] == 'male'? '<img src="img/gender/male.png" style="width: 50px; height:30px;" class="img-responsive">':'<img src="img/gender/female.png" style="width: 30px; height:30px;" class="img-responsive">');?></td>
                      </tr>
              <!-- role -->
                      <tr>
                        <td><b>Role:</b></td>
                        <td><?php echo $user['role'];?></td>
                      </tr>
              <!-- register date -->
                      <td><b>Registered:</b></td>
                        <td><?php echo date('M j Y - g:i A',strtotime($user['reg_date'])); ?></td>
              <!-- social network -->
                        <tr>
                        <td><b>Social:</b></td>
                        <td>
                          <a href="<?php echo $user['facebook'];?>" style="color:#3b559f;" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a> | 
                          <a href="<?php echo $user['linkdin'];?>" style="color:#005a87; " target="_blank"><i class="fab fa-linkedin-in fa-2x"></i></a> | 
                          <a href="<?php echo $user['youtube'];?>" style="color:#ff0000; " target="_blank"><i class="fab fa-youtube fa-2x"></i></a>

                        </td>
                      </tr>
              <!-- about -->
                        <td><b>About</b></td>
                        <td class="col-md-7"> <p><?php echo $user['about_user'];?></p>
                        </td>
                    </tbody>
                  </table>
              <!-- edit profile -->
        <?php 
              if(isset($_SESSION['id'])){
                if ($_SESSION['id'] == $user['user_id']) { ?>
                  <a href="edit_profile.php?editId=<?php echo $user['user_id'];?>" class="btn btn-warning"><i class="fas fa-edit">Edit profile</i></a>
        <?php }} ?>
                </div>
              </div>
            </div>
        
           
          </div>
          <!-- start post list -->
          <br><br>
            <div class="text-center">
            <p class="h1" style="background-color: #222222fa; color:#d40b0bcf; border-radius: 10px; padding:13px 0;">
              <?php 
                //statment to know if its user or visitor
              echo (isset($_SESSION['id']) == $user['user_id']? 'Articles You Posted':'Articles Posted by '.ucwords($user['username']).' ');?>
            </p>
              </div>
              <div class="panel panel-default">
                  <div class="panel-heading"><b class="h1">Articles</b></div>
                      <div class="panel-body table-responsive" style="padding: 0px; margin-top: -12px;">
               <table  class="table table-condensed table-hover table-striped table-bordered ">
                      <thead>
                          <tr class="default">
                              <th>No.</th>
                              <th>Photo</th>
                              <th>Title</th>
                              <th>watch</th>
                              <th>status</th>
                    <?php
                      if (isset($_SESSION['id'])) {
                          if ($_SESSION['id'] == $user['user_id']) {
                    ?>
                              <th>Edit</th>
                              <th>delete</th>
                    <?php
                        }
                      }
                    ?>          
                          </tr>
                      </thead>
                      <tbody>
            <?php
            //GET * POSTS user created
            //pagination
            $per_page = 5;
            if (!isset($_GET['page'])) {
              $page = 1;
            }else{
              $page = (int)$_GET['page'];
            }
            $start = ($page - 1) * $per_page;
              $getPosts = mysqli_query($connect,"SELECT * FROM `posts` 
                                                    WHERE 
                                                      `author_id` = '$user[user_id]' 
                                                      ORDER BY
                                                              `post_id`
                                                              DESC
                                                              LIMIT $start , $per_page
                                                       ");
              if (mysqli_num_rows($getPosts) == 0) {
                $msgPost = '<h1 style="text-align: center;" class="alert alert-warning" role="alert">There are No Articles made Yet</h1>';
              }
              
              $num = 1;
              while($post = mysqli_fetch_assoc($getPosts)){

            ?>            
                        <tr>
                <!-- number  -->
                            <td ><?php echo $num;?></td>
                <!-- photo  -->
                            <td><img src="<?php echo $post['image'];?>" class="img-responsive img-circle" 
                              style="width: 100px; height: 100px;">
                            </td>
                <!-- title  -->
                            <td><?php echo (strlen($post['title']) > 15 ? substr($post['title'],0, 15) . '...' : $post['title']);?></td>
                <!-- See more -->
                           <td><a href="article.php?id=<?php echo $post['post_id'];?>" class="btn btn-primary btn-xs">   <i class="far fa-eye"></i> See more</a>
                           </td>
                <!-- In Progress / Submitted  -->
            <?php if($post['status'] == 'draft'){?>               
                           <td>
                             <a class="btn btn-info btn-xs"><i class="fas fa-thumbtack"></i> Pending</a>
                           </td>
            <?php }else{?>      
                           <td>
                            <a  class="btn btn-success btn-xs"><i class="fas fa-check"></i> published</a>
                           </td>
            <?php } ?>                        
            <?php
            //show Edit / Delete for the owner of the post only
              if (isset($_SESSION['id'])) {
                  if ($_SESSION['id'] == $post['author_id']) {

              
            ?>               
                <!-- Edit  -->
                            <td>
                              <a href="edit_article.php?postId=<?php echo $post['post_id'] .'&author= '.$post['author_id'] .'&page='. $page; ?>" class="btn btn-warning btn-xs">
                                <i class="fas fa-edit"></i>  
                              </a>
                            </td>
                <!-- Delete  -->
                            <td><a href="profile.php?userId=<?php echo $post['author_id']  .'&delete='.$post['post_id'] .'&page='.$page; ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i>  </a></td>
            <?php
                  }
              }
            ?>
                        </tr>
              <?php $num++; } ?>
                       <!--     <tr >
                            <td>1</td>
                            <td style="width: 120px; max-width: 120px;"><img src="img/slide/sss.jpg" class="img-responsive img-circle" 
                              style="width: 100px; height: 100px;"></td>
                            <td>adel</td>
                             <td>post</td>
                                                         <td><a href="" class="btn btn-info btn-xs"><i class="far fa-eye"></i></a></td>

                           <td><a href="" class="btn btn-success btn-xs"><i class="fas fa-check"></i> confirm</a></td>
                            <td><a href="" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i> </a></td>
                            <td><a href="" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> </a></td>

                       </tr> -->
                       
                      </tbody>
               </table>
                <?php echo $msgPost;?>
<!-- pagination -->
<?php
    $sql_page = mysqli_query($connect,"SELECT * FROM `posts` WHERE `author_id` = '$id' ");
    $count    = mysqli_num_rows($sql_page);
    $post     = mysqli_fetch_assoc($sql_page);
    $total    = ceil($count / $per_page);
?>
                 <nav  class="text-center">
                        <ul class="pagination">
                          <?php 
                            for($i = 1; $i <= $total; $i++){ 
                               echo '<li '.($page == $i ?'class="active"':'').'><a href="profile.php?userId='.$post['author_id'].'&page= '.$i.'" > '.$i.'</a></li>';
                               } ?>

                        </ul>
                    </nav>
      </div>
    </div>
               <!-- end post list -->

        </div>

</section>
<!-- end profile -->


















<!--
 footer 
      -->

<?php
include_once("include/footer.php");
?>