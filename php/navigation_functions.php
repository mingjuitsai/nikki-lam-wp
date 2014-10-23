
<script type="text/javascript">

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

	
	// second possible method for slideing nav 
	/*
	var nav_width=new Array();
	var nav_class=new Array();
	var nav_index=0;
	var ul;
	
	$.each($("#nav > li"),function(){
	var temp_nav_class=new Array();
	var temp_nav_width=new Array();
	$(this).attr("title",nav_index);
	nav_index++;
	
	temp_nav_class.push(String($(this).attr("class")).split(" ")[1]);
	temp_nav_width.push($(this).width());
	for(ul=">ul";$(this).find(ul).length!=0;ul+=">li>ul"){
	
	//alert("find length: "+$(this).find(ul).length);
	//temp_nav_class.push(String($(this).find(ul).attr("class")));
	temp_nav_width.push($(this).find(ul).width());
	$(this).find(ul).animate({opacity:0,width:'0',padding:'0'},0);	
	}

	nav_width.push(temp_nav_width.slice(0));
    nav_class.push(temp_nav_class.slice(0));
	temp_nav_width.length=0;
	temp_nav_class.length=0;
	});
	
	var root_index;
	var depth=1;
	
	$("#nav li").click(function(e){
		//find level of child 
		var target= $(e.target).attr("class");
		root_index=$(this).attr("title");
		var length=nav_width[root_index].length;
		
		if(length==2||length==depth+1){
			
			ul_width=nav_width[root_index][depth]+"px";
			}else{
				//$("."+$(e.target).parent("li:first").attr("class").split(" ")[1]).dequeue().stop().animate({width:'+='+ul_width,opacity:1},400);

				ul_width=parseInt(nav_width[root_index][depth])-parseInt(nav_width[root_index][depth+1])+"px";
			}
		//alert(nav_class[root_index]);
		//alert(nav_class[root_index][depth-1]);
		//alert("depth: "+depth);
			
		
		$("."+$(e.target).parent("li:first").attr("class").split(" ")[1]+" > .children").dequeue().stop().animate({width:ul_width,opacity:1},400);

		//$("."+nav_class[root_index][depth-1]+" > .children").css("background","yellow");
		if(length==depth+1){
			return;
			}else{
				depth++;
			}
		});
	
	$("#nav > li").mouseout(function(){
	//$("#nav > li > ul").dequeue().stop().animate({opacity:0,width:'0px',padding:'0'},0);	
	});
	*/

});


</script>