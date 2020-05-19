<?php include 'includes/session.php'; ?>
<section id="header">
  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
        <ul class="right hide-on-med-and-down">
          <li><a href="index.php">Home</a></li>
          <li><a href="#section_about">About</a></li>
          <li><a href="#section_myblogs">My Blogs</a></li>
          <li><a href="#section_myworks">My Projects</a></li>
          <li><a href="#section_contact">Contact</a></li>
          <?php if (!isset($_SESSION['username'])) {
          ?>
            <li><a href="login.php">Log in</a></li>
          <?php } else { ?>
            <li><a href="admin/index_admin.php">Go to Admin</a></li>
            <li><a href="includes/logout.php">Log out</a></li>
        </ul>
      <?php } ?>
      </div>
    </nav>
  </div>
</section>