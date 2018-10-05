


 <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
      <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
            <?php
            /**
             * ON header [$setting] to get * the settings data
             * GET slide data & Value 
             */

                $GetSlide = mysqli_query($connect,"
                                                  SELECT * FROM 
                                                                `posts`
                                                     WHERE 
                                                         `status`   = 'published'
                                                     AND 
                                                         `category_id` = '$setting[slide]' 
                                                     ORDER BY `post_id`
                                                     DESC LIMIT 
                                                     $setting[slide_value]              
                                                  ");
                $numSlide = mysqli_num_rows($GetSlide);

                $x = 0;
                while($slide = mysqli_fetch_assoc($GetSlide)){
            ?>
            <div class="item <?= ($x == 0? 'active':'' );?>" >
                <img   src="<?php echo $slide['image'];?>">                
                  <div class="carousel-caption ">
                    <h1><?php echo strip_tags($slide['title']); ?></h1>
                    <br>
                    <a target="_blank" href="article.php?id=<?= $slide['post_id'];?>" type="button" class="btn btn-default">Read More</a>
                  </div>
            </div><!--end Active-->
            
          <?php 
            $x++;
            }//end while
             ?>
      </div>
  </div>