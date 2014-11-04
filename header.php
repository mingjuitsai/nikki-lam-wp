
<header id="header">

  <div id="header_top">
    <a class="site-url" href="<?php echo site_url(); ?>">
      <div class="site-logo">
        <h1 class="nikki">NIKKI</h1>
        <h1 class="lam">LAM</h1>
      </div>
    </a>

    <div id="nav_container">
      <nav class="nav">
        <?php
        $pages=wp_list_pages('title_li=');
        ?>
        <!-- <li>
          <a href="http://thecuriousother.blogspot.com/">
          BLOG
          </a>
        </li> -->
        <li id="nikki_fb">
          <a href="http://www.facebook.com/nikkilam.art">
          FB
          </a>
        </li>
      </nav>

    </div>
  </div>
</header>
