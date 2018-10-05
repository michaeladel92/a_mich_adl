<?php
$current = 'setting.php';
//header and asside 
include_once("include/header.php");

//check if user is admin or not 
if ($_SESSION['role'] == 'admin') {

/**
 * if user change one field the old value 
 * of other values wont change
 */
        $sql = mysqli_query($connect,"SELECT * FROM `settings`"); 

        $setting = mysqli_fetch_assoc($sql);
/**
 * to avoid re-writing the select Options,
 * its in the end of php due to php read from upwards 
 */
function category($x){
    global $connect;
    $category = mysqli_query($connect,"SELECT * FROM `category`");
        while ($cate = mysqli_fetch_assoc($category)) {
            echo '<option value="'.$cate['categoryName'].'" 
                 '.($x == $cate['categoryName']?'selected':'') .'>
                 '.$cate['categoryName'].'  
                 </option>';
        }
}

?>





<!-- setting -->
<div class="col-lg-10">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
            <div class="panel panel-info">
        <div class="panel-heading"><b class="h1">Setting</b></div>
        <div class="panel-body">
            <form action="edit_setting.php" method="POST" class="form-horizontal" id="setting" enctype="multipart/form-data">
<!--site_name-->
                <div class="form-group">
                    <label for="site" class="col-sm-2 control-label">name:</label>
                    <div class="col-sm-4">
                        <input type="text" 
                               class="form-control" 
                               value="<?php echo ($setting['site_name'] == '' ? '':$setting['site_name']);?>" 
                               name="site_name" 
                               id="site"
                               placeholder="website name">
                    </div>
                </div>
<!--logo-->
                <div class="form-group">
                    <label for="image" class="col-sm-2 control-label">logo: </label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control"  name="logo" id="image">
                    </div>
                </div>
<!--slide-->
                <div class="form-group">
                    <label for="slide" class="col-sm-2 control-label">SlideShow: </label>
                    <div class="col-sm-3">
                            <select class="form-control" name="slide" id="slide">
                                <option value="">choose category</option>
                                <?php category($setting['slide']);?>
                            </select>
                    </div>
            <!--slide_value-->
                    <label for="slide_num" class="col-sm-2 control-label">num</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="slide_value" id="slide_num">
                                <option value="3" <?php echo ($setting['slide_value'] == '3'? 'selected':'');?>>3</option>
                                <option value="6" <?php echo ($setting['slide_value'] == '6'? 'selected':'');?>>6</option>
                                <option value="9" <?php echo ($setting['slide_value'] == '9'? 'selected':'');?>>9</option>
                            </select>
                    </div>
                </div>
<!--section_a-->
                <div class="form-group">
                    <label for="section1" class="col-sm-2 control-label">sectionOne: </label>
                    <div class="col-sm-3">
                         <select class="form-control" name="section_a" id="section1">
                                <option value="">choose category</option>
                                <?php category($setting['section_a']);?>
                            </select>
                    </div>
      <!--section_a_value-->
                    <label for="section1_num" class="col-sm-2 control-label">num</label>
                    <div class="col-sm-2">
                         <select class="form-control" name="section_a_value" id="section1_num">
                                <option value="3" <?php echo ($setting['section_a_value'] == '3'? 'selected':'');?> >3</option>
                                <option value="6" <?php echo ($setting['section_a_value'] == '6'? 'selected':'');?>>6</option>
                                <option value="9" <?php echo ($setting['section_a_value'] == '9'? 'selected':'');?>>9</option>
                            </select>
                    </div>
                </div>
 <!--section_b-->
                <div class="form-group">
                    <label for="section_b" class="col-sm-2 control-label">SectionTwo: </label>
                    <div class="col-sm-3">
                         <select class="form-control" name="section_b" id="section_b">
                                <option value="">choose category</option>
                                <?php category($setting['section_b']);?>
                                
                            </select>
                    </div>
            <!--section_b_value-->
                    <label for="section_b_value" class="col-sm-2 control-label">num</label>
                    <div class="col-sm-2">
                         <select class="form-control" name="section_b_value" id="section_b_value">
                                <option value="3" <?php echo ($setting['section_b_value'] == '3'? 'selected':'');?> >3</option>
                                <option value="6" <?php echo ($setting['section_b_value'] == '6'? 'selected':'');?> >6</option>
                                <option value="9" <?php echo ($setting['section_b_value'] == '9'? 'selected':'');?> >9</option>
                            </select>
                    </div>
                </div>
<!--tab_a-->
                <div class="form-group">
                    <label for="tab_a" class="col-sm-2 control-label">TabOne: </label>
                    <div class="col-sm-3">
                        <select class="form-control" name="tab_a" id="tab_a">
                                <option value="">choose category</option>
                                <?php category($setting['tab_a']);?>
                            </select>
                    </div>
            <!--tab_a_value-->
                    <label for="tab_a_value" class="col-sm-2 control-label">num</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="tab_a_value" id="tab_a_value">
                                <option value="3" <?php echo ($setting['tab_a_value'] == '3'? 'selected':'');?> >3</option>
                                <option value="6" <?php echo ($setting['tab_a_value'] == '6'? 'selected':'');?> >6</option>
                                <option value="9" <?php echo ($setting['tab_a_value'] == '9'? 'selected':'');?> >9</option>
                            </select>
                    </div>
                </div>
<!--tab_b-->
                <div class="form-group">
                    <label for="tab_b" class="col-sm-2 control-label">TabTwo: </label>
                    <div class="col-sm-3">
                      <select class="form-control" name="tab_b" id="tab_b">
                                <option value="">choose category</option>
                                <?php category($setting['tab_b']);?>
                            </select>
                       
                    </div>
            <!--tab_b_value-->
                    <label for="tab_b_value" class="col-sm-2 control-label">num</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="tab_b_value" id="tab_b_value">
                                <option value="3" <?php echo ($setting['tab_b_value'] == '3'? 'selected':'');?> >3</option>
                                <option value="6" <?php echo ($setting['tab_b_value'] == '6'? 'selected':'');?> >6</option>
                                <option value="9" <?php echo ($setting['tab_b_value'] == '9'? 'selected':'');?> >9</option>
                            </select>
                    </div>
                </div>
<!--tab_c-->
                <div class="form-group">
                    <label for="tab_c" class="col-sm-2 control-label">TabThree: </label>
                    <div class="col-sm-3">
                         <select class="form-control" name="tab_c" id="tab_c">
                                <option value="">choose category</option>
                                <?php category($setting['tab_c']);?>
                            </select>
                    </div>
            <!--tab_c_value-->
                    <label for="tab_c_value" class="col-sm-2 control-label">num</label>
                    <div class="col-sm-2">
                         <select class="form-control" name="tab_c_value" id="tab_c_value">
                                <option value="3" <?php echo ($setting['tab_c_value'] == '3'? 'selected':'');?>>3</option>
                                <option value="6" <?php echo ($setting['tab_c_value'] == '6'? 'selected':'');?>>6</option>
                                <option value="9" <?php echo ($setting['tab_c_value'] == '9'? 'selected':'');?>>9</option>
                            </select>
                    </div>
                </div>
  <!--facebook-->
                <div class="form-group">
                    <label for="facebook"  class="col-sm-2 control-label"><i style="color:#4867aa;" class="fab fa-facebook-square fa-2x"></i></label>
                    <div class="col-sm-9">
                        <input type="text" 
                               value="<?php echo ($setting['facebook'] ==''?'':$setting['facebook']);?>"
                               class="form-control" name="facebook" id="facebook" placeholder="facebook url">
                    </div>
                </div>
  <!--github-->
                <div class="form-group">
                    <label for="github" class="col-sm-2 control-label"><i style="color:black;" class="fab fa-github fa-2x"></i></label>
                    <div class="col-sm-9">
                        <input type="text"
                               value="<?php echo ($setting['github'] ==''?'':$setting['github']);?>"
                               class="form-control" id="github" name="github" placeholder="github url">
                    </div>
                </div>
   <!--google-->
                <div class="form-group">
                    <label for="google" class="col-sm-2 control-label"><i style="color:#d51b1c;" class="fab fa-google-plus-square fa-2x"></i> </label>
                    <div class="col-sm-9">
                        <input type="text" 
                               value="<?php echo ($setting['google'] ==''?'':$setting['google']);?>"
                               class="form-control" name="google" id="google" placeholder="google plus url">
                    </div>
                </div>
   <!--linkdin-->
                <div class="form-group">
                    <label for="linkdin" class="col-sm-2 control-label"><i style="color:#0274b3;" 
                          class="fab fa-linkedin fa-2x"></i></label>
                    <div class="col-sm-9">
                        <input type="text" 
                               value="<?php echo ($setting['linkdin'] ==''?'':$setting['linkdin']);?>"
                               class="form-control" name="linkdin" id="linkdin" placeholder="linkdin url">
                    </div>
                </div>


<!--submit-->
                    <div class="col-md-offset-2">
                    <div id="setting_result"></div>
                    </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

<!-- end setting -->

</div>
</section>









<!-- footer -->
<?php
include_once("include/footer.php");
}else{
  header("location:../404.php");
}
?>