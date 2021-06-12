<?php
// Filename: advanced-search.php
$pageTitle = "Advanced Search";
require_once 'inc/layout/header.inc.php';
require_once 'inc/layout/navbar.inc.php';
?>

<div class="container-fluid">
	<div class="row mt-5">
		<div class="col-sm-12 col-md-3 col-lg-3 mb-5 border-right border-secondary p-2">

			<?php
			if (isset($_SESSION['first_name'])) {
				echo '<h1>Advanced Search</h1>';
				require_once __DIR__ . '/inc/advanced-search/advanced-search.inc.php';
				require_once __DIR__ . '/inc/shared/form.inc.php';
				echo '</div>';
				echo '<div class="col-sm-12 col-md-9 col-lg-9">';
				require_once __DIR__ . '/inc/advanced-search/advanced-search-results.inc.php';
				echo '</div>';
			} else {
				header('Location: home.php');
			} ?>
		</div>
	</div>

	<?php require_once 'inc/layout/footer.inc.php'; ?>