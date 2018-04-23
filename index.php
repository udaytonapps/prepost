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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h3>Create Pre/Post Reflection</h3>
                </div>
                <div class="col-sm-8 col-sm-offset-2">
                    <form method="post" id="addPrePostForm"action="actions/addquestion.php">
                        <div class="form-group">
                            <p>
                                This tool allows faculty to define a question to answer on two different occasions - before and after
                                they've learned about a topic/subject. The students will answer thquestion before they learn about a
                                topic/ or subject (Pre). They will then be provided a second box to answer the same question after
                                learning about the same topic/subject (Post). The students will not be able to see their 'Pre' answer
                                when they are entering their 'Post' answer. Finallym students will be given a final text area to reflect on
                                how their answer has changed between their 'Pre' and 'Post' Entries
                            </p>
                            <h4>Pre/Post Title</h4>
                            <input type="text" class="form-control" name="PrePostTitle" id="prePostTitleText" rows="1"></input>
                            <h4>What question would you like participants to answer Pre and Post?</h4>
                            <textarea class="form-control" name="PrePostQuestion" id="prePostQuestionText" rows="4"></textarea>
                        </div>
                        <input type="submit" id="submit" class="btn btn-success" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
        <?php
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



