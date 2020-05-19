<?php include "lncludes/admin_header.php"; ?>
<?php include "lncludes/admin_navigation.php"; ?>
<?php include '../includes/session.php'; ?>
<?php include "../includes/openConnection.php"; ?>

<!-- Page Heading -->
<?php

if (isset($_GET['source'])) {

    $source = $_GET['source'];
} else {

    $source = '';
}

switch ($source) {

        //Blog
    case 'display_all_myblog';
        include "DisplayBlog.php";
        break;

    case 'post_myblog';
        include "postMyBlog.php";
        break;

    case 'Edit_myblog';
        include "postMyBlog.php";
        break;
        //Work
    case 'display_all_mywork';
        include "DisplayMywork.php";
        break;

    case 'post_mywork';
        include "postMywork.php";
        break;
    case 'Edit_mywork';
        include "postMywork.php";
        break;


    default:
        include "dashboard.php";
        break;
}
?>


<?php include "lncludes/admin_footer.php"; ?>