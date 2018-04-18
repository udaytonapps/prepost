<?php
require_once "../../config.php";
require_once('../dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if ( $USER->instructor ) {

    $PP_DAO->deleteQuestion($_SESSION["main_ID"]);

    header( 'Location: '.addSession('../index.php') ) ;
}
