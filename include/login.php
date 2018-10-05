
<?php

$msg = '';
if (isset($_POST['login'])) {

  $user = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['username'])) ;
  $password = md5($_POST['password']);

          if (empty($_POST['username']) OR empty($_POST['password'])) {

                        $msg = '<div class="alert alert-danger" style="font-size:15px;" role="alert">all inputs are requied </div>';

          }elseif (strlen($user) >= 50) {
            
                        $msg = '<div class="alert alert-danger" style="font-size:15px;" role="alert">maxlength:50 char </div>';
          
            }else{
              $sql = mysqli_query($connect, "SELECT * FROM `users` WHERE
                                            (`username` = '$user'   AND `password` = '$password')
                                                             OR
                                            (`email`   = '$user'    AND `password` = '$password')   
                                             ");
                                  if (mysqli_num_rows($sql) != 1) {
                                      $msg = '<div class="alert alert-danger" style="font-size:15px;" role="alert">wrong username or password </div>';
                                    }else{
                                    $user = mysqli_fetch_assoc($sql);
                                    
                                    $_SESSION['id']             = $user['user_id'];
                                    $_SESSION['user']           = $user['username'];
                                    $_SESSION['email']          = $user['email'];
                                    $_SESSION['gender']         = $user['gender'];
                                    $_SESSION['profile_photo']  = $user['profile_photo'];
                                    $_SESSION['about_user']     = $user['about_user'];
                                    $_SESSION['facebook']       = $user['facebook'];
                                    $_SESSION['linkdin']        = $user['linkdin'];
                                    $_SESSION['youtube']        = $user['youtube'];
                                    $_SESSION['role']           = $user['role'];
                                    $_SESSION['statusUser']     = $user['statusUser'];

                                   
                                     header("location:index.php");
                                    }
                             }
                      }
?>
<li class="hidden-xs hidden-sm">
                      <button class="btn btn-default" data-target="#loginModal" data-toggle="modal">
                        <i class="fas fa-sign-in-alt"></i> login
                     </button>
                     <div class="modal fade"  id="loginModal" tabindex="-1">
                      <div class="modal-dialog modal-sm"> <!--modal-lg-->
                        <!-- modal Content -->
                            <div class="modal-content">
                              <!-- modal header -->
                                <div class="modal-header">
                                      <button class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">login</h4>
                                </div>
                                  <!-- modal body -->
                                  <div class="modal-body">
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text"
                                                      minlength="3"
                                                       name="username" 
                                                       id="user" 
                                                       class="form-control" 
                                                       placeholder="user / email"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password"
                                                       name="password"
                                                       minlength="5"
                                                       id="password" 
                                                       class="form-control" 
                                                       placeholder="password"/>
                                            </div>

                                       
                                  </div>
                                      <!-- Modal Footer -->
                                       
                                      <div class="modal-footer">
                                        <div class="col-md-12 center" style="text-align: center;" >
                                          <?php echo  $msg;?></div>
                                          <button type="submit" name="login" class="btn btn-success btn-sm"> 
                                          logIn</button>
                                          <a href="new_profile.php" class="btn btn-danger btn-sm">signUp</a>
                                      </div>
                            </form>



                            </div>
                      </div>
                </div>
          </div>

                    </li>