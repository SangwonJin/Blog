<?php include "includes/header.php"; ?>
<?php include "includes/openConnection.php"; ?>

<body>
  <?php
  include "includes/navigation.php";
  ?>
  <?php
  $projectId = $_GET['id'];
  $sql = "SELECT * FROM projects WHERE id={$projectId}";
  $result = $dbLink->query($sql);
  while ($row = $result->fetch_assoc()) {
    $projectId = $row["id"];
    $categotyId = $row["category_id"];
    $title = $row['title'];
    $description = $row['description'];
    $image = $row["mainImage"];
    $frondEndSkills = $row["frondEnd_Skill"];
    $backEndSkills = $row["backEnd_Skill"];
    $status = $row["approved"];
    $git = $row['git'];

    $categeySql = "SELECT title FROM Categories WHERE category_id = {$categotyId}";
    $categoryResult = $dbLink->query($categeySql);
    while ($category_Row = $categoryResult->fetch_assoc()) {
      $categoryTitle = $category_Row["title"];
    }

    $mainImagesSql = "SELECT path FROM images WHERE images_id = {$image}";
    $mainImageResult = $dbLink->query($mainImagesSql);
    while ($mainImage_row = $mainImageResult->fetch_assoc()) {
      $mainImagePath = $mainImage_row["path"];
    }
  }
  ?>

  <div class="container">
    <div class="row">
      <h1><?php echo $title; ?></h1>
      <div class="col m6">
        <div class="row">
          <div class="col s12"> <img src="admin/images/<?php echo $mainImagePath ?>" width="100%" height="400px"></div>
          <div class="col s6"> <img src="/images/<?php echo $mainImagePath ?>" width="100%" height="200px" alt="SubImage1"></div>
          <div class="col s6"> <img src="/images/<?php echo $mainImagePath ?>" width="100%" height="200px" alt="SubImage2"></div>
        </div>
      </div>
      <div class="col m6" style="padding-left:10%;">
        <div>
          <h4>Category</h4>
          <p><?php echo $categoryTitle; ?></p>
        </div>
        <div>
          <h4>Description</h4>
          <p><?php echo $description; ?></p>
        </div>
        <div>
          <h4>Front End Skill</h4>
          <p><?php echo $frondEndSkills; ?></p>
        </div>
        <div>
          <h4>Back End Skill</h4>
          <p><?php echo $backEndSkills; ?></p>
        </div>
        <div>
          <h4>See the code in github</h4>
          <a href="<?php echo $git; ?>">Link to Git</a>
        </div>
      </div>
    </div>
    <b><a class="blue-text text-darken-2" href="index.php">Go Back</a></b><br>
  </div>

  <?php
  include "includes/footer.php";
  ?>