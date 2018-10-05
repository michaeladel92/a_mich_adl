<!-- 
  header 
        -->
<?php
include_once("include/header.php");

/**
 * [$id   ==> post_id]
 * [$user ==> author_id]
 */
$id = intval($_GET['postId']);
$user = intval($_GET['author']);
//both for Sql purpose post_id and user_id must be set or go to 404
if (isset($user) && isset($id)) {
   $sql = mysqli_query($connect,"SELECT `author_id`,`post_id` 
                                                    FROM `posts`
                                                         WHERE `author_id` = '$user'
                                                             AND 
                                                                `post_id`  = $id
                                                             ");
        if (mysqli_num_rows($sql) === 0) {
                             header("location:404.php");
                        }else{
                            $userId = mysqli_fetch_assoc($sql); 
                        }
   
                }else{
                             header("location:404.php");
                        }

/**
 * check if SESSON Equal the Author of the post, 
 */
if ($_SESSION['id'] === $userId['author_id']) {    

//get current value post
$sql = mysqli_query($connect, "SELECT * FROM `posts` WHERE `post_id` = '$id'");
$post = mysqli_fetch_assoc($sql);





?>


<section class="container" >
    <div class="row">
        <div class="col-lg-10">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading"><b class="h1"><i class="fas fa-edit"></i> Edit Article</b></div>
                    <div class="panel-body">
                        <form action="controller/edit_article.php" method="POST" class="form-horizontal" enctype="multipart/form-data" id="edit_post">
                    <!-- hidden value to get post_id  -->
                            <input type="hidden" name="postId" value="<?php echo $_GET['postId']?>">
                            <!--TITLE-->
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-5">
                                    <input type="text" value="<?php echo $post['title'];?>" class="form-control" name="title" id="title" placeholder="Your heading">
                                </div>
                            </div>
                            <!--POST-->
                            <div class="form-group">
                                <label for="post" class="col-sm-2 control-label">Article</label>
                                <div class="col-sm-10">
                                    <textarea  class="form-control" name="post" id="textarea" placeholder="whats in your mind!"  rows="8" ><?php echo $post['post'];?></textarea>
                                </div>
                            </div>
                            <!--Category-->
                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">category</label>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control" name="category" id="category">
                                        <option value="">Article Category</option>
                                        <?php
                                        //get all category 
                                        $cate = mysqli_query($connect, "SELECT * FROM `category`");
                                        while ( $category = mysqli_fetch_assoc($cate)) {

                                            ?>
                                            <option value="<?php echo $category['categoryName'];?>"
                                                <?php echo ($post['category_id'] == $category['categoryName']?'SELECTED':'');?>
                                            >
                                                <?php echo $category['categoryName'];?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <!--PICTURE-->
                            <div class="form-group">
                                <label for="image" class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-5">
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                            </div>
                            <!--Status-->
                            <!--    <div class="form-group">
                                   <label for="status" class="col-sm-2 control-label">Status</label>
                                   <div class="col-sm-3">
                                       <select class="form-control" name="status" id="status">
                                           <option value="published">Published</option>
                                           <option value="draft">Draft</option>
                                       </select>
                                   </div>
                               </div> -->
                            <div class="col-md-12" style="text-align: center;">
                                <div id="edit_result" ></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" name="edit_post" class="btn btn-danger">Edit Article</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!--
 footer 
      -->

<?php
include_once("include/footer.php");
}else{ //end if admin
header("location:404.php");
} 
?>