<!-- 
  header 
        -->
<?php
include_once("include/header.php");

?>



<section class="container">
  <div class="row">
     <div class="panel panel-default">
        <div class="panel-heading"><b class="h1"><i class="fas fa-user-plus"></i> New member</b></div>
        <div class="panel-body">
                
<!-- Registeration -->
<?php  if (isset($_SESSION['id'])) {
        
            header("location:404.php");
} else{ ?>
                    <form action="controller/register.php" method="POST" class="form-horizontal col-sm-9" 
                    id="register"  enctype="multipart/form-data">
            <!-- username-->
                        <div class="form-group">
                            <label for="inputUser" class="col-sm-2 control-label">name<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="text" minlength="3" name="username" class="form-control" id="inputUser" placeholder="username">
                            </div>
                        </div>
            <!--    email    -->
                        <div class="form-group">
                            <label for="inputEmail"  class="col-sm-2 control-label">email<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="text" minlength="10" name="email" class="form-control" id="inputEmail" placeholder="email">
                            </div>
                        </div>
            <!--    password    -->
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">password<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="password" minlength="5" name="password" class="form-control" id="inputPassword" placeholder="password">
                            </div>
                        </div>
            <!--    conPassword  -->
                        <div class="form-group">
                            <label for="inputConf" class="col-sm-2 control-label">confirm password<span style="color: red;" >*</span></label>
                            <div class="col-sm-5">
                                <input type="password" name="conPassword" class="form-control" id="inputConf" placeholder="confirm password">
                            </div>
                        </div>

            <!--    gender      -->
                        <div class="form-group">
                            <label for="inputGender" class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-3" id="inputGender">
                                <select name="gender" class="form-control" required="required">
                                    <option value="male">male</option>
                                    <option value="female">female</option>

                                </select>
                            </div>
                        </div>
            <!--    profile_photo  -->
                        <div class="form-group">
                            <label for="inputPic" class="col-sm-2 control-label">ProfileImage</label>
                            <div class="col-sm-9">
                                <input type="file" name="profile_photo" class="form-control" id="inputPic" >
                            </div>
                        </div>
            <!--    about_user        -->
                        <div class="form-group">
                            <label for="inputAbout"  class="col-sm-2 control-label">description</label>
                            <div class="col-sm-9">
                                <textarea   rows="4" name="about_user" class="form-control" id="inputAbout" placeholder="tell us about your self" minlength="20" required="required"></textarea>
                            </div>
                        </div>
            <!--    facebook  -->
                        <div class="form-group">
                            <label for="inputFace" class="col-sm-2 control-label"><i style="color:#4867aa;" class="fab fa-facebook-square fa-2x"></i></label>
                            <div class="col-sm-9">
                                <input type="text"  name="facebook" class="form-control" id="inputFace" placeholder="facebook URL">
                            </div>
                        </div>
            <!--    linkdin  -->
                        <div class="form-group">
                            <label for="inputTweet" class="col-sm-2 control-label"><i style="color:#007bb6;" class="fab fa-linkedin fa-2x"></i></label>
                            <div class="col-sm-9">
                                <input type="text"  name="linkdin" class="form-control" id="inputTweet" placeholder="linkdin">
                            </div>
                        </div>
            <!--    youtube  -->
                        <div class="form-group">
                            <label for="inputYoutube" class="col-sm-2 control-label"><i  style="color:#f00;"class="fab fa-youtube fa-2x"></i></label>
                            <div class="col-sm-9">
                                <input type="text"  name="youtube" class="form-control" id="inputYoutube" placeholder="youtube url">
                            </div>
                        </div>
           
                        <!--register-->
                         
                <div class=" col-md-5 col-md-offset-4 text-center" > <!--loading using Ajax-->
                    <div id="result" ></div>
                </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <button type="submit" name="register" class="btn btn-danger btn-block"> <i class="fas fa-user-plus"></i> New member</button>
                            </div>
                        </div>
                    </form>
        <?php } ?>



</div>
</div>
</section>






<!--
 footer 
      -->

<?php
include_once("include/footer.php");
?>