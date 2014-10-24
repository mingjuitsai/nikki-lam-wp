
<script type="text/javascript">

// function CSS changes for years and projects selection

var requested;
// this trim the excessive titles
function trim_title(html){
	var int_title=new String(html);
	var return_title=int_title.substring(0,24)+"...";
	//alert(return_title);
	if(int_title.length<18){
		return;
	}else{
	return return_title;
	}
}

$(document).ready(function(	){
	$("#years li").click(function(){
		$(this).siblings("li").css({'background':'none'});
		$(this).css({'background':'#faee9b'});	
	});
	
	//set first element as requested item 
	requested=$("#work_items li:first").attr('id');
	
	// request item animate as selected, temp
	$("#"+requested).animate({opacity:0.6},100);
	
	$("#work_items li").click(function(){
		$(this).siblings("li").animate({opacity:1},100);
		$(this).animate({opacity:0.6},100);
	});
	
	//trim excessive titles here
	$.each($("#work_items").find(".project_title"),function(){
					$(this).html(trim_title($(this).html()));
			});
	
	$("#photos").children("img, iframe").wrap($('<div>',{"class":"loading"})).load(function(){
					$(this).parent("div:first").removeClass('loading');	
					//$(this).animate({opacity:0},300);
	});
	
});


function year_to_post_titles(year,cat_name){
	$(document).ready(function(){
	
	//alert("year to post");
	var data={
		action:'year_to_post_titles',
		y: year,
		cat:cat_name
	};
	$.post("<?php echo admin_url('admin-ajax.php'); ?>", data,function(response){
			//hide it first 
			$("#work_items").animate({height:'hide',opacity:0},300,function(){
										// update html 
										$(this).html(response);
										// trim excessive title name
										$.each($("#work_items").find(".project_title"),function(){
											$(this).html(trim_title($(this).html()));
										});
										// request item animate as selected, temp
										$("#"+requested).animate({opacity:0.6},100);
										// show it !
										$(this).animate({height:'show',opacity:1},500);
									});
		
			
			
			// loading finished,  each time work_items renew, this will be called
			$("#work_items li").click(function(){
			$(this).siblings("li").animate({opacity:1},100);
			$(this).animate({opacity:0.4},100);
			});
		}
	);
});
//jQuery ready ends
}


//title to content, update description and images, via animation 
function title_to_contents(post_id,cat_name){
	$(document).ready(function(){
		if (requested==post_id){
			return;
			}else{
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
		$.post("<?php echo admin_url('admin-ajax.php'); ?>",data,function(response){
			//loading animation and html DOM change 
			$("#sub_des").animate({height:'hide',opacity:0},300,function(){
			var content_text=response.content_text;
			var content_title=response.content_title;
			$(".sub_des_title").html(content_title);
			$(".sub_des_text").html(content_text);
			$("#sub_des").animate({height:'show',opacity:1},300);

			});
			var content_img=response.content_image;
			var content_vimeo=response.content_vimeo;
			var content_cat=response.content_cat;
			//alert(content_img);
			//var content_img=$('<div>').append($(response.content).find("img").clone()).remove().html();
			if(content_cat.indexOf('photography')!=-1){
					$("#photos").html(content_img);
				}else if(content_cat=='project'){
					$("#photos").html(content_vimeo+content_img)
										// add class to all the iframes
									   .find("iframe").addClass("vimeo");
				}
			// if content is not wider than 600px hide previous shown scrollbar
			if(	$("#photos").innerWidth() <=600){
				$(".scroll_bar_wrap").dequeue().animate({opacity:0},200);
			}
			
			$("#photos").children("img, iframe").wrap($('<div>',{"class":"loading"})).load(function(){
					$(this).parent("div:first").removeClass('loading');	
					//$(this).animate({opacity:0},300);
					//alert($(this).parent("div:first").attr("class"));
					});
		
			//alert($("#photos").html());
			// reset slider and photo marginLeft
			$("#photo_slider").slider('value',100);
			$("#photos").dequeue().animate({marginLeft:0},330);
		
			//$("#photos").animate({opacity:0},300);
		
		},"json");
	});
}

/*  slider functions  mouse enter fade in */

$(document).ready(function(){
	var fade_timer;
	function onmousestop(){
		$(".scroll_bar_wrap").dequeue().animate({opacity:0},500);
	}
	
	$(".scroll_bar_wrap").animate({opacity:0},0);
	
	
	$("#content").mousemove(
		function(){
			// if no scroll needed hide prev shown scroll bar and return do not show
			if(	$("#photos").innerWidth() <=600){
				$(".scroll_bar_wrap").dequeue().animate({opacity:0},400);
				return;
			}
			
			$(".scroll_bar_wrap").dequeue().animate({opacity:1},400);
			clearTimeout(fade_timer);
			fade_timer=setTimeout(onmousestop,6000);
	});
	
	$("#content").mouseleave(
		function(){
			// if no scroll needed do not operate
			if(	$("#photos").innerWidth() <=600){
				return;
			}
			$(".scroll_bar_wrap").dequeue().animate({opacity:0},400);
	});			
	
	//get it out of way when click so have access to vimeo player 
	$("#hover_block").mousedown(function(){
		$(this).css({"pointer-events":"none"});
	});
	// up its back 
	$("#hover_block").mouseup(function(){
		$(this).css({"pointer-events":"auto"});
	});
	
	
});


$(function() {
	$("#photo_slider").slider({
		orientation:'vertical',
		min: 0,
    	max: 100,
    	value:100,
		range: "max",
		slide:function(e,ui){
					// slider is sliding the div scroll across too 
					var slide_left=-($("#photos").innerWidth()-600)*(1-(ui.value/100));
					$("#photos").dequeue().animate({marginLeft:slide_left},200);
		},
		stop:function(e,ui){
						// this get ride of the release outside slider and still drag 
						return false;
		}
	});
	
	$("#content , #photo_slider").mousewheel(function ( e , delta ) {
    var delta = 0, element = $("#photo_slider"), value, left;
    value = element.slider('value');
    if (e.wheelDelta) {
        delta = e.wheelDelta;
    }
	//alert(delta + "value: " + value);
	if(e.deltaY){
	    delta= e.deltaY;
	}
	e.preventDefault();

	console.log ("delta: " + delta );
	value += delta*4;
    if (value > 100) {
        value = 100;
    }
    if (value < 0) {
        value = 0;
    }    
	element.slider('value',value);
	// minus 600 to 
	var left=-($("#photos").innerWidth()-600)*(1-(value/100));
	// left > 0 means the #photos innerWidth is smaller than 600px, image inside is smaller than 600px
	// then do not move the #photo at all 
	if(left>0){return;}
	
	$("#photos").dequeue().animate({marginLeft:left},200);
		
	
	//this div reports delta 
	//$("#delta").html("left:  "+left+"  value:  "+value);
		
});
});

</script>