<!-- 
  header 
        -->
<?php
include_once("include/header.php");

//Purpose of the Value start with empty
$msg = '';
$post = '';
$title = '';


//if submit
    if (isset($_POST['added_post'])) {
        $title      = strip_tags($_POST['title']);
        $post       = mysqli_real_escape_string($connect,$_POST['post']);
        $category   = $_POST['category_id'];
           
        if (empty($title)){
                $msg = '<div class="alert alert-danger" role="alert">please Insert Title of the article </div>';
        
        }elseif (empty($post)){
                $msg = '<div class="alert alert-danger" role="alert">Please insert the post of the Article</div>';
        
        }elseif (empty($category)){
                $msg = '<div class="alert alert-danger" role="alert">please select one of the categories</div>';

        }elseif (strlen($title) < 5 ) {
                $msg = '<div class="alert alert-danger" role="alert">title must have at less 5 char. </div>';
            
        }elseif (strlen($title) > 30 ) {
                $msg = '<div class="alert alert-danger" role="alert">title shouldnt be so long, max char 30. </div>';

        }elseif (strlen($post) < 100) {
                $msg = '<div class="alert alert-danger" role="alert">Article must have at less 100 char.</div>';
            
        }else{

                $image    = $_FILES['image'];
                $img_name = $image['name'];
                $img_tmp  = $image['tmp_name'];
                $img_err  = $image['error'];
                $img_size = $image['size'];

                if ($img_name != '') {
                    //taking the extension name of file and make sure its lower case
                    $img_exe = explode('.',$img_name);
                    $img_exe = strtolower(end($img_exe));

                    $allow   = array('png','gif','jpg','jpeg');
                    if (in_array($img_exe,$allow)) {
                            if ($img_err === 0) {
                                if ($img_size <= 3000000) {
                                    $new_name = uniqid('post',false);
                                    $img_dir = "img/posts/" .$new_name . '.' . $img_exe;
                                    $img_db  = "img/posts/" .$new_name . '.' . $img_exe;
                                    $move    = move_uploaded_file($img_tmp, $img_dir);
                                    if ($move) {
                                        $data ="INSERT INTO `posts`
                                                       (`title`,`post`,`category_id`,`image`,`author_id`)
                                                      VALUES
                                                       ('$title','$post','$_POST[category_id]','$img_db','$_SESSION[id]')    
                                                ";    

                                         $sql = mysqli_query($connect,$data);
                                    if (isset($sql)) {
                                            $msg = "<div class=\"alert alert-success\" role=\"alert\">Article Successfully Sumbitted, waiting for Moderator to review it before it submitted to publish</div>";

                                            echo '<meta http-equiv="refresh" content="5; \'profile.php?userId='.$_SESSION['id'] .' \'">';  
                                         }
                                     }else{
                                             $msg = '<div class="alert alert-danger" role="alert">Something went wrong during the process of uploading </div>';
                                        } 
                                    }else{
                                             $msg = '<div class="alert alert-danger" role="alert">Image size must be less than 3mp </div>';
                                       }
                                   }else{
                                             $msg = '<div class="alert alert-danger" role="alert">Something went wrong during the process of uploading </div>';
                                      }
                                 }else{
                                             $msg = '<div class="alert alert-danger" role="alert">Sorry but the Image Extension is not supported at the moment </div>';
                                 }  


                        }else{ //if the image is empty/ not uploaded
                             $data ="INSERT INTO `posts`
                                       (`title`,`post`,`category_id`,`image`,`author_id`)
                                      VALUES
                                       ('$title','$post','$category','img/posts/default.jpg' ,'$_SESSION[id]')    
                                    ";    

                                         $sql = mysqli_query($connect,$data);
                                    if (isset($sql)) {
                                            $msg = "<div class=\"alert alert-success\" role=\"alert\">Article Successfully Sumbitted, waiting for Moderator to review it before it submitted to publish</div>";

                                            echo '<meta http-equiv="refresh" content="5; \'profile.php?userId='.$_SESSION['id'] .' \'">';  
                                         }
                                    }
                                }
                            }
?>


<section class="container" >
  <div class="row">
                <div class="col-lg-10">
        <div class="col-md-1"></div>
        <div class="col-md-10">
                        <div class="panel panel-default">
                <div class="panel-heading"><b class="h1"><i class="fas fa-plus-circle"></i> New Article</b></div>
                <div class="panel-body">
                    <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
            <!--TITLE-->
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-5">
                                <input type="text" value="<?php echo $title;?>" class="form-control" name="title" id="title" placeholder="Your heading">
                            </div>
                        </div>
            <!--POST-->
                        <div class="form-group">
                            <label for="post" class="col-sm-2 control-label">Article</label>
                            <div class="col-sm-10">
                                <textarea  class="form-control" name="post" id="textarea" placeholder="whats in your mind!"  rows="8" ><?php echo $post;?></textarea>
                            </div>
                        </div>
            <!--Category-->
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">category</label>
                            <div class="col-sm-4">
                                <select type="text" class="form-control"  name="category_id" id="category">
                                    <option value="">Article Category</option>
            <?php 
                $cat = mysqli_query($connect,"SELECT * FROM `category`");
                    while($category = mysqli_fetch_assoc($cat)){    
            ?>
                                    <option value="<?php echo $category['categoryName'];?>">
                                                   <?php echo $category['categoryName'];?>
                                    </option>
            <?php } ?>        
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
                                <?php echo $msg;?>
                            </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="added_post" class="btn btn-danger">Submit Article</button>
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
?>