<div class="container">
        <div class="row">
        <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="gallery-title" style="margin-bottom: 34px;">GALLARY</h1>
        </div>

        <div align="center">
            <button class="btn btn-default filter-button active"
                    data-filter="all">All
            </button>
            <!-- button tab_a 
                and 
                data-filter  is the target name
                 -->
            <button class="btn btn-default filter-button" 
                    data-filter="tab_a"><?= $setting['tab_a'];?>
            </button>
               <!-- button tab_b 
                and 
                data-filter  is the target name
                 -->
            <button class="btn btn-default filter-button" 
                    data-filter="tab_b"><?= $setting['tab_b'];?>
            </button>
    <!-- button tab_c 
    and 
    data-filter  is the target name
     -->
            <button class="btn btn-default filter-button"
                    data-filter="tab_c"><?= $setting['tab_c'];?>
            </button>
   <!-- button section_b 
    and 
    data-filter  is the target name
     --> 
            <button class="btn btn-default filter-button" 
                    data-filter="section_b"><?= $setting['section_b'];?>
            </button>
        
        </div>
        <br/>

            
<!--tab_a 
            tab_a => is the value of category at table setting SQL 
            $setting ==> got it from header SQL

 -->
<?php
        $tab_a = mysqli_query($connect, "SELECT * FROM `posts`
                                                              WHERE 
                                                                `status` = 'published'
                                                                AND
                                                                `category_id` = '$setting[tab_a]'
                                                                ORDER BY 
                                                                `post_id`
                                                                DESC 
                                                                LIMIT 
                                                                $setting[tab_a_value]     
                                                        ");
        while($tabA = mysqli_fetch_assoc($tab_a)){
?>
        <div class="thumbnail text-center gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter tab_a">
            <img src="<?= ($tabA['image'] == 'img/posts/default.jpg'?'img/posts/default_gallary.jpg': $tabA['image']);?>" 
                 style="width: 380px; height: 253px;"   
                 class="img-responsive">
            <div class="caption">
        <h2><a id="font_style" href="article.php?id=<?= $tabA['post_id'];?>" ><?= (strlen($tabA['title']) > 20 ? substr($tabA['title'],0, 20) . '...' : $tabA['title']);?></a></h2>
            </div>
        </div>
<?php } ?>

<!--tab_b 
            tab_b => is the value of category at table setting SQL 
            the container div of each gallary has a filter that respond 
            to the target name above[data-filter] 
            $setting ==> got it from header SQL

 -->
 <?php
        $tab_b = mysqli_query($connect, "SELECT * FROM `posts`
                                                              WHERE 
                                                                `status` = 'published'
                                                                AND
                                                                `category_id` = '$setting[tab_b]'
                                                                ORDER BY 
                                                                `post_id`
                                                                DESC 
                                                                LIMIT 
                                                               $setting[tab_b_value]     
                                                        ");
        while($tabB = mysqli_fetch_assoc($tab_b)){
?>
             <div class="thumbnail text-center gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter tab_b">
                <img src="<?= ($tabB['image'] == 'img/posts/default.jpg'?'img/posts/default_gallary.jpg': $tabB['image']);?>" 
                     style="width: 380px; height: 253px;"   
                     class="img-responsive">
                <div class="caption">
            <h2><a id="font_style"  href="article.php?id=<?= $tabB['post_id'];?>" ><?= (strlen($tabB['title']) > 20 ? substr($tabB['title'],0, 20) . '...' : $tabB['title']);?></a></h2>
                </div>
            </div>
<?php }?>
<!--tab_c 
            tab_b => is the value of category at table setting SQL 
            the container div of each gallary has a filter that respond 
            to the target name above[data-filter] 
            $setting ==> got it from header SQL

 -->
 <?php
        $tab_c = mysqli_query($connect, "SELECT * FROM `posts`
                                                              WHERE 
                                                                `status` = 'published'
                                                                AND
                                                                `category_id` = '$setting[tab_c]'
                                                                ORDER BY 
                                                                `post_id`
                                                                DESC 
                                                                LIMIT 
                                                               $setting[tab_c_value]     
                                                        ");
        while($tabC = mysqli_fetch_assoc($tab_c)){
?>
             <div class="thumbnail text-center gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter tab_c">
                <img src="<?= ($tabC['image'] == 'img/posts/default.jpg'?'img/posts/default_gallary.jpg': $tabC['image']);?>" 
                     style="width: 380px; height: 253px;"   
                     class="img-responsive">
                <div class="caption">
            <h2><a id="font_style"  href="article.php?id=<?= $tabC['post_id'];?>" ><?= (strlen($tabC['title']) > 20 ? substr($tabC['title'],0, 20) . '...' : $tabC['title']);?></a></h2>
                </div>
            </div>
<?php }?>
 <!--section_b 
            section_b => is the value of category at table setting SQL 
            the container div of each gallary has a filter that respond 
            to the target name above[data-filter] 
            $setting ==> got it from header SQL

 -->
 <?php
        $section_b = mysqli_query($connect, "SELECT * FROM `posts`
                                                              WHERE 
                                                                `status` = 'published'
                                                                AND
                                                                `category_id` = '$setting[section_b]'
                                                                ORDER BY 
                                                                `post_id`
                                                                DESC 
                                                                LIMIT 
                                                               $setting[section_b_value]     
                                                        ");
        while($sectionB = mysqli_fetch_assoc($section_b)){
?>
             <div class="thumbnail text-center gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter section_b">
                <img src="<?= ($sectionB['image'] == 'img/posts/default.jpg'?'img/posts/default_gallary.jpg': $sectionB['image']);?>" 
                     style="width: 380px; height: 253px;"   
                     class="img-responsive">
                <div class="caption">
            <h2><a id="font_style"  href="article.php?id=<?= $sectionB['post_id'];?>" ><?= (strlen($sectionB['title']) > 20 ? substr($sectionB['title'],0, 20) . '...' : $sectionB['title']);?></a></h2>
                </div>
            </div>
<?php }?>

            
        </div>
    </div>