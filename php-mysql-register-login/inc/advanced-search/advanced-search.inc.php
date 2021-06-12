<?php // Filename: advanced-search.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";

$financial_aid_yes = false;
$financial_aid_no = false;
//defining the degree program variable 
$degree_program = null;
$query = [];
$params = [];
$sql = "SELECT * FROM $db_table WHERE ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First insure that all required fields are filled in
    if (!empty($_POST["first"])) {
        array_push($query, "first_name LIKE :first_name");
        $params["first_name"] = $_POST['first'] . "%";
    }
    if (!empty($_POST["last"])) {
        array_push($query, "last_name LIKE :last_name");
        $params["last_name"] = $_POST['last'] . "%";
    }
    if (!empty($_POST["student_id"])) {
        array_push($query, "student_id LIKE :student_id");
        $params["student_id"] = $_POST['student_id'] . "%";
    }
    if (!empty($_POST["email"])) {
        array_push($query, "email LIKE :email");
        $params["email"] = $_POST['email'] . "%";
    }
    if (!empty($_POST["phone"])) {
        array_push($query, "phone LIKE :phone");
        $params["phone"] = $_POST['phone'] . "%";
    }
    if (!empty($_POST["gpa"])) {
        array_push($query, "gpa LIKE :gpa");
        $params["gpa"] = $_POST['gpa'] . "%";
    }
    if ($_POST["graduation_date"] != "") {
        array_push($query, "graduation_date LIKE :graduation_date");
        $params["graduation_date"] = $_POST['graduation_date'] . "%";
    }
    if ($_POST["degree_program"] != "--") {
        array_push($query, "degree_program LIKE :degree_program");
        $params["degree_program"] = $_POST['degree_program'] . "%";
    }

    if (isset($_POST["financial_aid"])) {
        array_push($query, "financial_aid LIKE :financial_aid");
        $params["financial_aid"] = $_POST['financial_aid'] . "%";
    }
    $sql = $sql . implode(" AND ", $query);
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute($params);
    } catch (PDOException $th) {
        if ($th->errorInfo[1] == 1064) {
            $oops = true;
        }
    }
    $getemboys = $stmt->fetchALL();
}
