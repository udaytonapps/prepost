<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();
$p = $CFG->dbprefix;
$PP_DAO = new PP_DAO($PDOX, $p);

$main_Id = $_SESSION['main_ID'];
$question = $PP_DAO->getQuestion($main_Id);

if ( $USER->instructor ) {
    $PP_DAO->deleteQuestion($question["question_id"]);
    header( 'Location: '.addSession('../index.php') ) ;
}
