<?php
if (isset($_SESSION['username'])) {
    if (isset($_POST['delete'])) {
        include '../includes/functions.php';
        $postId = $_POST['postId'];
        $delete_sql = "DELETE FROM posts WHERE post_id = {$postId}";
        $result = mysqli_query($dbLink, $delete_sql) or die(mysqli_error($dbLink));
        redirect_to("index_admin.php?source=display_all_myblog");
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
                    <th scope="col">Date</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php //popultate data from posts
                $sql = 'SELECT * FROM posts';
                $result = $dbLink->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $postId = $row["post_id"];
                    $categotyId = $row["post_category_id"];
                    $title = $row['post_title'];
                    $description = $row['post_description'];
                    $datetime = new DateTime($row['post_date']);
                    $date = $datetime->format("M d,Y");
                    //$time = $datetime->format("g:i a");
                    $image = $row["post_image"];
                    $status = $row["post_status"];

                    $categeySql = "SELECT title FROM Categories WHERE category_id = {$categotyId}";
                    $categoryResult = $dbLink->query($categeySql);
                    while ($category_Row = $categoryResult->fetch_assoc()) {
                        $categoryTitle = $category_Row["title"];
                    }

                ?>
                    <tr>
                        <th scope="row"><?php echo $postId ?> </th>
                        <td><?php echo $title ?></td>
                        <td><?php echo $description ?></td>
                        <td><?php echo $categoryTitle ?></td>
                        <td><?php echo $date ?></td>
                        <td><img src="images/<?php echo $image ?>" width="50px" height="40px"></td>
                        <td><?php echo $status ?></td>
                        <td><a href="index_admin.php?source=Edit_myblog&id=<?php echo $postId ?>">Edit</a></td>
                        <form method="POST">
                            <input type="hidden" name="postId" value=<?php echo $postId ?>>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal<?php echo $postId ?>">
                                    Delete
                                </button>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal<?php echo $postId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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