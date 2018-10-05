<!-- 
  header 
        -->
<?php
include_once("include/header.php");

/**
 * [$id ==> user_id]
 */
$id = (int)$_GET['editId'];
            
        if ($_SESSION['id'] != $id) { 
                    header("location:404.php");
                }else{

                      $user_info = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_id` = '$id'"); 
            
                        if (mysqli_num_rows($user_info) != 1) {
                              header("location:404.php");
                           } else{
                                                    $user = mysqli_fetch_assoc($user_info);   

                           }  


                }

     


?>


<!-- edit user -->
<section class="container">
  <div class="row">
     <div class="panel panel-default">
        <div class="panel-heading"><b class="h3" style="color: #d40b0b;">Welcome <?php echo ucwords($user['username']);?> - Edit Profile</b></div>
        <div class="panel-body">
                
                    <form action="controller/edit_profile.php" method="POST" class="form-horizontal col-sm-9"  enctype="multipart/form-data" id="update_profile">
                        <!-- hidden input -->
                        <input type="hidden" name="userId" value="<?php echo $user['user_id'] ?>">
                        <!--    User Name       -->
                        <div class="form-group">
                            <label for="inputUser" class="col-sm-2 control-label">name<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="text" value="<?php echo $user['username'] ?>" name="username" class="form-control" id="inputUser" placeholder="username">
                            </div>
                        </div>
                        <!--    Email    -->
                        <div class="form-group">
                            <label for="inputEmail"  class="col-sm-2 control-label">email<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="text" value="<?php echo $user['email'] ?>" name="email" class="form-control" id="inputEmail" placeholder="email">
                            </div>
                        </div>
                        <!--    Password    -->
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">password<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
                            </div>
                        </div>
                        <!--    Confirm Password  -->
                        <div class="form-group">
                            <label for="inputConf" class="col-sm-2 control-label">confirm password<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="password" name="conPassword" class="form-control" id="inputConf" placeholder="confirm password">
                            </div>
                        </div>

                        <!--    Gender      -->
                        <div class="form-group">
                            <label for="inputGender" class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-3" id="inputGender">
                                <select name="gender" class="form-control" >
                                    <option value="">choose gender</option>
                                    <option value="male"<?php echo ($user['gender'] == 'male'?'selected':''); ?>>male</option>
                                    <option value="female"<?php echo ($user['gender'] == 'female'?'selected':''); ?> >female</option>

                                </select>
                            </div>
                        </div>
                        <!--    Image  -->
                        <div class="form-group">
                            <label for="inputPic" class="col-sm-2 control-label">Profile</label>
                            <div class="col-sm-9">
                                <input type="file" name="profile_photo" class="form-control" id="inputPic" >
                            </div>
                        </div>
                        <!--    About You        -->
                        <div class="form-group">
                            <label for="inputAbout"  class="col-sm-2 control-label">description</label>
                            <div class="col-sm-9">
                                <textarea   rows="4" name="about_user" class="form-control" id="inputAbout" placeholder="describe ur self"><?php echo $user['about_user'] ?></textarea>
                            </div>
                        </div>
                        <!--    facebook  -->
                        <div class="form-group">
                            <label for="inputFace" class="col-sm-2 control-label"><i style="color:#4867aa;" class="fab fa-facebook-square fa-2x"></i></label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo $user['facebook']; ?>"  name="facebook" class="form-control" id="inputFace" placeholder="facebook URL">
                            </div>
                        </div>
                        <!--    linkdin  -->
                        <div class="form-group">
                            <label for="inputTweet" class="col-sm-2 control-label"><i style=" color:#1da1f2;" class="fab fa-linkedin-in fa-2x"></i></label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo $user['linkdin'] ?>" name="linkdin" class="form-control" id="inputTweet" placeholder="linkdin">
                            </div>
                        </div>
                        <!--    Youtube  -->
                        <div class="form-group">
                            <label for="inputYoutube" class="col-sm-2 control-label"><i  style="color:#f00;"class="fab fa-youtube fa-2x"></i></label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo $user['youtube'] ?>" name="youtube" class="form-control" id="inputYoutube" placeholder="youtube url">
                            </div>
                        </div>
                        <!--    Authority      -->
                     <!--    <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">Authority</label>
                            <div class="col-sm-3" id="role">
                                <select name="role" class="form-control" >
                                    <option value="user">user</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div> -->
                        <!--    Submit-->
                             <div class=" col-md-5 col-md-offset-4 text-center" > <!--loading using Ajax-->
                                  <div id="update_result" ></div>
                             </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <button type="submit" name="update" class="btn btn-danger btn-block"> <i class="fas fa-pencil-alt"></i> Update</button>
                            </div>
                        </div>
                    </form>
                      <!--SHOW Image-->
                        <div class="panel panel-default col-xs-3 img-responsive">
                                <img src="<?php echo $user['profile_photo'] ?>"  style=" width: 100%; height: 200px;">
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