<?php
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postid = $_POST["postId"];
        $categoryId = $_POST["Category"];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $approved = "unapproved";
        if (!empty($_POST['approved'])) {
            $approved = "approved";
        }
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];

        move_uploaded_file($image_temp, "images/$image");

        if (!empty($title) && $categoryId != 0 && !empty($approved) && !empty($image)) {
            if (isset($_POST['Createsubmit'])) {
                //Create
                $loginId = $_SESSION['loginId'];
                $sql = "INSERT INTO posts(post_category_id,post_title,post_description,post_image,post_status,post_user_id) 
             VALUES({$categoryId},'{$title}','{$description}','{$image}','{$approved}',{$loginId})";
                if (mysqli_query($dbLink, $sql)) {
                    $last_id = mysqli_insert_id($dbLink);
                    echo "Insert worked<br>\r\nNew recode Id is : " . $last_id;
                    echo ("<br><a href='DisplayPost.php'> See the my work.</a>");
                } else {
                    echo "The Create has failed";
                    echo ("<a href='postMywork.php>Go back and try again, dummy.</a>");
                }
            } else {
                //Update
                $sql = "UPDATE posts SET post_category_id={$categoryId},post_title = '{$title}',post_description ='{$description}',
                 post_image ='{$image}',post_status='{$approved}' WHERE post_id={$postid}";
                if (mysqli_query($dbLink, $sql)) {
                    echo "Update has successfully worked!<br>";
                    echo ("<a href='DisplayPost.php'> See the my work.</a>");
                } else {
                    echo "The Update has failed<br>";
                    echo ("<a href='postMywork.php?id=$postid'> Go back and try again, dummy.</a>");
                }
            }
        } else {
            $message = "<a href='postMywork.php'>Go Back and try again!</a>";
            echo ("<h3>Check the fields.</h3>");
            if (!empty($postid)) {
                $message = "<a href='postMywork.php?id=$postid'>Go back and try again, dummy.</a>";
            }
            echo ($message);
        }
    } else {
        $pageName = "Create";
        //Edit
        if (isset($_GET['id'])) {
            $pageName = "Edit";
            $postid = $_GET['id'];
            $sql = "SELECT * FROM posts WHERE post_id = {$postid}";
            $result = $dbLink->query($sql);
            while ($row = $result->fetch_assoc()) {
                $categotyIdFromDisplay = $row["post_category_id"];
                $title = $row['post_title'];
                $description = $row['post_description'];
                $datetime = new DateTime($row['post_date']);
                $date = $datetime->format("M d,Y");
                //$time = $datetime->format("g:i a");
                $image = $row["post_image"];
                $status = $row["post_status"]; ?>

        <?php } //End while in edit
        } ?> <main>
            <div>
                <h1><?php echo $pageName; ?> my work!</h1>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="postId" value=<?php !empty($postid) ? print($postid) : "" ?>>
                        <p><label for="title">Title:</label> <input class="form-control" type="text" name="title" value=<?php !empty($title) ? print($title) : "" ?>></p>
                        <p><label for="Category">Category:</label></p>
                        <select name="Category">
                            <option value="0">Select a Category</option>
                            <?php
                            $selectSQL = "SELECT DISTINCT Category_id,title FROM categories";
                            $result = $dbLink->query($selectSQL);
                            while ($row = $result->fetch_assoc()) {
                                $categoryId = $row["Category_id"];
                                $category_title = $row["title"];
                                if ($categotyIdFromDisplay == $categoryId) { ?>
                                    <option value="<?php echo $categoryId ?>" selected><?php echo $category_title ?></option>
                                <?php
                                } else { ?>
                                    <option value="<?php echo $categoryId ?>"><?php echo $category_title ?></option>
                                <?php } ?>
                            <?php
                            } ?>
                        </select>
                        <p><label for="description">Description:</label> <input class="form-control" type="text" name="description" value="<?php echo (!empty($description) ? $description : '') ?>"></p>
                        <p><label for="image">Image:</label>
                            <?php
                            if (!empty($image)) {
                            ?>
                                <img src="images/<?php echo $image ?>" width="300" height="250">
                            <?php } ?>
                            <input class="form-control" type="file" name="image" value="<?php echo (!empty($image) ? $image : '') ?>"></p>
                        <p><label for="approved">Approved:</label> <input class="form-control" type="checkbox" name="approved" <?php echo (!empty($status) ? $status : '') ?>></p>
                        <input class="btn btn-primary" type="submit" name="<?php echo $pageName ?>submit" value=<?php echo $pageName ?>>
                    </div>
                </form>
            </div>
        </main>

<?php
        $dbLink->close();
    } //End Edit or Create
} else {
    echo "you should loging first" . "<br>";
    echo "<a href='../includes/login.php'>Log In </a><br><br>";
} ?>
