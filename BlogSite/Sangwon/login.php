<?php
include "includes/openConnection.php";
include 'includes/functions.php';
include 'includes/session.php';
include 'includes/header.php';
if (!isset($_SESSION['username'])) {
    if (isset($_POST["login"])) {
        $formflag = "";
        $errorMessage = "";
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordInDb = "";
        $sql = "SELECT user_password, user_id FROM users WHERE user_name ='{$username}' and user_role = 'admin'";
        $result = $dbLink->query($sql);
        while ($row = $result->fetch_assoc()) {
            $passwordInDb = $row['user_password'];
            $userId = $row['user_id'];
        }
        if ($passwordInDb == $password) {
            $_SESSION['username'] = $username;
            $_SESSION['loginId'] =  $userId;
            $formflag = "true";
?>
            <div class="card-panel teal lighten-2 center-align">
                <b><a class="deep-purple darken-4" href="../admin/index_admin.php">Go to Admin Page</a></b><br>
                <b> <a class="deep-purple darken-4" href="logout.php">Log Out</a></b>
            </div>

        <?php
        } else {
            $errorMessage = " <div class='card-panel red darken-4'>Please check your login information</div>";
        } ?>
    <?php } ?>

    <?php echo (!empty($errorMessage) ? $errorMessage : "");
    ?>
    <?php
    if (empty($formflag)) {
    ?>
        <div class="section white">
            <div class="row container">
                <h2 class="grey-text text-darken-3 lighten-3 center-align">
                    Log In
                </h2>
                <form class="col s12 center-align" method="POST">
                    <div class="row">
                        <div class="input-field inputLogin">
                            <input placeholder="Placeholder" id="first_name" type="text" class="validate" name="username">
                            <label for="first_name">User Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field inputLogin">
                            <input id="password" type="password" class="validate" name="password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" name="login" value="Log in" />
                        </div>
                    </div>
                </form>

            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="card-panel teal lighten-2 center-align">
        <b><a class="deep-purple-text text-darken-4 " href="admin/index_admin.php">Go to Admin Page</a></b><br>
        <b> <a class="deep-purple-text text-darken-4 " href="includes/logout.php">Log Out</a></b>
    </div>
<?php } ?>
</body>

</html>