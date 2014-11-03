<?php
/*
  Template Name: Exhibition Template
*/
?>

<html>

<head>
  <?php wp_head(); ?>
  <title>
    <?php wp_title( '|', true, 'right' ); ?>
  </title>
  <?php include(TEMPLATEPATH.'/php/exhibition_functions.php'); ?>

</head>

<body>

  <div id="outer_wrapper">
    <div id="main_wrapper">

      <!-- Header -->
      <?php get_header(); ?>

        <div id="content">
          <div id="ex_box">

            <?php
                // filter out what exhibition cat to get, depends on what page is on 
                $exhibition_query= new WP_Query('category_name="exhibition"&showposts=10');  
                while ($exhibition_query->have_posts()) : $exhibition_query->the_post();
            ?>
                    <div id="<?php the_ID(); ?>" class="single_exhibition">
                    
                      <div class="exhibition_image">
                        <?php 
                        //return content and grab <img>, echo string-lize array
                        // and display no image
                        preg_match_all('/<img[^>]+>/i',get_the_content(),$result); 
                        echo implode($result[0]);
                        ?>
                      </div>
                      <div class="exhibition_sec">
                        <h3 class="exhibition_title">
                          <?php the_title(); ?>
                        </h3>

                        <h5 class="ex_info_title">
                          location:
                        </h5>
                        <h5 class="ex_info_value">
                          <?php 
                          $meta=get_post_meta(get_the_ID(), 'location', true);
                          if($meta==''){echo "updates coming soon";}else{echo $meta;}
                          ?>
                        </h5>

                        <h5 class="ex_info_title">
                          date: 
                        </h5>
                        <h5 class="ex_info_value">
                          <?php 
                          $meta=get_post_meta(get_the_ID(), 'date', true);
                          if($meta==''){echo "updates coming soon";}else{echo $meta;}
                          ?>
                        </h5>

                        <h5 class="ex_info_title">
                          price: 
                        </h5>
                        <h5 class="ex_info_value">
                          <?php 
                          $meta=get_post_meta(get_the_ID(), 'price', true);
                          if($meta==''){echo "update coming soon";}else{echo $meta;}
                          ?>
                        </h5>
                        
                        <article class="exhibition_des">
                          <?php 
                          // this will prevent the get_the_content removing the paragraph tag
                          $content = trim(strip_tags(get_the_content()),'<&nbsp>'); 
                          $content = apply_filters('the_content', $content);
                          $content = str_replace(']]>', ']]&gt;', $content);
                          echo $content;
                          ?>
                        </article>
                          
                      </div>
                        
                        <?php 
                        // this function display all images and filter in and out of the sponsor images
                        // if no sponsors remove empty this div
                        get_contributor_logos(); 
                        ?>

                        <div class="contributor_logos">
                          <div class="sponsor_logos">
                          sponsored by:
                          </div>
                          <div class="fund_logos">
                          fund by:
                          </div>
                        </div>

                      <!-- desc ends -->
                    </div>
                    <!-- single exhibition -->
            <?php 
            //end the function here
            endwhile;
            ?>

          </div>
        </div>
    </div>
  </div>

<?php get_footer();?>

</body>
</html>
