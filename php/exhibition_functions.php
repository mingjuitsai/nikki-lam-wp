<?php function get_contributor_logos(){ ?>

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
<?php } ?>

<!-- // this function generate post loops, 
create contents for exhibition, it's basically wordpress loop-->


