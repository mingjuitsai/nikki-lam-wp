
$(document).ready(function(){

			var post_contents_obj;
			var post_titles_obj;
			var post_artworks_obj;

      function get_posts_Ajax( act , cat , callback ){
        $.ajax({ 
                url: NikkiAjax.ajaxurl,
                data: {action: act, category: cat},
                type: 'post',
                dataType: "json",
                success: function(response) {
                    if(typeof callback === 'function'){callback.call(this, response)};
                }
        });
      }

      get_posts_Ajax ( 'js_fetch_catPosts', 'front_page_slideshow', function(response){
        post_contents_obj = response.post_contents_json; 
        post_titles_obj   = response.post_titles_json;
        post_artworks_obj   = response.post_artworks_json;  

        init_artworks(); 
        init_slideshow(); 
      });
      

      /* Slide Show
      ---------------------------------------------*/
      // global variables
      var time_slow = 5000;
      var post_text_id= 0; 
      var post_image_id= 1;
      

      function init_slideshow(){
        
        var slideshow_timer;
        slideshow_timer = setInterval(function(){slide_show();},time_slow);

        $("#content").click(function(){
            clearInterval(slideshow_timer);
            slide_show();
            slideshow_timer = setInterval(function(){slide_show();},time_slow);
        });

      }
      
      // putting Ajax fetched img into DOM 
      function init_artworks(){
        // insert images and prepare for slideshow
        for(i=0;i<post_artworks_obj.length;i++){
          $(document.createElement("div"))
            .css({
              zIndex:post_artworks_obj.length-i,
            })
            .addClass("artworks_block")
            .append(post_artworks_obj[i])
            .appendTo(".slideshow_images_jshook");
        }

        $(".slideshow_images_jshook .artworks_block")
          // if there's iframe change to .children("img, iframe") or whatever post element is
          .children("img")
          .load(function(){
            $(".loading").removeClass('loading');  
          });
        // hide NOT first image 
        $('.slideshow_images_jshook .artworks_block:gt(0)').hide();
      }
      
      /*
        Slide Show rotation function 
      */
      function slide_show(){

        // if there's only one post, do not play loop animation 
        if(post_artworks_obj.length==1){
          return;
        }

        // set variables 
        var fade_out_speed=310;
        var fade_in_speed=300;
        var opacity_out=0.8;
        var opacity_in=1;
        
        /* animate and loop titles */
        $(".des_title").dequeue().stop().animate({opacity:opacity_out},fade_out_speed,function(){
          $(".des_title").html(post_titles_obj[post_text_id]);
          $(".des_title").dequeue().stop().animate({opacity:opacity_in},fade_in_speed);
        });
        /* animate and loop contents */
        $(".sub_des").dequeue().stop().animate({opacity:opacity_out},fade_out_speed,function(){
          $(".sub_des").html(post_contents_obj[post_text_id]);
          $(".sub_des").dequeue().stop().animate({opacity:opacity_in},fade_in_speed);
        });
        /* animate and loop img */   
        $(".slideshow_images_jshook .artworks_block:first").fadeOut(900).next('.artworks_block').fadeIn(500).end().appendTo(".slideshow_images_jshook");

        if( post_text_id+1 == post_titles_obj.length ){
          post_text_id = 0;
        } else { 
          post_text_id++;
        }
      }


});
