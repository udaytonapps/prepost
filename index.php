<?php

require_once "../config.php";
require_once "dao/PP_DAO.php";

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

// Retrieve the launch data if present
$LTI = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

// Start of the output
$OUTPUT->header();
?>
    <!-- Our main css file that overrides default Tsugi styling -->
    <link rel="stylesheet" type="text/css" href="styles/main.css">
<?php

$OUTPUT->bodyStart();
$main_Id = $PP_DAO->getMainId($CONTEXT->id, $LINK->id);
if ($USER->instructor) {
    if (!$main_Id) {
        $_SESSION["main_ID"] = $PP_DAO->createMain($USER->id, $CONTEXT->id, $LINK->id);
    } else {
        $_SESSION["main_ID"] = $main_Id;
    }
    $question_ID = $PP_DAO->getQuestionId($_SESSION["main_ID"]);
    if (!$question_ID) {
        ?>
        <div class="text-center">
            <h3>Here you can add a question for this tool. Testing will do it automatically. Creating test question</h3>
        </div>
        <?php
        $Question = "!!!!";
        $PP_DAO->createQuestion($_SESSION["main_ID"], $Question);
    } else {
        ?>
        <div class="text-center">
            <h3>Test question goes here</h3>
            <h3>For testing purposes Deleting test question</h3>
        </div>
        <?php
        $PP_DAO->deleteQuestion($_SESSION["main_ID"]);
    }
} else {
    if (!$main_Id) {
        ?>
        <div class="text-center">
            <h3>This page has not been set up yet</h3>
        </div>
        <?php
    } else {
        ?>
        <div class="text-center">
            <h3>Default info</h3>
        </div>
        <?php
    }
}

$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();
