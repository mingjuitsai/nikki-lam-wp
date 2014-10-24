

<?php include(TEMPLATEPATH.'/php/navigation_functions.php'); ?>
<?php //var_dump(error_reporting(E_ALL)); include(TEMPLATEPATH.'/php/simple_html_dom.php'); ?>


<header id="header">

  <div id="header_top">


    <div id="nikki_logo">
      <a href="<?php echo site_url(); ?>">
        <img src="<?php bloginfo(template_directory) ?>/images/logo_140.jpg" />
      </a>
    </div>

    <div id="nav_container">
      <nav id="nav">
        <?php
        $pages=wp_list_pages('title_li=');
        ?>
        <li>
          <a href="http://thecuriousother.blogspot.com/">
          BLOG
          </a>
        </li>
        <li id="nikki_fb">
          <a href="http://www.facebook.com/nikkilam.art">
          FB
          </a>
        </li>
      </nav>
    </div>


  </div>


</header>
