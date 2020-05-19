<!-- section My Projects -->
<div class="section" id="section_myworks">
    <div class="row container">
        <h2 class="grey-text text-darken-3 lighten-3 center-align sectionHeading">
            My Projects
        </h2>
        <div>
            <form>
                <label for="">Search:</label>
                <input style="width: 20%;" type="text" name="title" /><br>
                <input type="submit" value="submit" name="searchSubmit">
            </form>
            <br>
        </div>
        <div class="row">
            <!-- popultate data from Projects -->
            <?php
            if (isset($_GET['searchSubmit']) && !empty($_GET['title'])) {
                $title = $_GET['title'];
                // $sql = "CALL searchProjects('$title')";
                $sql = "SELECT * FROM projects WHERE title 
                LIKE CONCAT('%','${title}','%') 
                OR frondEnd_Skill LIKE CONCAT('%','${title}','%')  
                OR backEnd_Skill LIKE CONCAT('%','${title}','%') AND approved ='approved'";
            } else {
                $sql = "SELECT * FROM projects WHERE approved ='approved'";
            }
            $result = $dbLink->query($sql);
            $message = "";
            if (mysqli_num_rows($result) == 0) {
                $message = "Nothing found. To get all projects, Click submit without any data";
            } else {
                while ($row = $result->fetch_assoc()) {
                    $projectId = $row["id"];
                    $title = $row['title'];
                    $description = $row['description'];
                    $image = $row["mainImage"];

                    $mainImagesSql = "SELECT path FROM images WHERE images_id = {$image}";
                    $mainImageResult = $dbLink->query($mainImagesSql);
                    while ($mainImage_row = $mainImageResult->fetch_assoc()) {
                        $mainImagePath = $mainImage_row["path"];
                    } ?>
                    <div class="col s12 m4">
                        <div class="card">
                            <div class="card-image">
                                <img src="admin/images/<?php echo $mainImagePath ?>" width="200" height="300"><br>
                            </div>
                            <span class="indigo-text text-darken-4 card-title" style="font-weight:bold">
                                <?php echo $title ?>
                            </span>
                            <div class="card-content">
                                <p><?php echo $description ?></p>
                            </div>
                            <div class="card-action">
                                <a href="mywork_detail.php?id=<?php echo $projectId ?>">Go into detail</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            if (!empty($message)) {
                echo $message;
            }
            ?>
        </div>
    </div>
</div>