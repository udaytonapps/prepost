<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

$main_Id = $PP_DAO->getMainId($CONTEXT->id, $LINK->id);
$question = $PP_DAO->getQuestion($main_Id);

if ($USER->instructor) {
    header('Location: ' . addSession('../instructor-home.php'));
}else{
    $question_ID = $question["question_id"];
    if (isset($_POST['pre_answer_text'])) {
        $PP_DAO->answerPreQuestion($USER->id, $question_ID, "$_POST[pre_answer_text]");
    } else if (isset($_POST['post_answer_text'])) {
        $PP_DAO->answerPostQuestion($USER->id, $question_ID, "$_POST[post_answer_text]");
    } else if (isset($_POST['wrap_up_answer_text'])) {
        $PP_DAO->answerWrapUpText($USER->id, $question_ID, "$_POST[wrap_up_answer_text]");
    }
    header('Location: ' . addSession('../student-home.php'));
}
