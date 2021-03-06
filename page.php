
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

  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <?php the_content('(read more...)') ?>


  <?php endwhile; else: ?>
  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
  <?php endif; ?>


</div>
</div>

<?php get_footer();?>


</body>
</html>
