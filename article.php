<!-- 
  header 
        -->
<?php
include_once("include/header.php");
/*
 * GET [id]  ==>   Posts   
 */
$id = intval($_GET['id']);
$delMsg = ''; // when message deleted
$sql = mysqli_query($connect," SELECT * FROM `posts` p 
                                            INNER JOIN `users` u
                                                ON p.author_id = u.user_id
                                            INNER JOIN `category` c
                                                ON p.category_id = c.categoryName
                                            WHERE 
                                            `post_id` = '$id'
                                            ORDER BY 
                                            `post_id` DESC
                                        ");
$post = mysqli_fetch_assoc($sql);




/**
 * Get ALL Comments
 */
            $commentSql = mysqli_query($connect,"SELECT * FROM `comments` c
                                                INNER JOIN `users` u 
                                                ON c.com_user_id = u.user_id
                                                WHERE
                                                `com_post_id` = '$id'
                                                AND 
                                                `status` = 'published'
                                                ORDER BY `com_id` ASC               
                                                ");


//DELETE COMMENT
if (isset($_GET['delCom'])) {
        $delCom = $_GET['delCom'];
        //check if it exists
        $check = mysqli_query($connect,"SELECT * FROM `comments` WHERE `com_id` = '$delCom'");
            if (mysqli_num_rows($check) == 0) {
               header('location:404.php');
            }else{
                $com_id_delete = mysqli_fetch_assoc($check);
                if ($_SESSION['id'] == $com_id_delete['com_user_id']) {
                    $sql = mysqli_query($connect,"DELETE FROM `comments` WHERE `com_id` = '$delCom'");

                    if (isset($sql)) {
                       $delMsg = '<div class="alert alert-success" role="alert">Comment Successfuly deleted</div>';
                         echo '<meta http-equiv="refresh" content="1; \'article.php?id='.$id.' \'">';
                    }
                }
            }
        }
?>
<!-- 
      start Article 
              -->

<div class="container" style="overflow-wrap: break-word; ">
    <div class="col-xs-12">
        <div class="row">

     <!-- Cover -->
        <div class="header">
            <img style="width:100%" src="<?php echo $post['image']; ?>" /> <!--cover-->
            <div class="triangulo"></div>
            <div class="profile">
                <img style="height: 70px; width: 70px;" class="photo-author img-circle" src="<?php echo $post['profile_photo']; ?>" /> <!--profile -->
                <span class="name-author"><a style="color:#ffa500; text-transform: uppercase;" href="profile.php?userId=<?php echo $post['user_id']?>"><?php echo $post['username']; ?></a></span>
            </div>
            <h5 class="sub-title">Category:<?php echo $post['categoryName']; ?></h5> <!--Category-->
            <h2 class="title"><?php echo (strlen($post['title']) > 30 ? substr($post['title'],0, 30) . '...' : $post['title']);?></h2><!--Title-->
        </div>

        <!-- Title/date -->
        <div class="row">
            <div class="col-xs-12">
                <h4 style="line-height: 25px; font-style: italic;">
                    <span class="h4"><strong style="color: blueviolet;">TITLE: -
                    <?php echo $post['title']; ?> 
                  </strong></span>
                    <?php 
                       if(isset($_SESSION['id'])){ 
                        if($_SESSION['id'] == $post['author_id']) {?>
                        <a class="btn btn-warning btn-xs" 
                           href="edit_article.php?postId=<?php echo $post['post_id'] .'&author='.$post['author_id'];?>">
                           <i class="fas fa-edit fa-x2"></i></a>
                    <?php } }?>
                </h4>
                <h4 class="h5" style="line-height: 25px; font-style: italic;">
                   <i class="fas fa-clock"></i> 
                    <?php echo date('M j Y - g:i A', strtotime($post['post_date'])); ?> 
                </h4>
            </div>
        </div>
        <!-- post body -->
        <div class="row row-eq-height" style="">
            <div class="col-xs-10 text">
                         <?php echo $post['post']; ?>
            </div>
        </div>
   </div>
   <div class="col-md-8 col-md-offset-2" style="text-align: center;">
        <?php echo $delMsg; //message apper if comment deleted ?>        
   </div>
<!-- 
    see_comments
                  -->

 <div class="panel panel-default widget col-md-8 col-md-offset-2 ">
            <div class="panel-heading">
                <i class="fas fa-comments fa-3x"></i>
                <h3 class="panel-title">
                    Recent Comments about the Topic</h3>
                    <?php
                    //count comments
                      $count_comment = mysqli_query($connect,"SELECT `com_id` 
                                                                  FROM `comments`
                                                                    WHERE
                                                                  `com_post_id`='$id'  
                                                                  ");
                      $count = mysqli_num_rows($count_comment);
                    ?>
                <span class="label label-info">
                   <?php echo $count; ?></span>
            </div>

            <div class="panel-body">
                <ul class="list-group">
              <?php
                    //if num rows of comment is Zero
                                    if (mysqli_num_rows($commentSql) == 0) {?>
                                        <h2 class="alert alert-info" style="text-align: center;" role="alert">THERE ARE NO COMMENTS YET</h2>
              <?php }else{                      

                    while ($comment = mysqli_fetch_assoc($commentSql)) {
              ?>
                         <li class="list-group-item">
                        <div class="row">
              <!-- profile photo -->
                            <div class="col-xs-4 col-md-4 img-responsive" >
                                <img style="width: 100px; max-width: 100px; height: 100px; max-height: 100px;"
                                     src="<?php echo $comment['profile_photo'];?>"
                                     class="img-circle img-responsive"
                                     alt="<?php echo $comment['username'];?>"  />
                            </div>

                            <div class="col-xs-7 col-md-8">
                                <div>
              <!-- username -->
                                    <a href="profile.php?userId=<?php echo $comment['user_id'];?>">
                                        <?php echo $comment['username'];?>
                                     </a>
              <!-- Comment date  -->
                                    <div class="mic-info">
                                         <?php echo date('M j Y - g:i A' ,strtotime($comment['com_date']));?>
                                    </div>
                                </div>
              <!-- Comment Body  -->
                                <div class="comment-text">
                                    <?php echo $comment['comment'];?> 
                                </div>
                                <div class="action">
                        <?php 
                                //check if user id same as Session to show the Options Edit / Delete
                               if(isset($_SESSION['id'])) {
                                   if($_SESSION['id'] == $comment['com_user_id']){
                        ?>            
                                    <a href="edit_comment.php?comID=<?php echo $comment['com_id'] .'&comUser='.$comment['com_user_id'];?>" class="btn btn-primary btn-xs" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="article.php?id=<?php echo $comment['com_post_id'] .'&delCom='. $comment['com_id'];?>" class="btn btn-danger btn-xs" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                        <?php }} ?>            
                                </div>
                            </div>
                        </div>
                    </li>
                <?php }} ?>
                 
               
                </ul>
            </div>
        </div>

  <!--
    end See_comments 
                 -->



<!--
     write comment
                 -->
<?php 
/**
 * check if user isset , so user only can write
 * a comment  
 */
if(isset($_SESSION['id'])){
  /**
   * $updateuser ==> is for the purpose of 
   * getting the lastest update status of user, and to check 
   * if the users SQL [statususer] is banned from comment or not
   */
   $Updateuser = mysqli_query($connect,"SELECT * FROM `users` WHERE `user_id` = '$_SESSION[id]'");
   $user = mysqli_fetch_assoc($Updateuser); 
    if($user['statusUser'] == 'safe'){
?>
<div class="container col-md-12">
  <div class="row">
    <b class="h2" style="color: #d40b0bcf;">Write a Comment</b>
  </div>
    
    <div class="row">
    
    <div class="col-md-6">
                <div class="widget-area no-padding blank">
                <div class="status-upload">
                <!-- startCommentform -->
                  <form action="controller/comment.php" method="POST" id="comments">
                    <!-- postId -->
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <!-- text -->
                    <textarea name="comment" placeholder="write a comment" ></textarea>
                    
                        <div id="com_result"></div><!--for Ajax plugin--->
                    <button type="submit" name="add_com" class="btn btn-success green"><i class="fa fa-share"></i> Add Comment</button>
                  </form>
                  <!-- endCommentForm -->
                </div>
              </div>
            </div>
    </div>
</div>

<!-- 
  endwrite comment
                 -->
        <?php 
              }else{
                 echo '<h3 style="text-align:center;" class=" col-md-8 col-md-offset-2 alert alert-danger" role="alert">Your Account has been banned from comment temporary</h3>';
              }

      }else{
 echo '<h2 style="text-align:center;" class=" col-md-8 col-md-offset-2 alert alert-warning" role="alert">You must be a member to add a comment. <a style="font-size:14px;" href="new_profile.php" target="_blank">Sign up Now</a></h2>';
}
?>

  </div>

</div>

<!-- 
    end article
               -->

 <!--
 footer 
      -->

<?php
include_once("include/footer.php");
?>