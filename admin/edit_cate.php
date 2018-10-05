<?php
//header and asside 
include_once("include/header.php");



$msg = '';

if ($_SESSION['role'] == 'admin') {



//get category id
if (isset($_GET['editId'])) {
			$id = intval( $_GET['editId']);
				
				$sql  = mysqli_query($connect,"SELECT * FROM `category` WHERE `cate_id` = '$id'");

				if(mysqli_num_rows($sql) != 1){
						header("location:../404.php");
				}else {
						$cate = mysqli_fetch_assoc($sql); 
					}	
				}

//update category
if (isset($_POST['edit_cate'])) {
			$newCategory = strip_tags($_POST['category']);
			if (empty($_POST['category'])) {
				$msg = '<div class="alert alert-danger" role="alert">Insert category Name</div>';
						}else{
							$sql = mysqli_query($connect,"UPDATE `category` 
																SET 
																`categoryName` = '$newCategory'
																WHERE
																`cate_id` = '$id'
																");
							if(isset($sql)){
								header("location:all_categories.php");
							}
						}			
					}					
				}else{
					header("location:../index.php");
				}



?>
 <!-- Edit category -->        			
     <div class="col-lg-9" style="min-height: 400px;">
    <div class="row">

        <div class="col-md-5 col-md-offset-2">
                        <div class="panel panel-default">
                <div class="panel-heading">Edit Category <b style="color:#b60c1a;"><?php echo $cate['categoryName'];?></b></div>
                <div class="panel-body">
                    <form action="" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label for="category" class="col-sm-4 control-label">Name :</label>
                            <div class="col-sm-8">
                                <input type="text" name="category" class="form-control" id="category" value="<?php echo $cate['categoryName'];?>" placeholder="Write new Category Name">
                            </div>
                        </div>
                        <hr>
                        <div  style="text-align: center;">
								<?php echo $msg;?>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <input type="submit" name="edit_cate" class="btn btn-danger" value="Update Category">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>




          












</div>
</section>
 
<!-- footer -->
<?php
include_once("include/footer.php");
?>