<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

$studentResponses = $PP_DAO->getOrCreateStudentResponseRecord($_SESSION["main_id"], $USER->id);

if (isset($_POST["answerTextPost"]) && trim($_POST["answerTextPost"]) !== '') {
    $currentTime = new DateTime('now', new DateTimeZone($CFG->timezone));
    $currentTime = $currentTime->format("Y-m-d H:i:s");

    $PP_DAO->updatePostResponse($studentResponses["response_id"], $_POST["answerTextPost"], $currentTime);

    $_SESSION['success'] = "Post-Question response saved.";
} else {
    $_SESSION['error'] = "Post-Question response cannot be blank.";
}

header( 'Location: '.addSession('../student-home.php') ) ;