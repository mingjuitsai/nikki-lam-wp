
$(document).ready(function(){

			var post_contents_js;
			var post_titles_js;
			var post_artworks_js;

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

      get_posts_Ajax ( 'js_post_contents', 'front_page_slideshow', function(response){post_contents_js=response});
      get_posts_Ajax ( 'js_post_titles', 'front_page_slideshow', function(response){post_titles_js=response});
      get_posts_Ajax ( 'js_post_artworks', 'front_page_slideshow', function(response){post_artworks_js=response; init_artworks(); init_slideshow(); });
      

      /* Slide Show
      ---------------------------------------------*/
      function init_slideshow(){
        var slide_show_time = 5000;
        var post_text_id= 0; 
        var post_image_id= 1;
        var timer = setInterval(function(){slide_show()},slide_show_time);

        $("#content").click(function(){
            slide_show();
        });
        $("#content").hover(function(){
            clearInterval(timer);},
            function(){
            timer=setInterval(function(){slide_show()},slide_show_time);
        });
      }
      
      // putting Ajax fetched img into DOM 
      function init_artworks(){
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
            $(".loading").removeClass('loading');  
          });
        // hide NOT first image 
        $('#slideshow_images .artworks_block:gt(0)').hide();
      }
      
      /*
        Slide Show rotation function 
      */
      function slide_show(){

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

        if( post_text_id+1 == post_titles_js.length ){
          post_text_id = 0;
        } else { 
          post_text_id++;
        }
      }


});
