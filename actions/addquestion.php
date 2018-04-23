<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if ( $USER->instructor ) {
    $QuestionTitle = $_POST["PrePostTitle"];
    $Question = $_POST["PrePostQuestion"];
    $main_id = $_SESSION["main_ID"];
    $PP_DAO->createQuestion($USER->id, $main_id, $QuestionTitle, $Question);

    header( 'Location: '.addSession('../index.php') ) ;
}
