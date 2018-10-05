<?php
session_start();
include_once ("../include/connection.php");
$id = intval($_POST['userId']);
//Take data
$getUser = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id` = '$id'");
$user = mysqli_fetch_assoc($getUser);


if (isset($_POST['update'])){
//email & user
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']);
//if empty
    if (empty($username)){
        echo  '<div class="alert alert-danger" role="alert">Insert username</div>';
    }elseif (empty($email)){
        echo  '<div class="alert alert-danger" role="alert">Insert email</div>';
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo  '<div class="alert alert-danger" role="alert">wrong email, insert right email </div>';
    } else{
//if !empty
        $sql = mysqli_query($connect,"SELECT * FROM `users` WHERE `username` = '$username' OR `email` = '$email' ");
        if (mysqli_num_rows($sql) > 0 ){
            //if the input name and email same as in database (didnt changed)
            if ($username == $user['username'] AND $email == $user['email']){

                if($_POST['password'] != '' OR $_POST['conPassword'] != ''){
                    if ($_POST['password'] != $_POST['conPassword']){
                        echo  '<div class="alert alert-danger" role="alert"> password dosent match </div>';
                    }else{ //image
                        if (isset($_FILES['profile_photo'])){
                            $password    = md5($_POST['password']);
                            $image       = $_FILES['profile_photo'];
                            $image_name  = $image['name'];
                            $image_tmp   = $image['tmp_name'];
                            $image_size  = $image['size'];
                            $image_error = $image['error'];
                            //     if ($image_name != ''){  it made an error because of Ajax we made if isset insted
                            $image_exe = explode('.',$image_name);
                            $image_exe = strtolower(end($image_exe));

                            $allowed = array('gif','png','jpg','jpeg');

                            if (in_array($image_exe, $allowed)){
                                if ($image_error == 0){
                                    if ($image_size < 3000000){
                                        $newName  = uniqid('user',false) . '.' . $image_exe;
                                        $image_dir = "../img/profile/" . $newName ;
                                        $image_db = "img/profile/" . $newName ;
                                        if (move_uploaded_file($image_tmp, $image_dir)){
                                            $updateUser = "UPDATE `users` SET 
                                                                      `password`   = '$password',
                                                                      `gender`     = '$_POST[gender]',
                                                                      `profile_photo`     = '$image_db',
                                                                      `about_user` = '$_POST[about_user]',
                                                                      `facebook`   = '$_POST[facebook]', 
                                                                      `linkdin`    = '$_POST[linkdin]', 
                                                                      `youtube`    = '$_POST[youtube]'
                                                                WHERE
                                                                      `user_id`    = '$id'       
                                                                                ";
                                            $sql =mysqli_query($connect,$updateUser);
                                            if (isset($sql)){
                                                session_unset(); // it wont destroy it , its just make it empty
                                                //when success it need tp redirect to main page
                                                $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                                //it will fetch the info in associative array
                                                $user = mysqli_fetch_assoc($user_info);
                                                $_SESSION['id']         = $user['user_id'];
                                                $_SESSION['user']       = $user['username'];
                                                $_SESSION['email']      = $user['email'];
                                                $_SESSION['gender']     = $user['gender'];
                                                $_SESSION['profile_photo']     = $user['profile_photo'];
                                                $_SESSION['about_user'] = $user['about_user'];
                                                $_SESSION['facebook']   = $user['facebook'];
                                                $_SESSION['linkdin']    = $user['linkdin'];
                                                $_SESSION['youtube']    = $user['youtube'];
                                                $_SESSION['date']       = $user['reg_date'];
                                                $_SESSION['role']       = $user['role'];

                                                echo  '<div class="alert alert-success" role="alert">profile successfully Updated </div>';
                                                echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                                            }

                                        }else{
                                            echo  '<div class="alert alert-danger" role="alert"> Something went wrong during file uploading </div>';

                                        }
                                    }else{
                                        echo  '<div class="alert alert-danger" role="alert"> maximum image size 3mp</div>';

                                    }
                                }else{
                                    echo  '<div class="alert alert-danger" role="alert"> Sorry something went wrong during uploading process </div>';

                                }

                            }else{
                                echo  '<div class="alert alert-danger" role="alert"> Image extension not supported </div>';
                            }
                        }else{ //if its empty the image
                            $updateUser = "UPDATE `users` SET 
                                                                          `password`   = '$password',
                                                                          `gender`     = '$_POST[gender]',
                                                                          `about_user` = '$_POST[about_user]',
                                                                          `facebook`   = '$_POST[facebook]', 
                                                                          `linkdin`    = '$_POST[linkdin]', 
                                                                          `youtube`    = '$_POST[youtube]' 
                                                                    WHERE
                                                                          `user_id`    = '$id'       
                                                                            ";
                            $sql =mysqli_query($connect,$updateUser);
                            if (isset($sql)){
                                session_unset(); // it wont destroy it , its just make it empty
                                //when success it need tp redirect to main page
                                $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                //it will fetch the info in associative array
                                $user = mysqli_fetch_assoc($user_info);
                                $_SESSION['id']         = $user['user_id'];
                                $_SESSION['user']       = $user['username'];
                                $_SESSION['email']      = $user['email'];
                                $_SESSION['gender']     = $user['gender'];
                                $_SESSION['profile_photo']     = $user['profile_photo'];
                                $_SESSION['about_user'] = $user['about_user'];
                                $_SESSION['facebook']   = $user['facebook'];
                                $_SESSION['linkdin']    = $user['linkdin'];
                                $_SESSION['youtube']    = $user['youtube'];
                                $_SESSION['date']       = $user['reg_date'];
                                $_SESSION['role']       = $user['role'];

                                echo  '<div class="alert alert-success" role="alert"> profile Updated successfully</div>';
                                echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                            }
                        }
                    }
                }else { // if he didnt change password
                    if (isset($_FILES['profile_photo'])){
                        $image = $_FILES['profile_photo'];
                        $image_name = $image['name'];
                        $image_tmp = $image['tmp_name'];
                        $image_size = $image['size'];
                        $image_error = $image['error'];
                        // if ($image_name != '') { if its not empty
                        $image_exe = explode('.', $image_name);
                        $image_exe = strtolower(end($image_exe));

                        $allowed = array('gif', 'png', 'jpg', 'jpeg');

                        if (in_array($image_exe, $allowed)) {
                            if ($image_error == 0) {
                                if ($image_size < 3000000) {
                                    $newName = uniqid('user', false) . '.' . $image_exe;
                                    $image_dir = "../img/profile/" . $newName;
                                    $image_db = "img/profile/" . $newName;
                                    if (move_uploaded_file($image_tmp, $image_dir)) {
                                        $updateUser = "UPDATE `users` SET 
                                                                        `gender`     = '$_POST[gender]',
                                                                        `profile_photo`     = '$image_db',
                                                                        `about_user` = '$_POST[about_user]',
                                                                        `facebook`   = '$_POST[facebook]', 
                                                                        `linkdin`    = '$_POST[linkdin]', 
                                                                        `youtube`    = '$_POST[youtube]'
                                                                        WHERE
                                                                        `user_id`    = '$id'       
";
                                        $sql = mysqli_query($connect, $updateUser);
                                        if (isset($sql)) {
                                            session_unset(); // it wont destroy it , its just make it empty
                                            //when success it need tp redirect to main page
                                            $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                            //it will fetch the info in associative array
                                            $user = mysqli_fetch_assoc($user_info);
                                            $_SESSION['id']         = $user['user_id'];
                                            $_SESSION['user']       = $user['username'];
                                            $_SESSION['email']      = $user['email'];
                                            $_SESSION['gender']     = $user['gender'];
                                            $_SESSION['profile_photo']     = $user['profile_photo'];
                                            $_SESSION['about_user'] = $user['about_user'];
                                            $_SESSION['facebook']   = $user['facebook'];
                                            $_SESSION['linkdin']    = $user['linkdin'];
                                            $_SESSION['youtube']    = $user['youtube'];
                                            $_SESSION['date']       = $user['reg_date'];
                                            $_SESSION['role']       = $user['role'];

                                            echo '<div class="alert alert-success" role="alert"> Profile updated successfully</div>';
                                            echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                                        }

                                    } else {
                                        echo '<div class="alert alert-danger" role="alert"> Someting went wrong during uploading</div>';

                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert"> maximum size image 3mp</div>';

                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert"> something went wrong during uploading  </div>';

                            }

                        } else {
                            echo '<div class="alert alert-danger" role="alert"> extension of the image not supported </div>';
                        }
                    } else { //if its empty the image
                        $updateUser = "UPDATE `users` SET 
                                                                  `gender`     = '$_POST[gender]',
                                                                  `about_user` = '$_POST[about_user]',
                                                                  `facebook`   = '$_POST[facebook]', 
                                                                  `linkdin`    = '$_POST[linkdin]', 
                                                                  `youtube`    = '$_POST[youtube]'
                                                            WHERE
                                                                  `user_id`    = '$id'       
                                                                    ";
                        $sql = mysqli_query($connect, $updateUser);
                        if (isset($sql)) {
                            session_unset(); // it wont destroy it , its just make it empty
                            //when success it need tp redirect to main page
                            $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                            //it will fetch the info in associative array
                            $user = mysqli_fetch_assoc($user_info);
                            $_SESSION['id']         = $user['user_id'];
                            $_SESSION['user']       = $user['username'];
                            $_SESSION['email']      = $user['email'];
                            $_SESSION['gender']     = $user['gender'];
                            $_SESSION['profile_photo']     = $user['profile_photo'];
                            $_SESSION['about_user'] = $user['about_user'];
                            $_SESSION['facebook']   = $user['facebook'];
                            $_SESSION['linkdin']    = $user['linkdin'];
                            $_SESSION['youtube']    = $user['youtube'];
                            $_SESSION['date']       = $user['reg_date'];
                            $_SESSION['role']       = $user['role'];

                            echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                            echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                        }

                    }
                }

            }elseif($username != $user['username'] AND $email == $user['email']){
                $sql = mysqli_query($connect,"SELECT `username` FROM `users` WHERE `username` = '$username'");
                if (mysqli_num_rows($sql) > 0){
                    echo  '<div class="alert alert-danger" role="alert">username already been taken</div>';

                }else {//ive copyed that, it is repeated
                    if($_POST['password'] != '' OR $_POST['conPassword'] != ''){
                        if ($_POST['password'] != $_POST['conPassword']){
                            echo  '<div class="alert alert-danger" role="alert"> password dosent match </div>';
                        }else{ //image
                            if (isset($_FILES['profile_photo'])){

                                $password    = md5($_POST['password']);
                                $image       = $_FILES['profile_photo'];
                                $image_name  = $image['name'];
                                $image_tmp   = $image['tmp_name'];
                                $image_size  = $image['size'];
                                $image_error = $image['error'];
                                //        if ($image_name != ''){ //if its not empty
                                $image_exe = explode('.',$image_name);
                                $image_exe = strtolower(end($image_exe));

                                $allowed = array('gif','png','jpg','jpeg');

                                if (in_array($image_exe, $allowed)){
                                    if ($image_error == 0){
                                        if ($image_size < 3000000){
                                            $newName  = uniqid('user',false) . '.' . $image_exe;
                                            $image_dir = "../img/profile/" . $newName ;
                                            $image_db = "img/profile/" . $newName ;
                                            if (move_uploaded_file($image_tmp, $image_dir)){
                                                $updateUser = "UPDATE `users` SET 
                                                                  `username`   = '$username',
                                                                  `password`   = '$password',
                                                                  `gender`     = '$_POST[gender]',
                                                                  `profile_photo`     = '$image_db',
                                                                  `about_user` = '$_POST[about_user]',
                                                                  `facebook`   = '$_POST[facebook]', 
                                                                  `linkdin`    = '$_POST[linkdin]',
                                                                  `youtube`    = '$_POST[youtube]'
                                                            WHERE
                                                                  `user_id`    = '$id'       
                                                                    ";
                                                $sql =mysqli_query($connect,$updateUser);
                                                if (isset($sql)){
                                                    echo  '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                                    echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                                                }

                                            }else{
                                                echo  '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                            }
                                        }else{
                                            echo  '<div class="alert alert-danger" role="alert"> maximum image size 3mp </div>';

                                        }
                                    }else{
                                        echo  '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                    }

                                }else{
                                    echo  '<div class="alert alert-danger" role="alert"> extension of Image not supported </div>';
                                }
                            }else{ //if its empty the image
                                $updateUser = "UPDATE `users` SET 
                                                  `username`   = '$username',
                                                  `password`   = '$password',
                                                  `gender`     = '$_POST[gender]',
                                                  `about_user` = '$_POST[about_user]',
                                                  `facebook`   = '$_POST[facebook]', 
                                                  `linkdin`    = '$_POST[linkdin]', 
                                                  `youtube`    = '$_POST[youtube]'
                                            WHERE
                                                  `user_id`    = '$id'       
                                                    ";
                                $sql =mysqli_query($connect,$updateUser);
                                if (isset($sql)){
                                    session_unset(); // it wont destroy it , its just make it empty
                                    //when success it need tp redirect to main page
                                    $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                    //it will fetch the info in associative array
                                    $user = mysqli_fetch_assoc($user_info);
                                    $_SESSION['id']         = $user['user_id'];
                                    $_SESSION['user']       = $user['username'];
                                    $_SESSION['email']      = $user['email'];
                                    $_SESSION['gender']     = $user['gender'];
                                    $_SESSION['profile_photo']     = $user['profile_photo'];
                                    $_SESSION['about_user'] = $user['about_user'];
                                    $_SESSION['facebook']   = $user['facebook'];
                                    $_SESSION['linkdin']    = $user['linkdin'];
                                    $_SESSION['youtube']    = $user['youtube'];
                                    $_SESSION['date']       = $user['reg_date'];
                                    $_SESSION['role']       = $user['role'];

                                    echo  '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                    echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                                }
                            }
                        }
                    }else { // if he didnt change password

                        if (isset($_FILES['profile_photo'])){

                            $image = $_FILES['profile_photo'];
                            $image_name = $image['name'];
                            $image_tmp = $image['tmp_name'];
                            $image_size = $image['size'];
                            $image_error = $image['error'];
                            // if ($image_name != '') { //if its not empty
                            $image_exe = explode('.', $image_name);
                            $image_exe = strtolower(end($image_exe));

                            $allowed = array('gif', 'png', 'jpg', 'jpeg');

                            if (in_array($image_exe, $allowed)) {
                                if ($image_error == 0) {
                                    if ($image_size < 3000000) {
                                        $newName = uniqid('user', false) . '.' . $image_exe;
                                        $image_dir = "../img/profile/" . $newName;
                                        $image_db = "img/profile/" . $newName;
                                        if (move_uploaded_file($image_tmp, $image_dir)) {
                                            $updateUser = "UPDATE `users` SET 
                                                      `username`   = '$username',
                                                      `gender`     = '$_POST[gender]',
                                                      `profile_photo`     = '$image_db',
                                                      `about_user` = '$_POST[about_user]',
                                                      `facebook`   = '$_POST[facebook]', 
                                                      `linkdin`    = '$_POST[linkdin]', 
                                                      `youtube`    = '$_POST[youtube]'
                                                WHERE
                                                      `user_id`    = '$id'       
                                                                                ";
                                            $sql = mysqli_query($connect, $updateUser);
                                            if (isset($sql)) {
                                                session_unset(); // it wont destroy it , its just make it empty
                                                //when success it need tp redirect to main page
                                                $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                                //it will fetch the info in associative array
                                                $user = mysqli_fetch_assoc($user_info);
                                                $_SESSION['id']         = $user['user_id'];
                                                $_SESSION['user']       = $user['username'];
                                                $_SESSION['email']      = $user['email'];
                                                $_SESSION['gender']     = $user['gender'];
                                                $_SESSION['profile_photo']     = $user['profile_photo'];
                                                $_SESSION['about_user'] = $user['about_user'];
                                                $_SESSION['facebook']   = $user['facebook'];
                                                $_SESSION['linkdin']    = $user['linkdin'];
                                                $_SESSION['youtube']    = $user['youtube'];
                                                $_SESSION['date']       = $user['reg_date'];
                                                $_SESSION['role']       = $user['role'];

                                                echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                                echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                                            }

                                        } else {
                                            echo '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert"> maximum image size 3mp </div>';

                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                }

                            } else {
                                echo '<div class="alert alert-danger" role="alert"> extension of Image not supported </div>';
                            }
                        } else { //if its empty the image
                            $updateUser = "UPDATE `users` SET 
                                              `username`   = '$username',
                                              `gender`     = '$_POST[gender]',
                                              `about_user` = '$_POST[about_user]',
                                              `facebook`   = '$_POST[facebook]', 
                                              `linkdin`    = '$_POST[linkdin]', 
                                              `youtube`    = '$_POST[youtube]'
                                        WHERE
                                              `user_id`    = '$id'       
                                                ";
                            $sql = mysqli_query($connect, $updateUser);
                            if (isset($sql)) {
                                session_unset(); // it wont destroy it , its just make it empty
                                //when success it need tp redirect to main page
                                $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                //it will fetch the info in associative array
                                $user = mysqli_fetch_assoc($user_info);
                                $_SESSION['id']         = $user['user_id'];
                                $_SESSION['user']       = $user['username'];
                                $_SESSION['email']      = $user['email'];
                                $_SESSION['gender']     = $user['gender'];
                                $_SESSION['profile_photo']     = $user['profile_photo'];
                                $_SESSION['about_user'] = $user['about_user'];
                                $_SESSION['facebook']   = $user['facebook'];
                                $_SESSION['linkdin']    = $user['linkdin'];
                                $_SESSION['youtube']    = $user['youtube'];
                                $_SESSION['date']       = $user['reg_date'];
                                $_SESSION['role']       = $user['role'];

                                echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                            }

                        }
                    }

                }


            }elseif($username == $user['username'] AND $email != $user['email']){
                $sql = mysqli_query($connect,"SELECT `email` FROM `users` WHERE `email` = '$email'");
                if (mysqli_num_rows($sql) > 0){
                    echo  '<div class="alert alert-danger" role="alert">email already been taken</div>';

                }else{ //ive copyed that, it is repeated
                    if($_POST['password'] != '' OR $_POST['conPassword'] != ''){
                        if ($_POST['password'] != $_POST['conPassword']){
                            echo  '<div class="alert alert-danger" role="alert"> password dosent match </div>';
                        }else{ //image
                            if (isset($_FILES['profile_photo'])){

                                $password    = md5($_POST['password']);
                                $image       = $_FILES['profile_photo'];
                                $image_name  = $image['name'];
                                $image_tmp   = $image['tmp_name'];
                                $image_size  = $image['size'];
                                $image_error = $image['error'];
                                //  if ($image_name != ''){ //if its not empty
                                $image_exe = explode('.',$image_name);
                                $image_exe = strtolower(end($image_exe));

                                $allowed = array('gif','png','jpg','jpeg');

                                if (in_array($image_exe, $allowed)){
                                    if ($image_error == 0){
                                        if ($image_size < 3000000){
                                            $newName  = uniqid('user',false) . '.' . $image_exe;
                                            $image_dir = "../img/profile/" . $newName ;
                                            $image_db = "img/profile/" . $newName ;
                                            if (move_uploaded_file($image_tmp, $image_dir)){
                                                $updateUser = "UPDATE `users` SET 
                                                                          `email`   = '$email',
                                                                          `password`   = '$password',
                                                                          `gender`     = '$_POST[gender]',
                                                                          `profile_photo`     = '$image_db',
                                                                          `about_user` = '$_POST[about_user]',
                                                                          `facebook`   = '$_POST[facebook]', 
                                                                          `linkdin`    = '$_POST[linkdin]', 
                                                                          `youtube`    = '$_POST[youtube]'
                                                                    WHERE
                                                                          `user_id`    = '$id'       
                                                                                            ";
                                                $sql =mysqli_query($connect,$updateUser);
                                                if (isset($sql)){
                                                    session_unset(); // it wont destroy it , its just make it empty
                                                    //when success it need tp redirect to main page
                                                    $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                                    //it will fetch the info in associative array
                                                    $user = mysqli_fetch_assoc($user_info);
                                                    $_SESSION['id']         = $user['user_id'];
                                                    $_SESSION['user']       = $user['username'];
                                                    $_SESSION['email']      = $user['email'];
                                                    $_SESSION['gender']     = $user['gender'];
                                                    $_SESSION['profile_photo']     = $user['profile_photo'];
                                                    $_SESSION['about_user'] = $user['about_user'];
                                                    $_SESSION['facebook']   = $user['facebook'];
                                                    $_SESSION['linkdin']    = $user['linkdin'];
                                                    $_SESSION['youtube']    = $user['youtube'];
                                                    $_SESSION['date']       = $user['reg_date'];
                                                    $_SESSION['role']       = $user['role'];

                                                    echo  '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                                    echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.' \'">';
                                                }

                                            }else{
                                                echo  '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                            }
                                        }else{
                                            echo  '<div class="alert alert-danger" role="alert"> maximum image size 3mp </div>';

                                        }
                                    }else{
                                        echo  '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                    }

                                }else{
                                    echo  '<div class="alert alert-danger" role="alert"> extension of Image not supported </div>';
                                }
                            }else{ //if its empty the image
                                $updateUser = "UPDATE `users` SET 
                                                  `email`   = '$email',                  
                                                  `password`   = '$password',
                                                  `gender`     = '$_POST[gender]',
                                                  `about_user` = '$_POST[about_user]',
                                                  `facebook`   = '$_POST[facebook]', 
                                                  `linkdin`    = '$_POST[linkdin]', 
                                                  `youtube`    = '$_POST[youtube]'
                                            WHERE
                                                  `user_id`    = '$id'       
                                                    ";
                                $sql =mysqli_query($connect,$updateUser);
                                if (isset($sql)){
                                    echo  '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                    echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.'\'">';
                                }
                            }
                        }
                    }else { // if he didnt change password
                        if (isset($_FILES['profile_photo'])){

                            $image = $_FILES['profile_photo'];
                            $image_name = $image['name'];
                            $image_tmp = $image['tmp_name'];
                            $image_size = $image['size'];
                            $image_error = $image['error'];
//                            if ($image_name != '') { //if its not empty
                            $image_exe = explode('.', $image_name);
                            $image_exe = strtolower(end($image_exe));

                            $allowed = array('gif', 'png', 'jpg', 'jpeg');

                            if (in_array($image_exe, $allowed)) {
                                if ($image_error == 0) {
                                    if ($image_size < 3000000) {
                                        $newName = uniqid('user', false) . '.' . $image_exe;
                                        $image_dir = "../img/profile/" . $newName;
                                        $image_db = "img/profile/" . $newName;
                                        if (move_uploaded_file($image_tmp, $image_dir)) {
                                            $updateUser = "UPDATE `users` SET 
                                                              `email`      = '$email',
                                                              `gender`     = '$_POST[gender]',
                                                              `profile_photo`     = '$image_db',
                                                              `about_user` = '$_POST[about_user]',
                                                              `facebook`   = '$_POST[facebook]', 
                                                              `linkdin`    = '$_POST[linkdin]', 
                                                              `youtube`    = '$_POST[youtube]'
                                                        WHERE
                                                              `user_id`    = '$id'       
                                                                ";
                                            $sql = mysqli_query($connect, $updateUser);
                                            if (isset($sql)) {
                                                session_unset(); // it wont destroy it , its just make it empty
                                                //when success it need tp redirect to main page
                                                $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                                //it will fetch the info in associative array
                                                $user = mysqli_fetch_assoc($user_info);
                                                $_SESSION['id']         = $user['user_id'];
                                                $_SESSION['user']       = $user['username'];
                                                $_SESSION['email']      = $user['email'];
                                                $_SESSION['gender']     = $user['gender'];
                                                $_SESSION['profile_photo']     = $user['profile_photo'];
                                                $_SESSION['about_user'] = $user['about_user'];
                                                $_SESSION['facebook']   = $user['facebook'];
                                                $_SESSION['linkdin']    = $user['linkdin'];
                                                $_SESSION['youtube']    = $user['youtube'];
                                                $_SESSION['date']       = $user['reg_date'];
                                                $_SESSION['role']       = $user['role'];

                                                echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                                echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.'\'">';
                                            }

                                        } else {
                                            echo '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert"> maximum image size 3mp </div>';

                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                }

                            } else {
                                echo '<div class="alert alert-danger" role="alert"> extension of Image not supported </div>';
                            }
                        } else { //if its empty the image
                            $updateUser = "UPDATE `users` SET 
                                              `email`      = '$email',
                                              `gender`     = '$_POST[gender]',
                                              `about_user` = '$_POST[about_user]',
                                              `facebook`   = '$_POST[facebook]', 
                                              `linkdin`    = '$_POST[linkdin]', 
                                              `youtube`    = '$_POST[youtube]' 
                                        WHERE
                                              `user_id`    = '$id'       
                                                ";
                            $sql = mysqli_query($connect, $updateUser);
                            if (isset($sql)) {
                                session_unset(); // it wont destroy it , its just make it empty
                                //when success it need tp redirect to main page
                                $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                //it will fetch the info in associative array
                                $user = mysqli_fetch_assoc($user_info);
                                $_SESSION['id']         = $user['user_id'];
                                $_SESSION['user']       = $user['username'];
                                $_SESSION['email']      = $user['email'];
                                $_SESSION['gender']     = $user['gender'];
                                $_SESSION['profile_photo']     = $user['profile_photo'];
                                $_SESSION['about_user'] = $user['about_user'];
                                $_SESSION['facebook']   = $user['facebook'];
                                $_SESSION['linkdin']    = $user['linkdin'];
                                $_SESSION['youtube']    = $user['youtube'];
                                $_SESSION['date']       = $user['reg_date'];
                                $_SESSION['role']       = $user['role'];

                                echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.'\'">';
                            }

                        }
                    }

                }

            }else{
                echo  '<div class="alert alert-danger" role="alert">username or email has been taken</div>';
            }

        }else{//end if mysqli rows  [change Name and Email that are not in database]
            if($_POST['password'] != '' OR $_POST['conPassword'] != ''){
                if ($_POST['password'] != $_POST['conPassword']){
                    echo  '<div class="alert alert-danger" role="alert"> password dosent match </div>';
                }else{ //image
                    if (isset($_FILES['profile_photo'])){

                        $password    = md5($_POST['password']);
                        $image       = $_FILES['profile_photo'];
                        $image_name  = $image['name'];
                        $image_tmp   = $image['tmp_name'];
                        $image_size  = $image['size'];
                        $image_error = $image['error'];
//                        if ($image_name != ''){ //if its not empty
                        $image_exe = explode('.',$image_name);
                        $image_exe = strtolower(end($image_exe));

                        $allowed = array('gif','png','jpg','jpeg');

                        if (in_array($image_exe, $allowed)){
                            if ($image_error == 0){
                                if ($image_size < 3000000){
                                    $newName  = uniqid('user',false) . '.' . $image_exe;
                                    $image_dir = "../img/profile/" . $newName ;
                                    $image_db = "img/profile/" . $newName ;
                                    if (move_uploaded_file($image_tmp, $image_dir)){
                                        $updateUser = "UPDATE `users` SET 
                                                          `username`   = '$username',
                                                          `email`      = '$email',
                                                          `password`   = '$password',
                                                          `gender`     = '$_POST[gender]',
                                                          `profile_photo`     = '$image_db',
                                                          `about_user` = '$_POST[about_user]',
                                                          `facebook`   = '$_POST[facebook]', 
                                                          `linkdin`    = '$_POST[linkdin]', 
                                                          `youtube`    = '$_POST[youtube]'
                                                    WHERE
                                                          `user_id`    = '$id'       
                                                            ";
                                        $sql =mysqli_query($connect,$updateUser);
                                        if (isset($sql)){
                                            session_unset(); // it wont destroy it , its just make it empty
                                            //when success it need tp redirect to main page
                                            $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                            //it will fetch the info in associative array
                                            $user = mysqli_fetch_assoc($user_info);
                                            $_SESSION['id']         = $user['user_id'];
                                            $_SESSION['user']       = $user['username'];
                                            $_SESSION['email']      = $user['email'];
                                            $_SESSION['gender']     = $user['gender'];
                                            $_SESSION['profile_photo']     = $user['profile_photo'];
                                            $_SESSION['about_user'] = $user['about_user'];
                                            $_SESSION['facebook']   = $user['facebook'];
                                            $_SESSION['linkdin']    = $user['linkdin'];
                                            $_SESSION['youtube']    = $user['youtube'];
                                            $_SESSION['date']       = $user['reg_date'];
                                            $_SESSION['role']       = $user['role'];

                                            echo  '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                            echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.'\'">';
                                        }

                                    }else{
                                        echo  '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                    }
                                }else{
                                    echo  '<div class="alert alert-danger" role="alert"> maximum image size 3mp </div>';

                                }
                            }else{
                                echo  '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                            }

                        }else{
                            echo  '<div class="alert alert-danger" role="alert"> extension of Image not supported </div>';
                        }
                    }else{ //if its empty the image
                        $updateUser = "UPDATE `users` SET 
                                          `username`   = '$username',
                                          `email`      = '$email',                  
                                          `password`   = '$password',
                                          `gender`     = '$_POST[gender]',
                                          `about_user` = '$_POST[about_user]',
                                          `facebook`   = '$_POST[facebook]', 
                                          `linkdin`    = '$_POST[linkdin]', 
                                          `youtube`    = '$_POST[youtube]'
                                    WHERE
                                          `user_id`    = '$id'       
                                            ";
                        $sql =mysqli_query($connect,$updateUser);
                        if (isset($sql)){
                            session_unset(); // it wont destroy it , its just make it empty
                            //when success it need tp redirect to main page
                            $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                            //it will fetch the info in associative array
                            $user = mysqli_fetch_assoc($user_info);
                            $_SESSION['id']         = $user['user_id'];
                            $_SESSION['user']       = $user['username'];
                            $_SESSION['email']      = $user['email'];
                            $_SESSION['gender']     = $user['gender'];
                            $_SESSION['profile_photo']     = $user['profile_photo'];
                            $_SESSION['about_user'] = $user['about_user'];
                            $_SESSION['facebook']   = $user['facebook'];
                            $_SESSION['linkdin']    = $user['linkdin'];
                            $_SESSION['youtube']    = $user['youtube'];
                            $_SESSION['date']       = $user['reg_date'];
                            $_SESSION['role']       = $user['role'];

                            echo  '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                            echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.'\'">';
                        }
                    }
                }
            }else { // if he didnt change password
                if (isset($_FILES['profile_photo'])){

                    $image = $_FILES['profile_photo'];
                    $image_name = $image['name'];
                    $image_tmp = $image['tmp_name'];
                    $image_size = $image['size'];
                    $image_error = $image['error'];
//                    if ($image_name != '') { //if its not empty
                    $image_exe = explode('.', $image_name);
                    $image_exe = strtolower(end($image_exe));

                    $allowed = array('gif', 'png', 'jpg', 'jpeg');

                    if (in_array($image_exe, $allowed)) {
                        if ($image_error == 0) {
                            if ($image_size < 3000000) {
                                $newName = uniqid('user', false) . '.' . $image_exe;
                                $image_dir = "../img/profile/" . $newName;
                                $image_db = "img/profile/" . $newName;
                                if (move_uploaded_file($image_tmp, $image_dir)) {
                                    $updateUser = "UPDATE `users` SET 
                                                          `username`   = '$username',
                                                          `email`      = '$email',
                                                          `gender`     = '$_POST[gender]',
                                                          `profile_photo`     = '$image_db',
                                                          `about_user` = '$_POST[about_user]',
                                                          `facebook`   = '$_POST[facebook]', 
                                                          `linkdin`    = '$_POST[linkdin]', 
                                                          `youtube`    = '$_POST[youtube]'
                                                    WHERE
                                                          `user_id`    = '$id'       
                                                            ";
                                    $sql = mysqli_query($connect, $updateUser);
                                    if (isset($sql)) {
                                        session_unset(); // it wont destroy it , its just make it empty
                                        //when success it need tp redirect to main page
                                        $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                                        //it will fetch the info in associative array
                                        $user = mysqli_fetch_assoc($user_info);
                                        $_SESSION['id']         = $user['user_id'];
                                        $_SESSION['user']       = $user['username'];
                                        $_SESSION['email']      = $user['email'];
                                        $_SESSION['gender']     = $user['gender'];
                                        $_SESSION['profile_photo']     = $user['profile_photo'];
                                        $_SESSION['about_user'] = $user['about_user'];
                                        $_SESSION['facebook']   = $user['facebook'];
                                        $_SESSION['linkdin']    = $user['linkdin'];
                                        $_SESSION['youtube']    = $user['youtube'];
                                        $_SESSION['date']       = $user['reg_date'];
                                        $_SESSION['role']       = $user['role'];

                                        echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                                        echo '<meta http-equiv="refresh" content="3; \'profile.php?userId= '.$id.'\'">';
                                    }

                                } else {
                                    echo '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert"> maximum image size 3mp </div>';

                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert"> Something went wrong during uploading </div>';

                        }

                    } else {
                        echo '<div class="alert alert-danger" role="alert"> extension of Image not supported </div>';
                    }
                } else { //if its empty the image
                    $updateUser = "UPDATE `users` SET 
                                             `username`   = '$username',
                                              `email`      = '$email',
                                              `gender`     = '$_POST[gender]',
                                              `about_user` = '$_POST[about_user]',
                                              `facebook`   = '$_POST[facebook]', 
                                              `linkdin`    = '$_POST[linkdin]', 
                                              `youtube`    = '$_POST[youtube]'
                                        WHERE
                                              `user_id`    = '$id'       
                                                ";
                    $sql = mysqli_query($connect, $updateUser);
                    if (isset($sql)) {
                        session_unset(); // it wont destroy it , its just make it empty
                        //when success it need tp redirect to main page
                        $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id`  = '$id'");
                        //it will fetch the info in associative array
                        $user = mysqli_fetch_assoc($user_info);
                        $_SESSION['id']         = $user['user_id'];
                        $_SESSION['user']       = $user['username'];
                        $_SESSION['email']      = $user['email'];
                        $_SESSION['gender']     = $user['gender'];
                        $_SESSION['profile_photo']     = $user['profile_photo'];
                        $_SESSION['about_user'] = $user['about_user'];
                        $_SESSION['facebook']   = $user['facebook'];
                        $_SESSION['linkdin']    = $user['linkdin'];
                        $_SESSION['youtube']    = $user['youtube'];
                        $_SESSION['date']       = $user['reg_date'];
                        $_SESSION['role']       = $user['role'];

                        echo '<div class="alert alert-success" role="alert"> profile Successfully updated </div>';
                        echo '<meta http-equiv="refresh" content="3; \'profile.php?userId='.$id.'\'">';
                    }

                }
            }



        }

    }//close tags else !empty

} else{
    header("location:../404.php");
}



