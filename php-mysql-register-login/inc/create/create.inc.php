<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
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
    if (!isset($_POST["graduation_date"])) {
        array_push($error_bucket, "<p>A graduation date is required.</p>");
    } else {
        $graduation_date = $_POST["graduation_date"];
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
    // if degree program is set (it will always be set so I didn't do !isset) and set to -- echo out the message that it is required. otherwise show what was selected
    if (isset($_POST["degree_program"]) && $_POST["degree_program"] == "--") {
        array_push($error_bucket, "<p>A Degree Program is required.</p>");
    } else {
        $degree_program = $_POST["degree_program"];
    }

    // If we have no errors than we can try and insert the data
    if (count($error_bucket) == 0) {
        // Time for some SQL
        $sql = "INSERT INTO $db_table (first_name,last_name,email,phone,student_id, degree_program, gpa, financial_aid, graduation_date) ";
        $sql .= "VALUES (:first,:last,:email,:phone,:student_id,:degree_program,:gpa,:financial_aid, :graduation_date)";
        // We are preparing the SQL statement. 
        $stmt = $db->prepare($sql);
        //Was getting errors for duplicate student id numbers so now putting try/catch to see if a student id is duplicated, and if so, echo an error message for the user
        try {
            $stmt->execute(["first" => $first, "last" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id, "degree_program" => $degree_program, "gpa" => $gpa, "financial_aid" => $financial_aid, "graduation_date" => $graduation_date]);
        } catch (PDOException $e) { //this will catch all errors related to PDO
            //if the error = 1062 (which is the duplication error)
            if ($e->errorInfo[1] == 1062) {
                echo '<div class="alert alert-danger" role="alert">
            The Student ID is already in use. Please UPDATE existing record, or try a new number.</div>';
                $error = true;
            }
        }
        if (!isset($error)) {
            if ($stmt->rowCount() == 0) {
                echo '<div class="alert alert-danger" role="alert">
            I am sorry, I cannot save this record for you</div>';
            } else {
                header("Location: display-records.php?message=The record for $first has been created.");
            }
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
