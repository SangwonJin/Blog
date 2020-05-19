<?php
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //get Data from form
        $projectId = $_POST["projectId"];
        $loginId = $_SESSION['loginId'];
        $categoryId = $_POST["Category"];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $frondEndSkill =  $_POST['frondEndSkill'];
        $backEndSkill =  $_POST['backEndSkill'];
        $status = "unapproved";
        $git = $_POST['git'];
        if (!empty($_POST['approved'])) {
            $status = "approved";
        }



        //Main Image
        $mainimage = $_FILES['mainImage']['name'];
        if (isset($_POST['existingImage']) && empty($mainimage)) {
            //when using same image in edit
            $mainImage_id = $_POST['existingImage'];
        } else {
            //When Creating new Image
            $Main_image_temp = $_FILES['mainImage']['tmp_name'];
            if (move_uploaded_file($Main_image_temp, "images/$mainimage")) {
                $imageSql = "INSERT INTO images(path,role) VALUES('{$mainimage}','main')";
                if (mysqli_query($dbLink, $imageSql)) {
                    $mainImage_id = mysqli_insert_id($dbLink);
                }
            }
        }

        // // //Sub Images
        // // Count # of uploaded files in array
        // $total = count($_FILES['images']['name']);

        // // Loop through each file til 3
        // for ($i = 0; $i < 2; $i++) {

        //     //Get the temp file path
        //     $tmpFilePath = $_FILES['images']['tmp_name'][$i];

        //     //Make sure we have a file path
        //     if ($tmpFilePath != "") {
        //         //Setup our new file path
        //         $subImages = $_FILES['upload']['name'][$i];

        //         //Upload the file into the temp dir
        //         if (move_uploaded_file($tmpFilePath,  "images/$subImages")) {
        //             //Image is saved into Images Table
        //             $imageSql = "INSER INTO images(path,role) VALUES($subImages,'subImages')";
        //             if (!mysqli_query($dbLink, $imageSql)) {
        //                 echo "The Images save has failed";
        //                 echo ("<a href='index_admin.php?source=post_mywork'>Go back and try again, dummy.</a>");
        //             }
        //         }
        //     }
        // }


        if (!empty($title) && $categoryId != 0 && !empty($status) && !empty($mainImage_id)) {
            if (isset($_POST['Createsubmit'])) {
                $sql = "INSERT INTO projects(title,description,frondEnd_Skill,backEnd_Skill,mainImage,category_id,approved,git) 
             VALUES('{$title}','{$description}','{$frondEndSkill}','{$backEndSkill}',{$mainImage_id},{$categoryId},'{$status}','{$git}')";
                if (mysqli_query($dbLink, $sql)) {
                    $last_id = mysqli_insert_id($dbLink);
                    echo "Insert worked<br>\r\nNew recode Id is : " . $last_id;
                    echo ("<br><a href='index_admin.php?source=display_all_mywork'> See the my work.</a>");
                } else {
                    echo "The Create has failed";
                    echo ("<a href='index_admin.php?source=post_mywork'>Go back and try again, dummy.</a>");
                }
            } else {
                //Update
                $sql = "UPDATE projects SET title='{$title}',description = '{$description}',frondEnd_Skill ='{$frondEndSkill}',
                 backEnd_Skill ='{$backEndSkill}',mainImage={$mainImage_id}, category_id={$categoryId} ,approved='{$status}', git='{$git}' WHERE id={$projectId}";
                if (mysqli_query($dbLink, $sql)) {
                    echo "Update has successfully worked!<br>";
                    echo ("<a href='index_admin.php?source=display_all_mywork'> See the my work.</a>");
                } else {
                    echo "The Update has failed<br>";
                    echo ("<a href='index_admin.php?source=post_mywork&id=$projectId'> Go back and try again, dummy.</a>");
                }
            }
        } else {
            $message = "<a href='index_admin.php?source=post_mywork'>Go Back and try again!</a>";
            echo ("<h3>Check the fields.</h3>");
            if (!empty($projectId)) {
                $message = "<a href='index_admin.php?source=post_mywork&id=$projectId'>Go back and try again, dummy.</a>";
            }
            echo ($message);
        }
    } else {
        $pageName = "Create";
        $image = "";
        $status = "";
        $categotyIdFromDisplay = "";
        //Edit
        if (isset($_GET['id'])) {
            $pageName = "Edit";
            $projectId = $_GET['id'];
            $sql = "SELECT * FROM projects WHERE id = {$projectId}";
            $result = $dbLink->query($sql);
            while ($row = $result->fetch_assoc()) {

                $categotyIdFromDisplay = $row["category_id"];
                $title = $row['title'];
                $description = $row['description'];
                $frondEndSkill =  $row['frondEnd_Skill'];
                $backEndSkill =  $row['backEnd_Skill'];
                $status = $row['approved'];

                $mainImage_id = $row["mainImage"];
                $imageSql = "SELECT path FROM images WHERE images_id = {$mainImage_id}";
                $imageResult = $dbLink->query($imageSql);
                while ($imageRow = $imageResult->fetch_assoc()) {
                    $mainImage = $imageRow['path'];
                }



?>

        <?php } //End while in edit
        } ?> <main>
            <div>
                <h1><?php echo $pageName; ?> my work!</h1>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="projectId" value=<?php !empty($projectId) ? print($projectId) : "" ?>>
                        <p><label for="title">Title:</label> <input class="form-control" type="text" name="title" value=<?php !empty($title) ? print($title) : "" ?>></p>

                        <p><label for="description">Description:</label>
                            <input class="form-control" type="text" name="description" value="<?php echo (!empty($description) ? $description : '') ?>"></p>

                        <p><label for="frondEndSkill">Front End Skills:</label></p>
                        <input class="form-control" type="text" name="frondEndSkill" value="<?php echo (!empty($frondEndSkill) ? $frondEndSkill : '') ?>"></p>

                        <p><label for="backEndSkill">Back End Skills:</label></p>
                        <input class="form-control" type="text" name="backEndSkill" value="<?php echo (!empty($backEndSkill) ? $backEndSkill : '') ?>"></p>

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

                        <p><label for="image">Main Image:</label>
                            <?php
                            if (!empty($mainImage)) {
                            ?>
                                <h6>You already have the image!!!!!</h6>
                                <input type="hidden" name="existingImage" value="<?php echo $mainImage_id ?>">
                                <img src="images/<?php echo $mainImage ?>" width="300" height="250">
                            <?php } ?>
                            <input class="form-control" type="file" name="mainImage"></p>

                        <p><label for="frondEndSkill">Git:</label></p>
                        <input class="form-control" type="text" name="git" value="<?php echo (!empty($git) ? $git : '') ?>"></p>

                        <p><label for="approved">Approved:</label></p>
                        <input class="form-control" type="checkbox" name="approved" <?php echo ($status == "approved" ? "Checked" : '') ?>>



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