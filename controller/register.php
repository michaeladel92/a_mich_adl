<?php
//connect database
include_once("../include/connection.php");
/**
 * This page take Action when button @new_profile.php
 * submitted
 */
session_start();
if (isset($_POST['register'])) {

					//pull_inputs
					$username 		= strip_tags($_POST['username']);
					$email 	  		= $_POST['email'];
					$password 		= md5($_POST['password']);
					$gender   		= $_POST['gender'];
					$about_user 	= strip_tags($_POST['about_user']);
					$facebook		= htmlspecialchars($_POST['facebook']);
					$linkdin		= htmlspecialchars($_POST['linkdin']);	
					$youtube		= htmlspecialchars($_POST['youtube']);

					if(empty($username)){//username & email
						echo '<div class="alert alert-danger" role="alert">Insert username</div>';
					}elseif (empty($email)) {
						echo '<div class="alert alert-danger" role="alert">Insert email</div>';
						
					}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						echo '<div class="alert alert-danger" role="alert">please insert right email</div>';
				
					}

					elseif (empty($_POST['password'])) { //password
						echo '<div class="alert alert-danger" role="alert">Insert password</div>';
						
					}elseif (empty($_POST['conPassword'])) {
						echo '<div class="alert alert-danger" role="alert">Insert confirm password </div>';
						
					}elseif ($_POST['password'] != $_POST['conPassword']) {
						echo '<div class="alert alert-danger" role="alert">password dosent match </div>';

					}

	else{
		//check if the username & password already in database 
		
		$sql_username = mysqli_query($connect, " SELECT `username` 
												     FROM `users`
												     	WHERE
												     	`username` = '$username'

								    ");
		$sql_email    = mysqli_query($connect, "SELECT `email` 
													FROM `users`
													   WHERE 
													   `email` = '$email'");

			if (mysqli_num_rows($sql_username) > 0) {
				echo '<div class="alert alert-danger" role="alert">user name already taken </div>';
			}elseif (mysqli_num_rows($sql_email) > 0) {
				echo '<div class="alert alert-danger" role="alert">email already taken </div>';
				
				}else{
					
						if (isset($_FILES['profile_photo'])) { //if uploaded image
												$image     = $_FILES['profile_photo'];
												$img_name  = $image['name'];
												$img_tmp   = $image['tmp_name'];
												$img_err   = $image['error'];
												$img_size  = $image['size'];

												$img_exe   = explode('.',$img_name);
												$img_exe   = strtolower(end($img_exe));

												$allow     = array('png','gif','jpg','jpeg');	
									if (in_array($img_exe, $allow)) {
											if($img_err === 0){
												if ($img_size <= 3000000) {

													   $new_name = uniqid('users',false);
													   $img_dir  = "../img/profile/". $new_name . '.' . $img_exe;
													   $img_db   = "img/profile/". $new_name . '.' . $img_exe;
													
												       $move_file = move_uploaded_file($img_tmp , $img_dir);
												    if ($move_file) {
												       	   $insert = "INSERT INTO `users`(
																							`username`,
																							`email`,
																							`password`,
																							`gender`,
																							`profile_photo`,
																							`about_user`,
																							`facebook`,
																							`linkdin`,
																							`youtube`	
												       							)VALUES(
																							'$username',
																							'$email',
																							'$password',
																							'$gender',
																							'$img_db',
																							'$about_user',
																							'$facebook',
																							'$linkdin',
																							'$youtube'
												       									)";
															$sql = mysqli_query($connect,$insert);


									    if (isset($sql)) {
												
												$get_user  = mysqli_query($connect,"SELECT * 
																					  FROM `users`
																					WHERE 
																					`username` = '$username'	
																					  ");
													$user  = mysqli_fetch_assoc($get_user);

													$_SESSION['id']             = $user['user_id'];
													$_SESSION['user'] 	        = $user['username'];
													$_SESSION['email']  		= $user['email'];
													$_SESSION['gender'] 		= $user['gender'];
													$_SESSION['profile_photo']  = $user['profile_photo'];
													$_SESSION['about_user'] 	= $user['about_user'];
													$_SESSION['facebook']  	    = $user['facebook'];
													$_SESSION['linkdin']  	    = $user['linkdin'];
													$_SESSION['youtube'] 		= $user['youtube'];
													$_SESSION['role'] 			= $user['role'];

										echo "<div class=\"alert alert-success\" role=\"alert\">Account has been created successfully</div>";
                                        echo "<meta http-equiv='refresh' content='3; \"index.php\"' >";		
								}

		}else{
			echo '<div class="alert alert-danger" role="alert">there is a problem while uploading image </div>';
		}   
			}else{
			echo '<div class="alert alert-danger" role="alert">image is too large must be less than 3mp </div>';
			}
				}else{
			echo '<div class="alert alert-danger" role="alert">there is an error while uploading image</div>';

				}			
 					}else{
			echo '<div class="alert alert-danger" role="alert">the extention of the image is not supported at this website</div>';
 					}				
						}else{ //else empty image set
								  $insert = "INSERT INTO `users`(
																							`username`,
																							`email`,
																							`password`,
																							`gender`,
																							`profile_photo`,
																							`about_user`,
																							`facebook`,
																							`linkdin`,
																							`youtube`
												       							)VALUES(
																							'$username',
																							'$email',
																							'$password',
																							'$gender',
																							'img/profile/default.png',
																							'$about_user',
																							'$facebook',
																							'$linkdin',
																							'$youtube'
												       									)";
															$sql = mysqli_query($connect,$insert);


									    if (isset($sql)) {
												
												$get_user  = mysqli_query($connect,"SELECT * 
																					  FROM `users`
																					WHERE 
																					`username` = '$username'	
																					  ");
													$user  = mysqli_fetch_assoc($get_user);

													$_SESSION['id']             = $user['user_id'];
													$_SESSION['username'] 	    = $user['username'];
													$_SESSION['email']  		= $user['email'];
													$_SESSION['gender'] 		= $user['gender'];
													$_SESSION['profile_photo']  = $user['profile_photo'];
													$_SESSION['about_user'] 	= $user['about_user'];
													$_SESSION['facebook']  	    = $user['facebook'];
													$_SESSION['linkdin']  	    = $user['linkdin'];
													$_SESSION['youtube'] 		= $user['youtube'];
													$_SESSION['role'] 			= $user['role'];

										echo "<div class=\"alert alert-success\" role=\"alert\">Account has been created successfully</div>";
                                        echo "<meta http-equiv='refresh' content='3; \"index.php\"' >";		
								}
						    }
						}
		 			}
				}else{
					header("location:../404.php");
				}

