<!-- section My Blogs -->
<div class="section grey lighten-5" id="section_myblogs">
    <div class="row container">
        <h2 class="grey-text text-darken-3 lighten-3 center-align sectionHeading">
            My Blog
        </h2>
        <div class="row">
            <!-- popultate data from posts -->
            <?php
            $sql = "SELECT * FROM posts WHERE post_status ='approved' ";
            $result = $dbLink->query($sql);
            while ($row = $result->fetch_assoc()) {
                $postId = $row["post_id"];
                $title = $row['post_title'];
                $description = $row['post_description'];
                $image = $row["post_image"];
            ?>
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image">
                            <img src="admin/images/<?php echo $image ?>" width="200" height="300">
                        </div>
                        <span class="indigo-text text-darken-4 card-title" style="font-weight:bold">
                            <?php echo $title ?>
                        </span>
  
                        <div class="card-action">
                            <a href="myblog_detail.php?id=<?php echo $postId ?>">Go into detail</a>
                        </div>
                    </div>
                </div>
            <?php
            } ?>
        </div>
    </div>
</div>