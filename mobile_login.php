
<?php
include_once('include/header.php');
?>
       <div class="container" style="min-height: 450px;">
           <div class="row">
               <div class="col-md-10">
                            <form action="index.php" method="post">
                                            <div class="form-group">
                                                <label for="users">Username</label>
                                                <input type="text"
                                                      minlength="3"
                                                       name="username" 
                                                       id="users" 
                                                       class="form-control" 
                                                       placeholder="user / email"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="passwords">Password</label>
                                                <input type="password"
                                                       name="password"
                                                       minlength="5"
                                                       id="passwords" 
                                                       class="form-control" 
                                                       placeholder="password"/>
                                            </div>

                                  </div>
                                  <div class="col-md-10">
                       
                                          <button type="submit" name="login" class="btn btn-success btn-sm"> 
                                          logIn</button>
                                          <a href="new_profile.php" class="btn btn-danger btn-sm">signUp</a>
                                   
                                  </div>
                                        
                            </form>    
               </div>
               
           </div>
             
       </div>
                            

<?php include_once('include/footer.php'); ?>