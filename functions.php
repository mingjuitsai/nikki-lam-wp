<?php
function get_first_image() {
	global $post, $posts;
	$post_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$post_img = $matches [1] [0];
	return $post_img;} 
?>
<?php
function get_posts_info() {
	global $post;
	$category = get_the_category();
	$catID= $category[0]->cat_ID; 
	$arg= array( 'numberposts'=>10, 'category'=>$catID,'orderby'=>'post_date','post_status'=>'publish');
	$posts_info= get_posts($arg);   
	global $post_titles;
	global $post_contents;
	foreach( $posts_info as $post){
	setup_postdata($post);
	$post_titles[]= $post->post_title;
	$post_contents[]= $post->post_content;
}}
?>
<?php
//for function js_post_artworks
function get_post_artworks($post_num) {
	global $post_contents;
	$img=preg_match_all('/<img[^>]+>/i', $post_contents[$post_num], $img_matches);
	// if there's vimeo player, use it to grab vimeo information 
	//preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $post_contents[$post_num], $vimeo_matches);
	//$post_vimeo= implode(" ",$vimeo_matches[0]);
	$post_img = implode($img_matches[0]);	
	return $post_img;
	// and return both if needed
	//return $post_img.$post_vimeo;
	} 
?>
<?php
function js_post_contents(){
	global $post_contents;
	if (count($post_contents)>1){
	echo '"'.preg_replace('/\s\s+/', ' ', trim(strip_tags($post_contents[0]))).'"';
	for ($c=1; $c<count($post_contents); $c++){
	echo ','.'"'.preg_replace('/\s\s+/', ' ', trim(strip_tags($post_contents[$c]))).'"';
        }};
}
?>
<?php 
	function js_post_titles(){
	global $post_titles;
	if (count($post_titles)>1){
	echo '"'.$post_titles[0].'"';
	for ($i=1; $i<count($post_titles); $i++){
		echo ','.'"'.trim($post_titles[$i]).'"';
	}};
}
?>
<?php 
function js_post_artworks(){
	global $post_contents;
	if (count($post_contents)>=1){
	echo "'".get_post_artworks(0)."'";
	for ($a=1; $a < count($post_contents); $a++){
	echo ","."'".get_post_artworks($a)."'";
    }};
}
?>
<?php
add_action('wp_ajax_year_to_post_titles', 'year_to_post_titles_callback');
add_action('wp_ajax_nopriv_year_to_post_titles', 'year_to_post_titles_callback');
function year_to_post_titles_callback(){
	//formatting the Months displays
	$month = array('','January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    global $wpdb;
	$which_year=$_POST["y"];
	$which_cat=$_POST["cat"];
	$titles = $wpdb->get_results("SELECT YEAR( post_date ) AS year,post_title as title, MONTH( post_date ) as month, ID as post_id
												FROM $wpdb->posts 
												WHERE post_status = 'publish' and post_type = 'post'
												ORDER BY post_date DESC");
	foreach($titles as $var_title){
		//filter if it's selected year and in category 
		if($var_title->year==$which_year&&in_category($which_cat,$var_title->post_id)){
		$id =json_encode($var_title->post_id);
		echo "<li id='".$var_title->post_id."'>";
		echo "<a href='javascript:;' onClick='title_to_contents(".$id.",".json_encode($which_cat).")'>";
		echo "<span class='project_title'>".$var_title->title."</span>";
		echo "<span class='project_date'>". $var_title->year."  / ". $month[$var_title->month]."</span>";
		echo "</a></li>";
		} 
	}
	die();
}
?>
<?php
add_action('wp_ajax_title_to_contents', 'title_to_contents_callback');
add_action('wp_ajax_nopriv_title_to_contents', 'title_to_contents_callback');
function title_to_contents_callback(){
    global $wpdb;
	global $content_text;
	$which_ID=$_POST["id"];
	$which_cat=$_POST["cat"];
	
	$contents = $wpdb->get_results("SELECT YEAR( post_date ) AS year,ID as post_id,post_content as content, post_title as title 
												FROM $wpdb->posts 
												WHERE post_status = 'publish' and post_type = 'post'
												ORDER BY post_date DESC");
	foreach($contents as $var_content){
		if($var_content->post_id==$which_ID){
		// enable jquery have access to php variables
			$content=$var_content->content;
			//get content and match all img 
			preg_match_all('/<img[^>]+>/i',$var_content->content,$result);
			preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU',$var_content->content,$iframe_result); 
			$content_title=$var_content->title;
			$content_image=implode(" ",$result[0]);
			$content_vimeo=implode(" ",$iframe_result[0]);
			$content_text=preg_replace('/\s\s+/', ' ', trim(strip_tags($var_content->content)));
			echo json_encode(array(
								   			"content_title"=>$content_title,
											"content"=>$content,
											"content_text"=>$content_text,
											"content_image"=>$content_image,
											"content_vimeo"=>$content_vimeo,
											"content_cat"=>$which_cat
										));
			break;
		} 
	}
	die();
}
?>