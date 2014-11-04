
$(document).ready(function(){

	// unlink nav that has children for sliding out
	$(".children").parent("li").find("a:first").attr("onclick","return false;");	
	
	$(".nav li").click(function(){		
		$(this).find(">.children").addClass('active');
		$(this).siblings("li").find(">ul").not(current).dequeue().animate({opacity:0},250);
	});
	
	$(".nav > li").not(".current_page_ancestor").mouseleave(function(){
		$(this).find(">.children").removeClass('active');
	});

});
