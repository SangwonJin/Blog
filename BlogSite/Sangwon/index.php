<?php include "includes/header.php"; ?>
<?php include "includes/openConnection.php"; ?>

<body>
  <?php
  include "includes/navigation.php";
  ?>

  <!-- slogan in the picture -->
  <div class="parallax-container" style="height:500px">
    <div class="parallax">
      <div class="slogan">
        <h1>Hello! I'm Sangwon Jin</h1>
        <h6>with Never-give-up mindset and passionate about up-to-date technology.</h6>
      </div>
      <img src="images/background.jpg" />
    </div>
  </div>

  <!-- Introduction -->
  <div class="section" id="section_about">
    <div class="row container">
      <h1 class="grey-text text-darken-3 lighten-3 center-align sectionHeading">
        About
      </h1>
      <div class="row">
        <div class="col s12 m6">
          <img src="images/Sangwon.jpg" width="500px" height="350px" style=" border-radius: 45%;">
        </div>
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">About Sangwon</span>
              <p>With solid computer science, software engineering
                background and efficient coding skill using modern HTML, CSS, Java, c#, SQL, and JavaScript,
                and great framework/libraries such as Angular, PHP, ASP.Net, React Native, I am willing to learn new up-to-date technologies,
                and would be a great asset in your organization..</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Display my blogs -->
  <?php
  include "myblogs.php";
  ?>

  <!-- Display my Projects -->
  <?php
  include "myworks.php";
  ?>


  <!-- Display Contact -->
  <?php
  include "contact.php";
  ?>


  <?php
  include "includes/footer.php";
  ?>