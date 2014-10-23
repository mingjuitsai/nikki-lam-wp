<?php
/*
Template Name: Media Template
*/
?>

<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<script src="<?php bloginfo(template_directory) ?>/js/jquery-1.6.2.min.js " type="text/javascript"></script>
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/screen_header.css" type="text/css" charset="utf-8" />
<link href="<?php bloginfo(template_directory) ?>/screen_exhibition.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/minion_stylesheet.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/avant_garde_stylesheet.css" type="text/css" charset="utf-8" />
<?php include(TEMPLATEPATH.'/php/exhibition_functions.php'); ?>

<title>Nikki Lam<?php wp_title('|'); ?></title>
</head>

<body>

<div id="outer_wrapper">
<div id="main_wrapper">


<!-- header start -->
<?php get_header(); ?>
<!-- header finish -->

<!-- content start -->



<div id="content">


<?php
	$exhibition_query= new WP_Query('category_name="media"&showposts=10');	
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

<div class="des">
<div class="exhibition_title">
<?php the_title(); ?>
</div>

<div class="exhibition_desc">
<?php 

$content = trim(strip_tags(get_the_content(),'<a>')); 
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
echo $content;

?>
</div>
</div>
<!-- desc ends -->

</div>
<!-- single exhibition -->
<?php endwhile; ?>

</div>


<!-- content finish -->


</div>
</div>
<?php get_footer();?>


</body>
</html>
