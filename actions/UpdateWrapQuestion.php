<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if ($USER->instructor) {

    $result = array();

    if (isset($_POST["questionText"]) && trim($_POST["questionText"]) !== '') {
        $currentTime = new DateTime('now', new DateTimeZone($CFG->timezone));
        $currentTime = $currentTime->format("Y-m-d H:i:s");

        $PP_DAO->updateWrapQuestion($_SESSION["main_id"], $_POST["questionText"], $currentTime);

        $_SESSION['success'] = "Wrap-Up Question text saved.";
    } else {
        $_SESSION['error'] = "Wrap-Up Question text failed to save. Please try again.";
    }

    $OUTPUT->buffer=true;
    $result["flashmessage"] = $OUTPUT->flashMessages();

    header('Content-Type: application/json');

    echo json_encode($result, JSON_HEX_QUOT | JSON_HEX_TAG);

    exit;
} else {
    header( 'Location: '.addSession('../student-home.php') ) ;
}

