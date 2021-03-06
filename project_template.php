<?php
  /*
  Template Name: Project Template
  */
?>

<html>
<head>
  <?php wp_head(); ?>
  <title>
    <?php wp_title( '|', true, 'right' ); ?>
  </title>
  <?php
  // use page slug as cat slug 
  global $post;
  $page_slug = $post->post_name;
  $cat_name= $page_slug;
  ?>
</head>

<body>
<div id="outer_wrapper">
  <div id="main_wrapper">

    <!-- Header -->
    <?php get_header(); ?>

    <div id="content">

<!-- report left margin value and slider value 
<div id="delta">asdasdasd</div>
-->
<!-- hack for iframe hover does not work 
due to cross-domain jquery funciton call 
this is not figured out, temp solution
does not work now cause its blocking acess to iframe
<div id="hover_block">
</div>
 -->

  <div class="scroll_bar_wrap">
    <div class="scroll_bar_up"></div>
    <div id="photo_slider"></div>
    <div class="scroll_bar_down"></div>
  </div>

  <div class="photo_container">
    <div class="photos">
      <?php
        $max_loop=0;
        $recents= $wpdb->get_results("SELECT post_title as title, ID as post_id, post_content as content, YEAR(post_date) as y
                                   FROM $wpdb->posts
                                   WHERE post_status = 'publish' AND post_type = 'post'
                                   ORDER BY post_date DESC");

        foreach($recents as $recent) {
          if(in_category($cat_name,$recent->post_id)){
          preg_match_all('/<img[^>]+>/i',$recent->content,$img_result);
          preg_match_all('/<iframe.*src=\"(.*)\".*><\/iframe>/isU',$recent->content,$iframe_result); 
          echo implode(" ",$iframe_result[0]);
            echo implode(" ",$img_result[0]);
          $max_loop++;
          if($max_loop==1){break;}
          }
        }
      ?>
    </div>
  </div>

  <div class="des clear">

    <div class="work_list">
      <ul class="years">
      <?php

      // once its goruped, only the first element will be displayed

      $years = $wpdb->get_results("SELECT post_title as title, ID as post_id, YEAR(post_date) as y
                            FROM $wpdb->posts
                            WHERE post_status = 'publish' AND post_type = 'post'
                            ORDER BY post_date DESC");
      //echo gettype($years);

      $prevYear = '';
      foreach($years as $year) {
            // was written to prevent repeat year display 
            if ($prevYear != $year->y&&in_category($cat_name,$year->post_id)){
              $prevYear = $year->y;
              echo "<li>";
              echo "<a href='javascript:;' onClick='year_to_post_titles(".$prevYear.",".json_encode($cat_name).")'>";
              echo $prevYear;
              echo "</a>";
              echo "</li>"; 
              echo " / ";
            }
      }
      ?>
      </ul>

      <ul class="work_items">
        <?php
        $max_loop=0;
        $month = array('','January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $work_items= $wpdb->get_results("SELECT post_title as title, ID as post_id, YEAR(post_date) as y, MONTH(post_date) as month
                                     FROM $wpdb->posts
                                     WHERE post_status = 'publish' AND post_type = 'post'
                                     ORDER BY post_date DESC");

        foreach($work_items as $work_item) {
          if(in_category($cat_name,$work_item->post_id)){
          echo "<li id='".$work_item->post_id."'>";
          echo "<a href='javascript:;' onClick='title_to_contents(".json_encode($work_item->post_id).",".json_encode($cat_name).")'>";
          echo "<span class='project_title'>".$work_item->title."</span>";
          echo "<span class='project_date'>".$work_item->y." / ".$month[$work_item->month]."</span>";
          echo "</a>";
          echo "</li>";
          $max_loop++;
          if($max_loop==4){break;}
          }
        }
        ?>
      </ul>
    </div>

    <div class="sub_des">
      <?php
      $max_loop=0;
      $recents= $wpdb->get_results("SELECT post_title as title, ID as post_id, post_content as content, YEAR(post_date) as y
                                   FROM $wpdb->posts
                                   WHERE post_status = 'publish' AND post_type = 'post'
                                   ORDER BY post_date DESC");

      foreach($recents as $recent) {
        if(in_category($cat_name,$recent->post_id)){
        echo "<h5 class='sub_des_title'>".$recent->title."</h5>"; 
        echo "<h6 class='sub_des_text'>".preg_replace("/&#?[a-z0-9]+;/i", "" , trim(strip_tags($recent->content)))."</h6>"; 
        $max_loop++;
        if($max_loop==1){break;}
        }
      }
      ?>
    </div>
  </div>

</div>

<?php get_footer();?>

</body>
</html>
