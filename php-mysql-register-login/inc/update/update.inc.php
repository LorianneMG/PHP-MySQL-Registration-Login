<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";


$error_bucket = [];
// The following three varaibles are being defined here above where the code is run
//setting financial aid yes and no to false so that nothing ir originally selected when you load the page
$financial_aid_yes = false;
$financial_aid_no = false;
//defining the degree program variable 
$degree_program = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First insure that all required fields are filled in
    $id = $_POST["id"];
    if (empty($_POST["first"])) {
        array_push($error_bucket, "<p>A first name is required.</p>");
    } else {
        $first = $_POST["first"];
    }
    if (empty($_POST["last"])) {
        array_push($error_bucket, "<p>A last name is required.</p>");
    } else {
        $last = $_POST["last"];
    }
    if (empty($_POST["student_id"])) {
        array_push($error_bucket, "<p>A student ID is required.</p>");
    } else {
        $student_id = intval($_POST["student_id"]);
    }
    if (empty($_POST["email"])) {
        array_push($error_bucket, "<p>An email address is required.</p>");
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["phone"])) {
        array_push($error_bucket, "<p>A phone number is required.</p>");
    } else {
        $phone = $_POST["phone"];
    }
    // the following is just coding the gpa error the same as all the others that were already here
    if (empty($_POST["gpa"])) {
        array_push($error_bucket, "<p>A GPA is required.</p>");
    } else {
        $gpa = $_POST["gpa"];
    }
    // the following is coding the radio buttons 
    if (isset($_POST["financial_aid"])) { //if it is set
        if ($_POST["financial_aid"] == '1') { //and it's =1
            $financial_aid = $_POST["financial_aid"];
            $financial_aid_yes = true; // then the "yes" option is true aka checked
            $financial_aid_no = false; // and the no option is false
        } else { //otherwise
            $financial_aid = $_POST["financial_aid"];
            $financial_aid_yes = false; // yes is false
            $financial_aid_no = true; //because no is true meaning that no is checked
        }
    }
    if (!isset($_POST["graduation_date"])) {
        array_push($error_bucket, "<p>A graduation date is required.</p>");
    } else {
        $graduation_date = $_POST["graduation_date"];
    }
    if (!isset($_POST["degree_program"]) || $_POST["degree_program"] == "--") {
        array_push($error_bucket, "<p>A Degree Program is required.</p>");
    } else {
        $degree_program = $_POST["degree_program"];
    }
    if (count($error_bucket) == 0) {
        // Time for some SQL
        $sql = "UPDATE $db_table SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, student_id = :student_id, degree_program = :degree_program, gpa = :gpa, financial_aid = :financial_aid, graduation_date = :graduation_date WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(["first_name" => $first, "last_name" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id, "degree_program" => $degree_program, "gpa" => $gpa, "financial_aid" => $financial_aid, "graduation_date" => $graduation_date, "id" => $id]);
        if ($stmt->rowCount() == 1) {
            header("Location: display-records.php?message=The record for $first has been updated.");
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
if (!isset($id)) {
    $id = $_GET["id"];
}
$sql = "SELECT * FROM $db_table WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->execute(["id" => $id]);
$student_record = $stmt->fetch();
$first = $student_record->first_name;
$last = $student_record->last_name;
$email = $student_record->email;
$phone = $student_record->phone;
$student_id = $student_record->student_id;
$degree_program = $student_record->degree_program;
$gpa = $student_record->gpa;
$financial_aid = $student_record->financial_aid;
$graduation_date = $student_record->graduation_date;
if ($financial_aid == '1') {
    $financial_aid_yes = true;
    $financial_aid_no = false;
} else {
    $financial_aid_yes = false;
    $financial_aid_no = true;
}
