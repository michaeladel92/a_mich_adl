<footer>
    <div class="container">
      <img src="../img/logo/logo3.png" class="img-responsive" style="width: 50px;">
        <div class="row text-center">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                 <h5 style=" line-height: 20px;">Website made in native php language, 27 septemper 2018
                                
                     </h5>
              
           </div>

           <div class="col-md-6 col-sm-6 col-xs-12">
            <h3 style="margin-bottom: 0;">Social Accounts</h3>
               <ul class="list-inline">
                    <li>
                        <a target="_blank" href="<?= $setting['facebook'];?>"><i  class="fab fa-facebook-f fa-2x"></i></a>
                    </li>
                   
                 
                    <li>
                        <a target="_blank" href="<?= $setting['github'];?>"><i class="fab fa-github fa-2x"></i></a>
                    </li>
                    
                    <li>
                        <a target="_blank" href="<?= $setting['google'];?>"><i class="fab fa-linkedin fa-2x"></i></a>
                    </li>
                    
                    
                    <li>
                        <a target="_blank" href="<?= $setting['linkdin'];?>"><i class="fab fa-google-plus fa-2x"></i></a>
                   </li>
                          
                </ul>
            </div>
       </div> 
        <h6 class="text-center" style="  text-transform: uppercase;">all rights reserved &copy;   <?php echo date('Y'); ?></h6>
    </div>
</footer>
<?php
//close connection 
db_close();
?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script 
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">              
</script> -->
    <!-- bootstrap js-->
<!-- <script 
        src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" 
        crossorigin="anonymous">  
</script>  -->
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.form.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/plugin.js"></script>


  </body>
</html>