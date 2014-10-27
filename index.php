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

<script>
      $(document).ready(function(){

      var post_contents_js=[
        /* get content, echo from php function to js object, see function.php */  
        <?php js_post_contents(); ?>
      ];
      var post_titles_js= [
        /* get title, echo from php function to js object, see function.php */  
        <?php js_post_titles();?>
      ];
      var post_artworks_js=[
        <?php js_post_artworks(); ?>
      ];

      /* Slide Show
      ---------------------------------------------*/
      var slide_show_time = 5000;
      var timer = setInterval(function(){slide_show()},slide_show_time);
      var timer2 = setInterval(function(){testing()},slide_show_time);

      function testing(){
        console.log("setinterval testing");
      }

      $("#content").click(function(){
          slide_show();
      });
      $("#content").hover(function(){
          clearInterval(timer);},
          function(){
          timer=setInterval(function(){slide_show()},slide_show_time);
      });
      var post_text_id= 0; 
      var post_image_id= 1; 

      // insert images and prepare for slideshow
      for(i=0;i<post_artworks_js.length;i++){
        $(document.createElement("div"))
          .css({
            zIndex:post_artworks_js.length-i,
          })
          .addClass("artworks_block")
          .append(post_artworks_js[i])
          .appendTo("#slideshow_images");
      }

      $("#slideshow_images .artworks_block").addClass('loading')
        // if there's iframe change to .children("img, iframe") or whatever post element is
        .children("img")
        .load(function(){
          $(this).parent("div:first").removeClass('loading');  
      });
                                   
      // hide test
      $('#slideshow_images .artworks_block:gt(0)').hide();

      /*
        Slide Show function 
      */
      function slide_show(){

        console.log( "sldieshow call" );
        // if there's only one post, do not play loop animation 
        if(post_artworks_js.length==1){
          return;
        }

        // set variables 
        var fade_out_speed=310;
        var fade_in_speed=300;
        var opacity_out=0.8;
        var opacity_in=1;
        
        /* animate and loop titles */
        $("#des_title").animate({opacity:opacity_out},fade_out_speed,function(){
          $("#des_title").html(post_titles_js[post_text_id]);
          $("#des_title").animate({opacity:opacity_in},fade_in_speed);
        });
        /* animate and loop contents */
        $("#sub_des").animate({opacity:opacity_out},fade_out_speed,function(){
          $("#sub_des").html(post_contents_js[post_text_id]);
          $("#sub_des").animate({opacity:opacity_in},fade_in_speed);
        });
        /* animate and loop img */   
        $("#slideshow_images .artworks_block:first").fadeOut(900).next('.artworks_block').fadeIn(500).end().appendTo("#slideshow_images");

        console.log("first: " + post_text_id + " - " + post_titles_js.length );
        if( post_text_id+1 == post_titles_js.length ){
          post_text_id = 0;
          console.log( post_text_id + " - " + post_titles_js.length );
        } else { 
          post_text_id++;
        }
      }

      //jquery ready ends
      });

    </script>

</body>
</html>
