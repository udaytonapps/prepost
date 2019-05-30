<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

$studentResponses = $PP_DAO->getOrCreateStudentResponseRecord($_SESSION["main_id"], $USER->id);

if (isset($_POST["answerTextWrap"]) && trim($_POST["answerTextWrap"]) !== '') {
    $currentTime = new DateTime('now', new DateTimeZone($CFG->timezone));
    $currentTime = $currentTime->format("Y-m-d H:i:s");

    $PP_DAO->updateWrapResponse($studentResponses["response_id"], $_POST["answerTextWrap"], $currentTime);

    $_SESSION['success'] = "Wrap-Up response saved.";
} else {
    $_SESSION['error'] = "Wrap-Up response cannot be blank.";
}

header( 'Location: '.addSession('../student-home.php') ) ;