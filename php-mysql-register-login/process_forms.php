<?php
// process_forms.php
require 'inc/db_connect.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["sign_in"])) {

        $email = $_POST['in_email'];
        $password = hash('sha512', $_POST['in_password']);

        $sql = "SELECT * FROM user WHERE email=:in_email AND password=:in_password";

        $stmt = $db->prepare($sql);
        $stmt->execute(["in_email" => $email, "in_password" => $password]);

        if ($stmt->rowCount() == 1) {
            $_SESSION['loggedin'] = 1;
            $_SESSION['email'] = $email;
            $row = $stmt->fetch();
            $_SESSION['first_name'] = $row->first_name;
            header('location: display-records.php');
        } else {
            echo "<span class='wrong'> Your email or password is incorrect. <br>Please try again</span>";
        }
    }
    if (isset($_POST["sign_up"])) {
        $email = $_POST['up_email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = hash('sha512', $_POST['up_password']);

        $sql = "INSERT INTO user (email,first_name,last_name,password) ";
        $sql .= "VALUES (:email,:first_name,:last_name,:password)";

        $stmt = $db->prepare($sql);
        try {
            $stmt->execute(["email" => $email, "first_name" => $first_name, "last_name" => $last_name, "password" => $password]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo '<div class="wrong">This email is already in use.</div>';
                $error = true;
            }
        }
        if (!isset($error)) {
            if ($stmt->rowCount() == 0) {
                echo '<div>There was a problem registering your account</div>';
            } else {
                echo "<span class='greet'>You have successfully registered your account! <br> Login below to view the site.</span>";
            }
        }
    }
}
