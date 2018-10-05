<!-- 
  header 
        -->
<?php
include_once("include/header.php");
/**
 * [$comId   get comment id]
 * [$comUser get comment user]
 */
$comId   = intval($_GET['comID']);

$comUser = intval($_GET['comUser']);
$msg = '';
/**
 * make sure that user logged in and then 
 * session id must be equal User that commented 
 *                 OR 
 * SESSIOn ROLE equal Admin
 */
if(isset($_SESSION['id'])){
	if($_SESSION['id'] == $_GET['comUser'] OR $_SESSION['role'] == 'admin'){

			$sql = mysqli_query($connect,"SELECT * FROM `comments` WHERE `com_id` = '$comId'");
			if (mysqli_num_rows($sql) == 0) {
				header("location:404.php");
			}else{
				$comment = mysqli_fetch_assoc($sql);

			}

	}else{
		header("location:404.php");
	}


}else{
	header("location:404.php");
}



//isset  Comment Edit
if (isset($_POST['edit_com'])) {
  $com_edit = strip_tags($_POST['comment']);


      if (empty($com_edit)) {
         $msg = '<div class="alert alert-danger" role="alert">please insert a comment</div>';
      }else{

          $sql = mysqli_query($connect,"UPDATE `comments`
                                                   SET 
                                                   `comment` = '$com_edit'
                                                   WHERE
                                                   `com_id` = '$comId'
                                                    
                              ");
          if (isset($sql)) {
              $msg = '<div class="alert alert-success" role="alert">Comment Successfully Edited</div>';
                                echo '<meta http-equiv="refresh" content="1; \'article.php?id='.$comment['com_post_id'] .' \'">';

          }

      }
  }  
?>

<div class="container" style="overflow-wrap: break-word; min-height: 450px; ">
    <div class="col-xs-12">

<!-- 
    Edit comment
                 -->
<div class="container col-md-12">
  <div class="row">
    <b class="h2" style="color: #d40b0bcf;">Edit Comment</b>
  </div>
    
    <div class="row">
    
    <div class="col-md-6">
                <div class="widget-area no-padding blank">
                <div class="status-upload">
                <!-- startCommentform -->
                  <form action="" method="POST">
                    <!-- postId -->
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <!-- text -->
                    <textarea name="comment" placeholder="write a comment" ><?php echo $comment['comment'];?></textarea>
                    
                        <?php echo $msg;?>
                    <button type="submit" name="edit_com" class="btn btn-success green"><i class="fa fa-share"></i> Edit Comment</button>
                  </form>
                  <!-- endCommentForm -->
                </div>
              </div>
            </div>
        
    </div>
</div>
<!-- 
  end edit comment
                   -->

 </div>
</div>








<!--
 footer 
      -->

<?php
include_once("include/footer.php");
?>