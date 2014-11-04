
// function CSS changes for years and projects selection
var requested, int_title, return_title, container_width;
// this trim the excessive titles
function trim_title(html) {
  int_title = new String(html);
  return_title = int_title.substring( 0, 24 )+"...";
  //alert(return_title);
  if( int_title.length<18 ){
    return;
  } else{
    return return_title;
  }
}
// get photo container dynamic width


/*
  Public Functions 
*/

/*  Scroll Slider Mouse functions fade-in out */
var fade_timer;
var fade_time = 6000;
var photo_width;

function scollbar_inactive() {
  $(".scroll_bar_wrap").removeClass('active');
}

function scrollbar_mouseEvent() {

   photo_width = $(".photos").innerWidth();

    $("#content").mousemove(function(){
      if($(".scroll_bar_wrap").hasClass('active')){
        return;
      } else if( photo_width > container_width){
        $(".scroll_bar_wrap").addClass('active');
        clearTimeout(fade_timer);
        fade_timer = setTimeout(scollbar_inactive,fade_time);
      } 
    });

    $("#content").mouseleave(function(){
      scollbar_inactive();
    });
}


$(document).ready(function(){

  container_width = $(".photo_container").width();

  $(".years li").click(function(){
    $(this).siblings("li").removeClass('active');
    $(this).addClass("active");
  });
  
  //set first element as requested item 
  requested=$(".work_items li:first").attr('id');
  
  // request item animate as selected, temp
  $("#"+requested).animate({opacity:0.6},100);
  
  $(".work_items li").click(function(){
    $(this).siblings("li").removeClass('active');
    $(this).addClass("active");
  });
  
  //trim excessive titles here
  $.each($(".work_items").find(".project_title"),function(){
          $(this).html(trim_title($(this).html()));
  });
  
  $(".photos").children("img, iframe").wrap($('<div>',{"class":"loading"})).load(function(){
    $(this).parent("div:first").removeClass('loading'); 
  });
  
  
  // Activate mouseEvent
  scrollbar_mouseEvent();


  //get it out of way when click so have access to vimeo player 
  $("#hover_block").mousedown(function(){
    $(this).css({"pointer-events":"none"});
  });
  // up its back 
  $("#hover_block").mouseup(function(){
    $(this).css({"pointer-events":"auto"});
  });

  $("#photo_slider").slider({
    orientation:'vertical',
    min: 0,
    max: 100,
    value:100,
    range: "max",
    slide:function(e,ui){
          // slider is sliding the div scroll across too 
          var slide_left=-($(".photos").innerWidth()-container_width)*(1-(ui.value/100));
          $(".photos").dequeue().animate({marginLeft:slide_left},200);
    },
    stop:function(e,ui){
            // this get ride of the release outside slider and still drag 
            return false;
    }
  });
  
  $("#content , #photo_slider").mousewheel(function (e , delta) {

      var delta = 0, element = $("#photo_slider"), value, left;
      value = element.slider('value');

      if (e.wheelDelta) {
          delta = e.wheelDelta;
      }
      if(e.deltaY){
          delta= e.deltaY;
      }
      e.preventDefault();

      value += delta*5;
      if (value > 100) {
          value = 100;
      }
      if (value < 0) {
          value = 0;
      }    
      element.slider('value',value);
      // minus container_width to 
      var left=-($(".photos").innerWidth()-container_width)*(1-(value/100));
      // left > 0 means the .photos innerWidth is smaller than container_widthpx, image inside is smaller than container_widthpx
      // then do not move the #photo at all 
      if(left>0){return;}
      
      $(".photos").dequeue().animate({marginLeft:left},20);
    });

});


function year_to_post_titles(year,cat_name){
  
  var data={
    action:'year_to_post_titles',
    y: year,
    cat:cat_name
  };
  $.post(NikkiAjax.ajaxurl, data,function(response){
      //hide it first 
      $(".work_items").animate({height:'hide',opacity:0},300,function(){
        // update html 
        $(this).html(response);
        // trim excessive title name
        $.each($(".work_items").find(".project_title"),function(){
          $(this).html(trim_title($(this).html()));
        });
        // request item animate as selected, temp
        $("#"+requested).animate({opacity:0.6},100);
        // show it !
        $(this).animate({height:'show',opacity:1},500);
      });
 
      // loading finished,  each time work_items renew, this will be called
      $(".work_items li").click(function(){
        $(this).siblings("li").animate({opacity:1},100);
        $(this).animate({opacity:0.4},100);
      });
    });
}


//title to content, update description and images, via animation 
function title_to_contents( post_id,cat_name ){

    $(".photo_container").addClass("loading-fade");

    if (requested==post_id){
      return;
    } else {
      requested=post_id;
    }
    // requested item animate to selected
    $("#"+requested).animate({opacity:0.6},100);
    $("#"+requested).siblings("li").animate({opacity:1},100);

    var data={
      action:'title_to_contents',
      cat:cat_name,
      id:post_id
    };

    //must specify data type 'json'
    $.post(NikkiAjax.ajaxurl,data,function(response){

      $(".photo_container").removeClass("loading-fade");

      //loading animation and html DOM change 
      $(".sub_des").animate({height:'hide',opacity:0},300,function(){
        var content_text=response.content_text;
        var content_title=response.content_title;
        $(".sub_des_title").html(content_title);
        $(".sub_des_text").html(content_text);
        $(".sub_des").animate({height:'show',opacity:1},300);
      });

      var content_img=response.content_image;
      var content_vimeo=response.content_vimeo;
      var content_cat=response.content_cat;

      
      $(".photos").html(content_vimeo+content_img)
      // add class to all the iframes
      .find("iframe").addClass("vimeo");
      
      // Updating Photo Width in relation to Scroll bar Slider 
      photo_width = $(".photos").innerWidth();
      
      $(".photos").children("img, iframe").wrap($('<div>',{"class":"loading"})).load(function(){
        $(this).parent("div:first").removeClass('loading'); 
      });
    
      // reset slider and photo marginLeft
      $("#photo_slider").slider('value',100);
      $(".photos").dequeue().animate({marginLeft:0},330);
    
    },"json");
}



  
  
