<?php
if (isset($_SESSION['username'])) {
    if (isset($_POST['delete'])) {
        include '../includes/functions.php';
        $projectId = $_POST['projectId'];
        $delete_sql = "DELETE FROM projects WHERE id = {$projectId}";
        $result = mysqli_query($dbLink, $delete_sql) or die(mysqli_error($dbLink));
        redirect_to("index_admin.php?source=display_all_mywork");
    }

?>
    <main>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">FrondEnd Skills</th>
                    <th scope="col">BackEnd Skills</th>
                    <th scope="col">Main Image</th>
                    <th scope="col">Git</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php //popultate data from posts
                $sql = 'SELECT * FROM projects';
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

                ?>

                    <tr>
                        <th scope="row"><?php echo $projectId ?> </th>
                        <td><?php echo $title ?></td>
                        <td><?php echo $description ?></td>
                        <td><?php echo $categoryTitle ?></td>
                        <td><?php echo $frondEndSkills ?></td>
                        <td><?php echo $backEndSkills ?></td>
                        <td><img src="images/<?php echo $mainImagePath ?>" width="50px" height="40px"></td>
                        <td><?php echo $git ?></td>
                        <td><?php echo $status ?></td>
                        <td><a href="index_admin.php?source=Edit_mywork&id=<?php echo $projectId ?>">Edit</a></td>
                        <form method="POST">
                            <input type="hidden" name="projectId" value="<?php echo $projectId ?>">
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal<?php echo $projectId ?>">
                                    Delete
                                </button>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal<?php echo $projectId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Do you want to delete?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <input class="btn btn-primary" type="submit" name="delete" value="Delete"></td>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    <?php } else { ?>
        <h5>Please Log in first</h5>
        <a href="../index.php">Go back</a>
    <?php } ?>

    </main>