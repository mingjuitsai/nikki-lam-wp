


<?php function get_contributor_logos(){ 

?>

<script type="text/javascript">
$(document).ready(function(){
	// individually filter out sponsor and exhibition images
	$("#<?php the_ID(); ?> .exhibition_image").find("img[alt=sponsor]").appendTo("#<?php the_ID(); ?> .sponsor_logos");
	$("#<?php the_ID(); ?> .exhibition_image").find("img[alt=funding]").appendTo("#<?php the_ID(); ?> .fund_logos");
	//if no exhibition image, Display no image sign 
	if($("#<?php the_ID(); ?> .exhibition_image").find("img").size()==0){
	$("#<?php the_ID(); ?> .exhibition_image").append("<img src='<?php bloginfo(template_directory) ?>/images/noImage.jpg'>");
	}
	
	// if no sponsor do not display sponsored by 
	if($("#<?php the_ID(); ?> .sponsor_logos").find("img").size()==0){
		$("#<?php the_ID(); ?> .sponsor_logos").empty();
	}
	if($("#<?php the_ID(); ?> .fund_logos").find("img").size()==0){
		$("#<?php the_ID(); ?> .fund_logos").empty();
		}
});
</script>
<?php }?>

<!-- // this function generate post loops, 
create contents for exhibition, it's basically wordpress loop-->
<?php
	function exhibition_loop($ex_cat){ 
		// filter out what exhibition cat to get, depends on what page is on 
		$exhibition_query= new WP_Query('category_name="'.$ex_cat.'"&showposts=10');	
		while ($exhibition_query->have_posts()) : $exhibition_query->the_post();
?>
        <div id="<?php the_ID(); ?>" class="single_exhibition">
        
        <div class="exhibition_image">
        <?php 
        //return content and grab <img>, echo string-lize array
        // and display no image
        preg_match_all('/<img[^>]+>/i',get_the_content(),$result); 
        echo implode($result[0]);
        ?>
        </div>
        <div class="des">
        <div class="exhibition_title">
        <?php the_title(); ?>
        </div>
        <div class="exhibition_desc">
        
        <!-- info section -->
        <div class="exhibition_info">
        
            <div class="ex_info_div">
            <div class="ex_info_title">
            location:
			</div><!--
            --><div class="ex_info_value">
			<?php 
			$meta=get_post_meta(get_the_ID(), 'location', true);
			if($meta==''){echo "updates coming soon";}else{echo $meta;}
			?>
            </div>
            </div>
            
            <div class="ex_info_div">
            <div class="ex_info_title">
            date: 
			</div><!--
            --><div class="ex_info_value">
			<?php 
			$meta=get_post_meta(get_the_ID(), 'date', true);
			if($meta==''){echo "updates coming soon";}else{echo $meta;}
			?>
            </div>
            </div>
            
            <div class="ex_info_div">
            <div class="ex_info_title">
            price: 
			</div><!--
            --><div class="ex_info_value">
			<?php 
			$meta=get_post_meta(get_the_ID(), 'price', true);
			if($meta==''){echo "update coming soon";}else{echo $meta;}
			?>
            </div>
            </div>
        
        </div>
        
		<?php 
		// this will prevent the get_the_content removing the paragraph tag
        $content = trim(strip_tags(get_the_content()),'<&nbsp>'); 
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        echo $content;
        ?>
        </div>
        <?php 
			// this function display all images and filter in and out of the sponsor images
			// if no sponsors remove empty this div
		   get_contributor_logos(); 
        ?>
        <div class="contributor_logos">
        <div class="sponsor_logos">
        sponsored by:
        </div>
        <div class="fund_logos">
        fund by:
        </div>
        </div>
        
        </div>
        <!-- desc ends -->
        </div>
        <!-- single exhibition -->
<?php 
//end the function here
endwhile;
} 
?>



<script type="text/javascript">


$(document).ready(function(){
	// default exhibition div current showing
	var default_ex='ex_current';
	$("#"+default_ex).siblings().hide();
	
	// this is exhibition list
	$("."+default_ex).css({color:'#70008c'});
	$("."+default_ex).siblings().css({color:'#c7c1ce'});
	$("#exhibition_period li").click(function(){
		$(this).css({color:'#70008c'}).siblings().css({color:'#c7c1ce'});
		$("#"+$(this).attr("class")).show().siblings().hide();
		footer_check();
	});
		
	//footer layout fix, tem pos
	function footer_check(){
		var body_height=$('body').height();
		var wrapper_height=$('#outer_wrapper').height();
		if (wrapper_height < body_height){
		$("#footer").css({position:'absolute',bottom:'0'});
		}else{$("#footer").css({position:'relative'});}
	}
	
	//for media adding link new window
	$(".exhibition_desc").find("a").attr({target:'_blank'});
	
});


</script>


