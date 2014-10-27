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
              exhibition_loop('exhibition'); 
            ?>

          </div>
        </div>


    </div>

  </div>


<?php get_footer();?>

</body>
</html>
