<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;
$PP_DAO = new PP_DAO($PDOX, $p);
$main_Id = $_SESSION['main_ID'];
if ($USER->instructor) {
    if (isset($_POST['question_title'])) {
        $PP_DAO->editTitle($main_Id, "$_POST[titleText]");
    } else if (isset($_POST['pre_question'])) {
        $PP_DAO->editPreQuestion($main_Id, "$_POST[preQuestion]");
    } else if (isset($_POST['post_question'])) {
        $PP_DAO->editPostQuestion($main_Id, "$_POST[postQuestion]");
    } else if (isset($_POST['wrap_up_text'])) {
        if (isset($_POST['show_wrap_up_text'])) {
            $PP_DAO->editWrapUpText($main_Id, "$_POST[wrapUpQuestion]", 1);
        } else {
            $showWrapUpText = 0;
            $PP_DAO->editWrapUpText($main_Id, "$_POST[wrapUpQuestion]", 0);
        }
    }
    header('Location: ' . addSession('../instructor-home.php'));
}else{
    header('Location: ' . addSession('../student-home.php'));
}

