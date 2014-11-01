
$(document).ready(function(){

			var post_contents_js;
			var post_titles_js;
			var post_artworks_js;

			$.ajax({ url: NikkiAjax.ajaxurl,
			         data: {action: 'js_post_contents'},
			         type: 'post',
			         success: function(response) {
		                      post_contents_js=[
	    		 									response
	  											];
                          console.log(response);
			                  }
			});

      $.ajax({ url: NikkiAjax.ajaxurl,
               data: {action: 'js_post_titles'},
               type: 'post',
               success: function(response) {
                          post_titles_js=[
                            response
                          ];
                        }
      });

      $.ajax({ url: NikkiAjax.ajaxurl,
               data: {action: 'js_post_artworks'},
               type: 'post',
               success: function(response) {
                          post_artworks_js=[
                            response
                          ];
                        }
      });



      /* Slide Show
      ---------------------------------------------*/
      var slide_show_time = 5000;
      var timer = setInterval(function(){slide_show()},slide_show_time);

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


});
