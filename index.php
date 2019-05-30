<?php
require_once "../config.php";
require_once "dao/PP_DAO.php";

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

// Retrieve the launch data if present
$LTI = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

$currentTime = new DateTime('now', new DateTimeZone($CFG->timezone));
$currentTime = $currentTime->format("Y-m-d H:i:s");

$main_id = $PP_DAO->getMainId($CONTEXT->id, $LINK->id);

if ($USER->instructor) {

    if (!$main_id) {
        $_SESSION["main_id"] = $PP_DAO->createMain($USER->id, $CONTEXT->id, $LINK->id, $currentTime);
    } else {
        $_SESSION["main_id"] = $main_id;
    }

    $seenSplash = $PP_DAO->hasSeenSplash($_SESSION["main_id"]);

    if ($seenSplash) {
        // Instructor has already setup this instance
        header( 'Location: '.addSession('instructor-home.php') ) ;
    } else {
        header('Location: '.addSession('splash.php'));
    }
} else { // student
    if (!$main_id) {
        header('Location: '.addSession('splash.php'));
    } else {
        $_SESSION["main_id"] = $main_id;

        $hasSetupMain = $PP_DAO->hasSetupMain($_SESSION["main_id"]);

        if (!$hasSetupMain) {
            header('Location: '.addSession('splash.php'));
        } else {
            header( 'Location: '.addSession('student-home.php') ) ;
        }
    }
}



