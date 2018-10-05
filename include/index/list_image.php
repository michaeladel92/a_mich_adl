  <div class="content bg-blue" >
    <h1 class="tab center bounds padding active"><span><b>Category: </b><?= $setting['section_a'];?></span></h1>
    <div class="bounds padding">
         <?php
              $sectionA = mysqli_query($connect,"SELECT * FROM 
                                                          `posts`
                                                        WHERE 
                                                        `category_id`  = '$setting[section_a]' 
                                                            AND
                                                        `status` = 'published'
                                                        ORDER BY 
                                                              `post_id`
                                                        DESC
                                                        LIMIT
                                                        $setting[section_a_value]
                ");

              while($section = mysqli_fetch_assoc($sectionA)){
          ?>
                <a style="text-decoration: none;" href="article.php?id=<?= $section['post_id'];?>" class="item zoom active">
                  <div class="column">
                <div class="image">                 
                            <img   style="width: 570px;"
                                   id="ctl00_body_rptProducts_ctl00_imgProduct"
                                  class="cover accelerate"
                                   src="<?php echo ($section['image'] == 'img/posts/default.jpg'?
                                   'img/posts/default_section.gif':$section['image']);?>" 
                                   alt="antimicrobial alphasan additive prevents odors" />
              <div class="link-abs">
                <p class="link-col-text">Read more...</p>
              </div>
                </div>
              </div>
              <div class="column" style=" word-wrap: break-word;">
                <div class="text">
                  <h2 style="color:#d40b0b;"><?php echo strip_tags($section['title']);?></h2>
                  <p><span class="text-smaller"><?php echo substr(strip_tags($section['post']),0,100);?>...</span></p>      
                </div>
              </div>
            </a>
            
            <?php } ?>
  </div>
</div>