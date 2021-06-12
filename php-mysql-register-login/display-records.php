<?php // Filename: display-records.php
$pageTitle = "Record Management";
require_once 'inc/layout/header.inc.php';
require_once 'inc/layout/navbar.inc.php';
?>
<div class="container-fluid mt-4">
    <h1>Welcome to our great site, <?= isset($_SESSION['first_name']) ? $_SESSION['first_name'] : null ?></h1>
    <div id="message"></div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <?php
            if (isset($_SESSION['first_name'])) {
                require "inc/display/content.inc.php";
            } else {
                header('Location: home.php');
            }
            ?>
        </div>
    </div>
</div>
<?php require_once 'inc/layout/footer.inc.php'; ?>