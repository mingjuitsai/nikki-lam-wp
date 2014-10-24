<?php
/*
Template Name: Exhibition Template
*/
?>

<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />


<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/screen_header.css" type="text/css" charset="utf-8" />
<link href="<?php bloginfo(template_directory) ?>/screen_exhibition.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/minion_stylesheet.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/avant_garde_stylesheet.css" type="text/css" charset="utf-8" />
<?php include(TEMPLATEPATH.'/php/exhibition_functions.php'); ?>
<script src="<?php bloginfo(template_directory) ?>/js/jquery-1.6.2.min.js " type="text/javascript"></script>

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


<div id="ex_box">

<?php
if(is_page('CURRENT')){
	exhibition_loop('exhibition_current'); 
}
if(is_page('PAST')){
	exhibition_loop('exhibition_past'); 
}
if(is_page('UPCOMING')){
	exhibition_loop('exhibition_upcoming'); 
}

?>

</div>
<!-- ex box -->

</div>

<!-- content finish -->


</div>

</div>
</div>
<?php get_footer();?>


</body>
</html>
