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
  <?php //include(TEMPLATEPATH.'/php/exhibition_functions.php'); ?>

</head>

<body>

  <div id="outer_wrapper">
    <div id="main_wrapper">

      <!-- Header -->
      <?php get_header(); ?>

        <div id="content">

            <?php
                // filter out what exhibition cat to get, depends on what page is on 
                $exhibition_query= new WP_Query('category_name="exhibition"&showposts=10');  
                while ($exhibition_query->have_posts()) : $exhibition_query->the_post();
            ?>
                    <div id="<?php the_ID(); ?>" class="single_exhibition">
                    
                      <section class="exhibition_image">
                        <?php 
                        // return content and grab <img>, echo string-lize array
                        // and display no image
                        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $result ); 
                        ?>
                        <img src="<?php echo $result[1][0]; ?>" alt="exhibition image">
                      </section>

                      <section class="exhibition_sec">
                        <h3 class="exhibition_title">
                          <?php the_title(); ?>
                        </h3>
                      
                        <div class="ex_info_row">
                          <h5 class="ex_info_title">
                          location:
                          </h5>
                          <h5 class="ex_info_value">
                            <?php 
                            $meta=get_post_meta(get_the_ID(), 'location', true);
                            if($meta==''){echo "updates coming soon";}else{echo $meta;}
                            ?>
                          </h5>
                        </div>
                        
                        <div class="ex_info_row">
                          <h5 class="ex_info_title">
                            date: 
                          </h5>
                          <h5 class="ex_info_value">
                            <?php 
                            $meta=get_post_meta(get_the_ID(), 'date', true);
                            if($meta==''){echo "updates coming soon";}else{echo $meta;}
                            ?>
                          </h5>
                        </div>

                        <div class="ex_info_row">
                          <h5 class="ex_info_title">
                            price: 
                          </h5>
                          <h5 class="ex_info_value">
                            <?php 
                            $meta=get_post_meta(get_the_ID(), 'price', true);
                            if($meta==''){echo "update coming soon";}else{echo $meta;}
                            ?>
                          </h5>
                        </div>
                        
                        <article class="exhibition_des">
                          <?php 
                          // this will prevent the get_the_content removing the paragraph tag
                          $content = trim(strip_tags(get_the_content()),'<&nbsp>'); 
                          $content = apply_filters('the_content', $content);
                          $content = str_replace(']]>', ']]&gt;', $content);
                          echo $content;
                          ?>
                        </article>
                          
                      </section>
                      
                      <!-- 
                        Hiding non-sponsor or non-funding pic with CSS
                      -->
                        <div class="contributor_logos">
                          <div class="sponsor_logos">
                          sponsored by:
                            <?php 
                              preg_match_all('/<img[^>]+>/i', get_the_content(), $result ); 
                              echo implode($result[0]);
                            ?>
                          </div>
                          <div class="fund_logos">
                          fund by:
                            <?php 
                              preg_match_all('/<img[^>]+>/i', get_the_content(), $result ); 
                              echo implode($result[0]);
                            ?>
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

<?php get_footer();?>

</body>
</html>
