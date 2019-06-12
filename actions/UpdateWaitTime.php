<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if ($USER->instructor) {

    $currentTime = new DateTime('now', new DateTimeZone($CFG->timezone));
    $currentTime = $currentTime->format("Y-m-d H:i:s");

    $result = array();
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
    } else if (!ctype_digit($_POST["waitTime"])) {
        $_SESSION['error'] = "Invalid Wait Time. Please try again or enter a zero to remove the wait time.";

        $OUTPUT->buffer=true;
        $result["flashmessage"] = $OUTPUT->flashMessages();

        header('Content-Type: application/json');

        echo json_encode($result, JSON_HEX_QUOT | JSON_HEX_TAG);

        exit;
    }

    $PP_DAO->updateWaitTime($_SESSION["main_id"], $waitTimeSeconds, $currentTime);

    $_SESSION['success'] = "Wait Time saved.";

    $OUTPUT->buffer=true;
    $result["flashmessage"] = $OUTPUT->flashMessages();
    $result["waitseconds"] = $waitTimeSeconds;

    header('Content-Type: application/json');

    echo json_encode($result, JSON_HEX_QUOT | JSON_HEX_TAG);

    exit;
} else {
    header( 'Location: '.addSession('../student-home.php') ) ;
}

