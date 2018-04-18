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
    <link rel="stylesheet" type="text/css" href="styles/main.css" xmlns="http://www.w3.org/1999/html">
<?php

$OUTPUT->bodyStart();

include("menu.php");

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
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <form method="post" id="addPrePostForm"action="actions/addquestion.php">
                    <h3>Create Pre/Post Question</h3>
                    <p>Type the question in the text box below.</p>
                    <input type="hidden" name="QID" value="-1"/>
                    <textarea class="form-control" name="PrePostQuestion" id="prePostQuestionText" rows="4"></textarea>
                    <input type="checkbox" name="show_wrap_up_text" id="show_wrap_up_text"/>
                    <span>Show the wrap up text area after the post answer</span>
                    <br />
                    <input type="submit" id="submit" class="btn btn-success" value="Submit" />
                </form>
            </div>
        </div>

        <?php
       //  $Question = "!!!!";
       // $PP_DAO->createQuestion($_SESSION["main_ID"], $Question);
    } else {
        ?>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <form method="post" id="addPrePostForm"action="actions/removequestion.php">
                    <h3>Delete Pre/Post Question</h3>
                    <br />
                    <input type="submit" id="submit" class="btn btn-danger" value="Delete" />
                </form>
            </div>
        </div>
        <?php
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
