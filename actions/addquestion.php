<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if ( $USER->instructor ) {
    $Question = $_POST["PrePostQuestion"];

    // New question
    $main_id = $_SESSION["main_ID"];
    $showWrapUpText = isset($_POST['show_wrap_up_text']);
    if(!$showWrapUpText){
        $showWrapUpText = 0;
    }
    $PP_DAO->createQuestion($USER->id, $main_id, $Question, $showWrapUpText);

    header( 'Location: '.addSession('../index.php') ) ;
}
