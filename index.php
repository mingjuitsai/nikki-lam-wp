<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />


<link href="<?php bloginfo(template_directory) ?>/style.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/screen_header.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/minion_stylesheet.css" type="text/css" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo(template_directory) ?>/avant_garde_stylesheet.css" type="text/css" charset="utf-8" />
<script src="<?php bloginfo(template_directory) ?>/js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="<?php bloginfo(template_directory) ?>/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>

<title>Nikki Lam</title>

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
        <?php   echo strip_tags($post_contents[0]); ?>
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

<script>
      $(document).ready(function(){

      var post_contents_js=[
        /* store php post_contents array to js variable */  
        <?php js_post_contents(); ?>
      ];
      var post_titles_js= [
        /* store php post_titles array to js variable */  
        <?php js_post_titles();?>
      ];
      var post_artworks_js=[
        <?php js_post_artworks(); ?>
      ];

      /* slide_show setting
      ---------------------------------------------*/
      var slide_show_time= 8000;

      var timer=setInterval(function(){slide_show();},slide_show_time);

      $("#content").click(function(){
          slide_show();
      });
      $("#content").hover(function(){
          clearInterval(timer);},
          function(){
          timer=setInterval(function(){slide_show();},slide_show_time);
      });
      var post_text_id= 0; 
      var post_image_id= 1; 
      //insert images and prepare for slideshow
      for(i=0;i<post_artworks_js.length;i++){
        $(document.createElement("div"))
          .css({
            zIndex:post_artworks_js.length-i,
          })
          .addClass("artworks_block")
          .append(post_artworks_js[i])
          .appendTo("#slideshow_images");
      }

      //alert($("#slideshow_images").html());
      $("#slideshow_images .artworks_block").addClass('loading')
        // if there's iframe change to .children("img, iframe") or whatever post element is
        .children("img")
        .load(function(){
          $(this).parent("div:first").removeClass('loading');  
      });
                                   
      // hide test
      $('#slideshow_images .artworks_block:gt(0)').hide();
      //animate
      //$('#slideshow_images .loading_block:gt(0)').animate({opacity:0},0);
      //$('#slideshow_images .disabled_block:gt(0)').css({display:'block'});

      function slide_show(){
        
        var fade_out_speed=310;
        var fade_in_speed=300;
        var opacity_out=0.8;
        var opacity_in=1;
        
        // if there's only one post, do not play loop animation 
        if(post_artworks_js.length==1){
          return;
        }
        
        /*animate and loop titles*/
        $("#des_title").animate({opacity:opacity_out},fade_out_speed,function(){
        $("#des_title").html(post_titles_js[post_text_id]);
        $("#des_title").animate({opacity:opacity_in},fade_in_speed)});
        /*animate and loop contents*/
        $("#sub_des").animate({opacity:opacity_out},fade_out_speed,function(){
        $("#sub_des").html(post_contents_js[post_text_id]);
        $("#sub_des").animate({opacity:opacity_in},fade_in_speed)});
        /* animate and loop img*/
        
        $("#slideshow_images  .artworks_block:first").fadeOut(900).next('.artworks_block').fadeIn(500).end().appendTo("#slideshow_images");

          
        if(post_text_id+1==post_titles_js.length){
          post_text_id=0;
        }else{ 
          post_text_id++;
          }

      }

      //jquery ready ends
      });

    </script>

</body>
</html>
