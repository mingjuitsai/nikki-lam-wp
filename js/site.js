
$(document).ready(function(){
	
	// unlink nav that has children for sliding out
	$(".children").parent("li").find("a:first").attr("onclick","return false;");	
	
	var current= '.current_page_item ul, .current_page_item li, .current_page_parent ul, .current_page_ancestor';
	
	$('.current_page_ancestor a').animate({opacity:0.5},0);
	$('.current_page_item a').animate({opacity:0.9},0);
	
	//third method
	// height sets to as its content 
	// line height was set to as height for middle vertical alignment 
	var nav_height=$("#nav").height()+20+'px';
	$("#nav").css({"height":nav_height, "line-height":nav_height});
	
	$("#nav ul").not(current).hide();
	
	$("#nav li ").click(function(){		
		$(this).find(">ul").dequeue().animate({width:'show'},230);
		$(this).find(">ul").dequeue().animate({opacity:1},230);
		$(this).siblings("li").find(">ul").not(current).dequeue().animate({opacity:0},250);
	});
	
	$("#nav > li ").mouseleave(function(){
	$(this).find("ul").not(current).delay(200).dequeue().animate({opacity:0},250,function(){
		$(this).dequeue().animate({width:'hide'},160);
		});
	});

});
