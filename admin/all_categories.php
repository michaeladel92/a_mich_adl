<?php
$current = 'all_categories.php';
//header and asside 
include_once("include/header.php");

//check if user is admin or not 
if ($_SESSION['role'] == 'admin') { 


$msg = '';
//add new category form

    if (isset($_POST['add_category'])) {
                 
                  $category_name     = strip_tags($_POST['category']);


                            if(empty($_POST['category'])){
                                $msg = '<div class="alert alert-danger" role="alert">Please insert category Name</div>';

                                  }elseif(strlen($category_name) > 15  ){
                                           $msg = '<div class="alert alert-danger" role="alert">Maximum number character 15</div>';

                                  }elseif(strlen($category_name) < 3  ){
                                           $msg = '<div class="alert alert-danger" role="alert">Minimum number character 3</div>';

                                  }else{

                                    //check if category name in database or no
                                    $checkCategory = mysqli_query($connect,"SELECT `categoryName`
                                                                               FROM `category`
                                                                               WHERE
                                                                              `categoryName` = '$category_name'
                                                                               ");

                                        if (mysqli_num_rows($checkCategory) > 0) {
                                             $msg = '<div class="alert alert-danger" role="alert">category name already taken </div>';
                                        }else{
                                              $sql = mysqli_query($connect,"INSERT INTO `category`
                                                                                          (`categoryName`)
                                                                                        VALUES
                                                                                        ('$category_name')  
                                                                                        ");
                                                    if(isset($sql)){
                                                              $msg = '<div class="alert alert-success" role="alert">Category added successfully</div>';
                                                            }    
                                                        }
                                                    }                                      
                                                }
//get category
$cat = mysqli_query($connect, "SELECT * FROM `category` ORDER BY `cate_id` DESC");


//delete category
if (isset($_GET['deleteId'])) {
          $id = intval($_GET['deleteId']);
          //check if its host or not
            if ($_SESSION['id'] == 1 AND $_SESSION['role'] == 'admin') {
                      $sql = mysqli_query($connect,"DELETE FROM `category` WHERE `cate_id` = '$id'");
            if (isset($sql)) {
                $msg = '<div class="alert alert-success" role="alert">category successfully deleted</div>';
                  echo "<meta http-equiv='refresh' content='2; \"all_categories.php\"' >";
            }
        }else{
              $msg = '<div class="alert alert-danger" role="alert">Sorry, your not Authorized to delete any categories, only the Original Host can do that!</div>';
        }
        
}
?>
  

  <!-- table category -->
  <div class="col-md-4 col-md-offset-2" style="text-align: center;">
  <?php echo $msg;?>
    
  </div>
  <section class="col-md-7 col-md-offset-2" style="min-height: 400px;">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-3">
            <h3 class="text-center pull-left" style="padding-left: 30px;"><i class="fas fa-list fa-sm"></i> Categories </h3>
          </div>
          <div class="col-xs-9 col-sm-9 col-md-9">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="col-xs-12 col-md-12">
               <!--create_category  -->
                 <form action="" method="POST" class="form-horizontal">
                   <label>Category</label>
                        <div class="form-group">
                                  <div class="input-group">
                                            <input type="text" 
                                                   name="category"
                                                   class="form-control input-md" 
                                                   id="category"
                                                   placeholder="Add New Category"
                                            >  
                                  </div>
                                   <div class="input-group-btn">
                                            <input type="submit" 
                                                   name="add_category"
                                                   class=" btn btn-info" 
                                                   value="Add"
                                            >                         
                                  </div>
                      </div>          
                    </form><!-- end create_category -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-body table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center"> No. </th>
              <th class="text-center"> CategoryName </th>
              <th class="text-center"> Watch </th>
              <th class="text-center"> Edit </th>
              <th class="text-center"> Delete </th>
            </tr>
          </thead>
<!-- table -->
          <tbody>
<?php
       $num = 1;
       while ($category = mysqli_fetch_assoc($cat)) { 
      ?>

            <tr class="edit" id="detail">
              <td id="no" class="text-center"><?php echo $num;?></td>
              <td id="name" class="text-center"> <?php echo $category['categoryName']?> </td>
              <!-- see more -->
              <td id="mobile" class="text-center">
                  <a href="../list_article.php?cate=<?php echo $category['categoryName'];?>"
                     class="btn btn-primary btn-xs"><i class="far fa-eye"></i> see more
                  </a> 
              </td>
              <!-- Edit -->
              <td id="mail" class="text-center">   
                  <a href="edit_cate.php?editId=<?php echo $category['cate_id']?>" 
                     class="btn btn-warning btn-xs"><i class="fas fa-edit"></i>
                  </a>
              </td>
              <!-- Delete -->
              <td id="city" class="text-center"> 
                  <a href="all_categories.php?deleteId=<?php echo $category['cate_id']?>" 
                     class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i>
                  </a>
              </td>
            </tr>

<?php $num++;
           } 
      ?>  
         
          </tbody>
        </table>
      </div>
    </div>
  </section>










</div>
</section>


<!-- footer -->
<?php
include_once("include/footer.php");
}else{
  header("location:../404.php");
}
?>