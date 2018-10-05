<!-- 
  header 
        -->
<?php
include_once("include/header.php");
  $msg='';
 
  /**
   * GET categoryName
   */
if (isset($_GET['cate'])) {
  $id = $_GET['cate'];

  
  $getPost = mysqli_query($connect," SELECT * FROM `posts` p
                                        INNER JOIN `users` u
                                        ON 
                                        p.author_id = u.user_id
                                        WHERE 
                                          `category_id` = '$id'
                                          AND
                                          `status` = 'published'
                                          ORDER BY 
                                          `post_id` DESC
                                        
                                ");
      if (mysqli_num_rows($getPost) == 0) {
        // header("location:404.php");
        $msg = '<h2 class="alert alert-warning" style="text-align:center;" role="alert">There are no Articles Available yet </h2>';
      }
}
else{
  /**
   * if categoryName [cate] not set, we take 
   * all category and show it as default
   */

  $getPost = mysqli_query($connect," SELECT * FROM `posts` p
                                        INNER JOIN `users` u
                                        ON 
                                        p.author_id = u.user_id
                                        WHERE 
                                         
                                          `status` = 'published'
                                          ORDER BY 
                                          `post_id` DESC
                                          
                                ");
      if (mysqli_num_rows($getPost) == 0) {
       // header("location:404.php");
       $msg = '<h2 class="alert alert-warning" style="text-align:center;" role="alert">There are no Articles Available yet </h2>';
      }
}


?>



<div class="container" style="min-height: 450px;">
<div class="row">
  <div class="col-md-12"> 
<!-- 
  start asside 
            -->
<aside  class="col-md-4 col-lg-3">
    <div class="list-group">
        
        <ul class="nav nav-pills nav-stacked hidden-xs hidden-sm" data-spy="affix" data-offset-top="100">
          <li>
              <b style="background-color: #222; color:#fff;" class="list-group-item">Categories</b>
          </li>
          <li>
  <!-- show ervery blogs mixture with all category -->
              <a href="list_article.php" class="btn btn-danger list-group-item "><i class="fas fa-chevron-circle-right"></i>
               ALL
              </a>
          </li>
<?php 
//show all the  categories
$sql = mysqli_query($connect, "SELECT * FROM `category` ORDER BY `cate_id` DESC");
        while($category = mysqli_fetch_assoc($sql)){
?>
          <li>
              <a href="list_article.php?cate=<?php echo $category['categoryName'];?>" 
                 class="btn btn-danger list-group-item ">
                  <i class="fas fa-chevron-circle-right"></i>
                  <?php echo $category['categoryName'];?>
              </a>
          </li>
<?php } ?>         
        </ul>
        <!-- 
          mobile xs and sm devise only 
                                  -->
         <ul class="nav nav-pills nav-stacked hidden-md hidden-lg">
          <li>
              <b style="background-color: #222; color:#fff;" class="list-group-item">Categories</b>
          </li>
          <li>
              <a href="list_article.php" class="btn btn-danger list-group-item "><i class="fas fa-chevron-circle-right"></i>
               ALL
              </a>
          </li>
<?php 
$sql = mysqli_query($connect, "SELECT * FROM `category` ORDER BY `cate_id` DESC");
        while($category = mysqli_fetch_assoc($sql)){
?>
          <li>
              <a href="list_article.php?cate=<?php echo $category['categoryName'];?>" class="btn btn-danger list-group-item "><i class="fas fa-chevron-circle-right"></i>
               <?php echo $category['categoryName'];?>
              </a>
          </li>
<?php } ?>          

        </ul>
        <!-- 
          end mobile devise
                           -->
    </div>
</aside>
<!--
    end asside
               -->


<!-- 
  categories list
                 -->

  <div class="col-md-8 col-lg-9">
    
  <?php
     echo $msg;
      while ($post = mysqli_fetch_assoc($getPost)) {
      
  ?>        
             <div class="well">
              <div class="media">
     <!--post Image  -->
                <a class="pull-left img-responsive" href="#">
                  <img class="media-object img-circle" 
                       style="height: 150px; width: 150px;" 
                       src="<?php echo $post['image'];?>">
                </a>
              <div class="media-body" style="word-wrap: break-word;">
      <!--Post title  -->
                <b class=" h2 media-heading"><?php echo strip_tags($post['title']);?> </b>
                  <p class="text-right"><strong>By:
      <!--Post username  -->
                    <a href="profile.php?userId=<?php echo $post['user_id']?>">
                                    <?php echo $post['username'];?>
                    </a></strong>
                  </p>  
      <!-- post body large screen  -->
                  <div class="visible-lg"style="width: 624px; " >
                    <p><?php 
                 
                  echo substr(strip_tags($post['post']), 0,400);

                  ?>...</p>  
                  </div>
      <!-- post body md/sm/xs screen  -->          
                       <!--start mobile devise -->
                   <div class=" hidden-lg"style="width: 300px; " >
                    <p><?php 
                 
                  echo substr(strip_tags($post['post']), 0,250);

                  ?>...</p>  
                  </div>
                      <!--end mobile devise  -->
                  
                  <ul class="list-inline list-unstyled">
                          <li>
                              <span><i class="fas fa-clock"></i>
                           <?php echo  date('M j Y g:i A' ,strtotime($post['post_date']));?> 
                              </span>
                          </li>
                    <li>|</li>
                    <?php
                      //get number of comments in post
                      $comments = mysqli_query($connect,"SELECT * FROM 
                                                        `comments`
                                                         WHERE 
                                                        `com_post_id` = '$post[post_id]'
                                                        ");
                      $numComment = mysqli_num_rows($comments);
                    ?>
      <!-- Total comments number -->
                    <span><i class="fas fa-comment"></i> <?php echo $numComment;?> comments</span>
      <!-- read more  -->
                    <li class="pull-right">
                        <a href="article.php?id=<?php echo $post['post_id'];?>" 
                           type="button" 
                           class="btn btn-danger btn-sm">
                           Read more
                        </a>
                    </li>
              </ul>
               </div>
            </div>
          </div>
    <?php }?>    

  
<!--  <div class="pagination-wrap">
        <ul class="pagination pagination-v4">
          <li><a href="#">Previous</a></li>
          <li><a href="#">1</a></li>
          <li><a class="active" href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">----</a></li>
          <li><a href="#">Next</a></li>
        </ul>
      </div> -->
<!-- end pagination -->
       </div>
       </div>
  </div>
</div>

    



<!--
 footer 
      -->

<?php
include_once("include/footer.php");
?>