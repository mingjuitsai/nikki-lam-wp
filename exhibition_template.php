<?php
/*
  Template Name: Exhibition Template
*/
?>

<html>

<head>

  <?php get_header("head"); ?>
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
        </div>


    </div>

  </div>


<?php get_footer();?>

</body>
</html>
