<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if ( $USER->instructor ) {
    $preQuestionText = $_POST["preQuestionText"];
    $postQuestionText = $_POST["postQuestionText"];
    $wrapUpQuestion = isset($_POST["wrapUpQuestionText"]) && trim($_POST["wrapUpQuestionText"]) !== '' ? $_POST["wrapUpQuestionText"] : null;
    $waitTimeSeconds = 0;

    if (isset($_POST["waitTime"]) && trim($_POST["waitTime"]) !== '' && ctype_digit($_POST["waitTime"])) {
        // Wait time is set and is an integer
        $unit = $_POST["waitTimeUnit"];
        if ($unit === 'min') {
            $waitTimeSeconds = $_POST["waitTime"] * 60;
        } else if ($unit === 'hrs') {
            $waitTimeSeconds = $_POST["waitTime"] * 60 * 60;
        } else if ($unit === 'days') {
            $waitTimeSeconds = $_POST["waitTime"] * 24 * 60 * 60;
        }
    }

    $currentTime = new DateTime('now', new DateTimeZone($CFG->timezone));
    $currentTime = $currentTime->format("Y-m-d H:i:s");

    $PP_DAO->setupMain($_SESSION["main_id"], $preQuestionText, $postQuestionText, $wrapUpQuestion, $waitTimeSeconds, $currentTime);

    $_SESSION["success"] = "Pre/Post Reflection Created.";

    header( 'Location: '.addSession('../instructor-home.php') ) ;
} else {
    header( 'Location: '.addSession('../student-home.php') ) ;
}