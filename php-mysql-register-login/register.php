<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = hash('sha512', $_POST['password']);

    $sql = "INSERT INTO user (email,first_name,last_name,password) ";
    $sql .= "VALUES (:email,:first_name,:last_name,:password)";

    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email, "first_name" => $first_name, "last_name" => $last_name, "password" => $password]);

    if ($stmt->rowCount() == 0) {
        echo '<div>There was a problem registering your account</div>';
    } else {
        echo "<div>You are now ready to go!</div>";
        echo '<a href="login.php" title="Login Page">Login</a>';
    }
}
?>

<!-- <?php require 'inc/footer.inc.php' ?> -->