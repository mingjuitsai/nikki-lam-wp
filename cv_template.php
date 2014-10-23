<?php
/*
Template Name: CV Template
*/
?>

<html>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<head>
<script src="<?php bloginfo(template_directory) ?>/js/jquery-1.6.2.min.js " type="text/javascript"></script>
<link href="<?php bloginfo(template_directory) ?>/screen_cv.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/screen_header.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/minion_stylesheet.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/avant_garde_stylesheet.css" type="text/css" charset="utf-8" />

<title>Nikki Lam</title>
</head>

<body>

<div id="outer_wrapper">
<div id="main_wrapper">


<!-- header start -->
<?php get_header(); ?>
<!-- header finish -->

<div id="content">

<div id="cv">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php the_content('(read more...)') ?>


<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>


</div>
</div>

<?php get_footer();?>


</body>
</html>
