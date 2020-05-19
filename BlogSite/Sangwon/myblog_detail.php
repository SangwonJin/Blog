<?php include "includes/header.php"; ?>
<?php include "includes/openConnection.php"; ?>

<body>
  <?php
  include "includes/navigation.php";
  ?>
  <?php
  $blogId = $_GET['id'];
  $sql = "SELECT * FROM posts WHERE post_id={$blogId}";
  $result = $dbLink->query($sql);
  while ($row = $result->fetch_assoc()) {
    $categotyId = $row["post_category_id"];
    $title = $row['post_title'];
    $description = $row['post_description'];
    $datetime = new DateTime($row['post_date']);
    $date = $datetime->format("M d,Y");
    //$time = $datetime->format("g:i a");
    $image = $row["post_image"];

    $categeySql = "SELECT title FROM Categories WHERE category_id = {$categotyId}";
    $categoryResult = $dbLink->query($categeySql);
    while ($category_Row = $categoryResult->fetch_assoc()) {
      $categoryTitle = $category_Row["title"];
    }
  }
  ?>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <h1><?php echo $title ?></h1>
        <p><?php echo $date ?></p>
        <img src="admin/images/<?php echo $image ?>" width="80%" height="400px">
      </div>
      <h4>Category</h4>
      <?php echo $categoryTitle ?>
      <h4>Description</h4>
      <div>
        <?php echo $description ?>
      </div>
    </div>
    <b><a class="blue-text text-darken-2" href="index.php">Go Back</a></b><br>
  </div>

  <?php
  include "includes/footer.php";
  ?>