<?php
require_once __DIR__ . "/advanced-search.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<h2>Results will go here</h2>';
    if (!isset($oops)) {
        display_record_table($getemboys);
    } else {
        echo '<div class="alert alert-danger">';
        echo '<h2>Oops! You forgot to enter something to search for!</h2>';
        echo '</div>';
    }
} else {
    echo '<div class="alert alert-info">';
    echo '<h2>Search results will appear here</h2>';
    echo '</div>';
}
