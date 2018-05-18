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
if ( $USER->instructor ) {
    if ($question["show_wrap_up_text"] == 1) {
        $PP_DAO->toggleWrapUp($main_Id, 0);
    } else {
        $PP_DAO->toggleWrapUp($main_Id, 1);
    }
}
