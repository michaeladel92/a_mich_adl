<?php
include_once("../include/connection.php");
session_start();

if (isset($_POST['add_com'])) {
	$comment = strip_tags($_POST['comment']);
	$postId  = intval($_POST['id']);

			if (empty($comment)) {
				 echo '<div class="alert alert-danger" role="alert">please insert a comment</div>';
			}else{

					$sql = mysqli_query($connect," INSERT INTO `comments`
																	(`com_post_id`,`com_user_id`,`comment`)
																	VALUES
																	('$postId','$_SESSION[id]','$comment')
																	");
					if (isset($sql)) {
							echo '<div class="alert alert-success" role="alert">Comment Successfully Added</div>';
                                echo '<meta http-equiv="refresh" content="1; \'article.php?id='.$postId .' \'">';

					}

			}
	}