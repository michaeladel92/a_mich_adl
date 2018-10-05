<?php

include_once("../include/connection.php");
session_start();

//if submitted 
if (isset($_POST['edit_post'])) {
	$id = $_POST['postId'];
    $title      = strip_tags($_POST['title']);
    $post       = mysqli_real_escape_string($connect,$_POST['post']);
    $category   = $_POST['category'];

    if (empty($title)){
        echo '<div class="alert alert-danger" role="alert">please Insert Title of the article </div>';

    }elseif (empty($post)){
        echo '<div class="alert alert-danger" role="alert">Please insert the post of the Article</div>';

    }elseif (empty($category)){
        echo '<div class="alert alert-danger" role="alert">please select one of the categories</div>';

    }elseif (strlen($title) < 5 ) {
        echo '<div class="alert alert-danger" role="alert">title must have at less 5 char. </div>';

    }elseif (strlen($title) > 30 ) {
        echo '<div class="alert alert-danger" role="alert">title shouldnt be so long, max char 30. </div>';

    }elseif (strlen($post) < 100) {
        echo '<div class="alert alert-danger" role="alert">Article must have at less 100 char.</div>';

    }else{
    	if (isset($_FILES['image'])) {
    		# code...
       		 $image    = $_FILES['image'];
	         $img_name = $image['name'];
	         $img_tmp  = $image['tmp_name'];
	         $img_err  = $image['error'];
	         $img_size = $image['size'];

        //if ($img_name != '') {
        	
            //taking the extension name of file and make sure its lower case
            $img_exe = explode('.',$img_name);
            $img_exe = strtolower(end($img_exe));

            $allow   = array('png','gif','jpg','jpeg');
            if (in_array($img_exe,$allow)) {
                if ($img_err === 0) {
                    if ($img_size <= 3000000) {
                        $new_name = uniqid('post',false);
                        $img_dir = "../img/posts/" .$new_name . '.' . $img_exe;
                        $img_db  = "img/posts/" .$new_name . '.' . $img_exe;
                        $move    = move_uploaded_file($img_tmp, $img_dir);
                        if ($move) {
                            $data ="UPDATE `posts` SET
                                                `title` = '$title',
                                                `post`  = '$post',
                                                `category_id` = '$category',
                                                `image`   = '$img_db'
                                            WHERE
                                            `post_id`   = '$id'      
                                                ";

                            $sql = mysqli_query($connect,$data);
                            if (isset($sql)) {
                                echo "<div class=\"alert alert-success\" role=\"alert\">Article Successfully Edited</div>";

                                echo '<meta http-equiv="refresh" content="3; \'article.php?id='.$id .' \'">';
                            }
                        }else{
                            echo '<div class="alert alert-danger" role="alert">Something went wrong during the process of uploading </div>';
                        }
                    }else{
                        echo '<div class="alert alert-danger" role="alert">Image size must be less than 3mp </div>';
                    }
                }else{
                    echo '<div class="alert alert-danger" role="alert">Something went wrong during the process of uploading </div>';
                }
            }else{
                echo '<div class="alert alert-danger" role="alert">Sorry but the Image Extension is not supported at the moment </div>';
            }


        }else{ //if the image is empty/ not uploaded

            $data ="UPDATE `posts` SET
                                        `title` = '$title',
                                        `post`  = '$post',
                                        `category_id` = '$category'
                                    WHERE
                                    `post_id`   = '$id'      
                                                ";

            $sql = mysqli_query($connect,$data);
            if (isset($sql)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">Article Successfully Edit</div>";

                echo '<meta http-equiv="refresh" content="3; \'article.php?id='.$id .' \'">';
            }
        }
    }
}

?>