<?php
include_once('include/connection.php');

session_start();

if ($_SESSION['role'] != 'admin'){
    header("location:../404.php");
}


if (isset($_POST['submit'])) {

		$site_name = strip_tags($_POST['site_name']);
		$facebook  = htmlspecialchars($_POST['facebook']);
		$github	   = htmlspecialchars($_POST['github']);
		$google	   = htmlspecialchars($_POST['google']);
		$linkdin   = htmlspecialchars($_POST['linkdin']);

			$sql_setting = mysqli_query($connect,"SELECT * FROM `settings`");

//site_name must be filled and min. char 5
	if (empty($site_name)) {
			echo '<div class="alert alert-danger" role="alert">Please insert site name</div>';
	
		}elseif(strlen($site_name) < 5){
			echo '<div class="alert alert-danger" role="alert">site name minimum character 5</div>';
			//all of the select field must be field
			}elseif (
						empty($_POST['slide'])     OR
						empty($_POST['section_a']) OR
						empty($_POST['section_b']) OR
						empty($_POST['tab_a'])     OR
						empty($_POST['tab_b'])     OR
						empty($_POST['tab_c'])     
			
		) { 
				echo '<div class="alert alert-danger" role="alert">Please fill all the selection fields</div>';
		//all url must be filled
		}elseif(
				     	empty($facebook)  OR
						empty($github)    OR
						empty($google)    OR
						empty($linkdin)    
			   ){

				echo '<div class="alert alert-danger" role="alert">Please fill all the URL fields</div>';
		

		//make sure they are url validate
		}elseif (!filter_var($facebook , FILTER_VALIDATE_URL)) {
			    echo '<div class="alert alert-danger" role="alert">your facebook url is not valid, please copy the url and pase it here</div>';
		
		}elseif (!filter_var($github , FILTER_VALIDATE_URL)) {
			    echo '<div class="alert alert-danger" role="alert">your github url is not valid, please copy the url and pase it here</div>';
		
		}elseif (!filter_var($google , FILTER_VALIDATE_URL)) {
			    echo '<div class="alert alert-danger" role="alert">your google url is not valid, please copy the url and pase it here</div>';
		
		}elseif (!filter_var($linkdin , FILTER_VALIDATE_URL)) {
			    echo '<div class="alert alert-danger" role="alert">your linkdin url is not valid, please copy the url and pase it here</div>';
		}else{



	/**
	 * if it has zero input it will go to else,
	 * we need to have in database one row only not more
	 * and the same row will always UPDATE if needed
	 */

			if (mysqli_num_rows($sql_setting) != 1) {

						if(isset($_FILES['logo'])){

							$image    = $_FILES['logo'];

							$img_name = $image['name'];
							$img_tmp  = $image['tmp_name'];
							$img_size = $image['size'];
							$img_err  = $image['error'];

							//if ($img_name != '') { that one didnt work so i change it to isset at above
								$img_exe = explode('.',$img_name); //it will take after dot which is the extension
								$img_exe = strtolower(end($img_exe));
								$allow   = array('png');

								 		if (in_array($img_exe, $allow)) {
								 		 		if ($img_err == 0) {
								 		 			if ($img_size <= 3000000) {
								 		 		
								 		 				$new_name  = uniqid('logo',false);
								 		 				//path
								 		 				$img_dir   = '../img/logo/' . $new_name .'.'. $img_exe;
								 		 				$img_db    = 'img/logo/' . $new_name .'.'. $img_exe;

								 		 				$move_file = move_uploaded_file($img_tmp,$img_dir);

 				
//if file moved successfully 
 				if ($move_file) {
 					$insert = mysqli_query($connect, "
														INSERT INTO `settings`(
																			`site_name`,
																			`logo`,
																			`slide`,	
																			`slide_value`,
																			`section_a`,
																			`section_a_value`,
																			`section_b`,
																			`section_b_value`,
																			`tab_a`,
																			`tab_a_value`,
																			`tab_b`,
																			`tab_b_value`,
																			`tab_c`,
																			`tab_c_value`,
																			`facebook`,
																			`github`,
																			`google`,
																			`linkdin`		
																		   )VALUES (
																			'$site_name',
																			'$img_db ',
																			'$_POST[slide]',
																			'$_POST[slide_value]',
																			'$_POST[section_a]',
																			'$_POST[section_a_value]',
																			'$_POST[section_b]',
																			'$_POST[section_b_value]',
																			'$_POST[tab_a]',
																			'$_POST[tab_a_value]',
																			'$_POST[tab_b]',
																			'$_POST[tab_b_value]',
																			'$_POST[tab_c]',
																			'$_POST[tab_c_value]',
																			'$facebook',
																			'$github',
																			'$google',
																			'$linkdin'
																		   )");
 					if (isset($insert)) {
 								
 						 echo '<div class="alert alert-success" role="alert">Data insert Successfully</div>';
 					   }
 			    	}else{
 			    		 echo '<div class="alert alert-danger" role="alert">sorry, fail to upload file</div>';	
 			    	   }
				}else{
					echo '<div class="alert alert-danger" role="alert">sorry, Max size image 3mp</div>';
			    	}
			}else{
				echo '<div class="alert alert-danger" role="alert">sorry, there was an error in image file</div>';
			   }
		}else{
			echo '<div class="alert alert-danger" role="alert">sorry, Image pust be png extension only!</div>';
		  } 	
	 
	}else{ // there are no image uploaded
						$insert = mysqli_query($connect, "
														INSERT INTO `settings`(
																			`site_name`,
																			`slide`,	
																			`slide_value`,
																			`section_a`,
																			`section_a_value`,
																			`section_b`,
																			`section_b_value`,
																			`tab_a`,
																			`tab_a_value`,
																			`tab_b`,
																			`tab_b_value`,
																			`tab_c`,
																			`tab_c_value`,
																			`facebook`,
																			`github`,
																			`google`,
																			`linkdin`		
																		   )VALUES (
																			'$site_name',
																			'$_POST[slide]',
																			'$_POST[slide_value]',
																			'$_POST[section_a]',
																			'$_POST[section_a_value]',
																			'$_POST[section_b]',
																			'$_POST[section_b_value]',
																			'$_POST[tab_a]',
																			'$_POST[tab_a_value]',
																			'$_POST[tab_b]',
																			'$_POST[tab_b_value]',
																			'$_POST[tab_c]',
																			'$_POST[tab_c_value]',
																			'$facebook',
																			'$github',
																			'$google',
																			'$linkdin'
																		   )");
 					if (isset($insert)) {
 								
 						 echo '<div class="alert alert-success" role="alert">Data insert Successfully</div>';
 					   }
				}//end else
			}else{ 
			/**
			 * mysqli_num_rows ==> 1 [we will update SQL data]
			 * because we need only ONE row data in database to be used
			 * This coming code will be copied from Above and change INSERT SQL 
			 * to UPDATE 
			 */
							

							if (isset($_FILES['logo'])) {
							
								$image    = $_FILES['logo'];

								$img_name = $image['name'];
								$img_tmp  = $image['tmp_name'];
								$img_size = $image['size'];
								$img_err  = $image['error'];

								$img_exe = explode('.',$img_name); //it will take after dot which is the extension
								$img_exe = strtolower(end($img_exe));
								$allow   = array('png');

								 		if (in_array($img_exe, $allow)) {
								 		 		if ($img_err == 0) {
								 		 			if ($img_size <= 3000000) {
								 		 			
								 		 				$new_name  = uniqid('logo',false);
								 		 				//path
								 		 				$img_dir   = '../img/logo/' . $new_name .'.'. $img_exe;
								 		 				$img_db    = 'img/logo/' . $new_name .'.'. $img_exe;

								 		 				$move_file = move_uploaded_file($img_tmp,$img_dir);

 				
//if file moved successfully 
 				if ($move_file) {
 					$update = mysqli_query($connect, "
								UPDATE `settings` SET 
													`site_name` 		= '$site_name',
													`logo` 				= '$img_db',
													`slide`				= '$_POST[slide]',	
													`slide_value`		= '$_POST[slide_value]',
													`section_a`       	= '$_POST[section_a]',
													`section_a_value`	= '$_POST[section_a_value]',  
													`section_b` 		= '$_POST[section_b]',
													`section_b_value`	= '$_POST[section_b_value]',
													`tab_a` 			= '$_POST[tab_a]',
													`tab_a_value`		= '$_POST[tab_a_value]',
													`tab_b`				= '$_POST[tab_b]',
													`tab_b_value`  		= '$_POST[tab_b_value]',
													`tab_c`				= '$_POST[tab_c]',
													`tab_c_value`		= '$_POST[tab_c_value]',
													`facebook`			= '$facebook',
													`github`			= '$github',
													`google`			= '$google',
													`linkdin`			= '$linkdin'
												   ");
 					if (isset($update)) {
 								
 						 echo '<div class="alert alert-success" role="alert">Data Updated Successfully</div>';
 					   }
 			    	}else{
 			    		 echo '<div class="alert alert-danger" role="alert">sorry, fail to upload file</div>';	
 			    	   }
				}else{
					echo '<div class="alert alert-danger" role="alert">sorry, Max size image 3mp</div>';
			    	}
			}else{
				echo '<div class="alert alert-danger" role="alert">sorry, there was an error in image file</div>';
			   }
		}else{
			echo '<div class="alert alert-danger" role="alert">sorry, Image pust be png extension only!</div>';
		  } 	
	 
	}else{ // there are no image uploaded
																		
 					$update = mysqli_query($connect, "
								UPDATE `settings` SET 
													`site_name` 		= '$site_name',
													`slide`				= '$_POST[slide]',	
													`slide_value`		= '$_POST[slide_value]',
													`section_a`       	= '$_POST[section_a]',
													`section_a_value`	= '$_POST[section_a_value]',  
													`section_b` 		= '$_POST[section_b]',
													`section_b_value`	= '$_POST[section_b_value]',
													`tab_a` 			= '$_POST[tab_a]',
													`tab_a_value`		= '$_POST[tab_a_value]',
													`tab_b`				= '$_POST[tab_b]',
													`tab_b_value`  		= '$_POST[tab_b_value]',
													`tab_c`				= '$_POST[tab_c]',
													`tab_c_value`		= '$_POST[tab_c_value]',
													`facebook`			= '$facebook',
													`github`			= '$github',
													`google`			= '$google',
													`linkdin`			= '$linkdin'
												   ");
 					if (isset($update)) {
 								
 						 echo '<div class="alert alert-success" role="alert">Data Updated Successfully</div>';
 					   }
					}//end else
				}//end else
			}//end isset[submit]
		}//end else before submit
/**
 * if user change one field the old value 
 * of other values wont change
 */
		$sql = mysqli_query($connect,"SELECT * FROM `settings`"); 

		$setting = mysqli_fetch_assoc($sql);


