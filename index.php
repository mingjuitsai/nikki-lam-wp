<html>
<head>
  <?php wp_head(); ?>
  <title>
    <?php wp_title( '|', true, 'right' ); ?>
  </title>
</head>

<body>


<div id="outer_wrapper">

  <div id="main_wrapper">

    <!-- Header -->
    <?php get_header(); ?>


    <div id="content">
      
      <?php
            $myquery= new WP_Query('category_name="front_page_slideshow"&showposts=1');
      ?>
      <?php
        while ($myquery->have_posts()) : $myquery->the_post();
      ?>
       <?php 
          /* get posts titles, contents
          from front_page_slideshow category
          store in php array $post_contents, $post_titles */
          get_posts_info();
      ?>

    <div id="images_container">
      <div id="slideshow_images">
      </div>
    </div>

    <div id="des">

      <div id="des_title">
        <?php echo $post_titles[0]; ?>
      </div>

      <div id="sub_des">
        <?php echo strip_tags($post_contents[0]); ?>
      </div>

    </div>
    </div>

  <!-- Content end -->

  <?php endwhile; ?>

  

<!-- Loop end -->
</div>
<!-- Main wrapper end -->
</div>
<!-- outer wrapper end -->
<?php get_footer();?>

</body>
</html>
