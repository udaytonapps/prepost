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
                    <form method="post" id="addPrePostForm"action="actions/AddQuestion.php">
                        <div class="form-group">
                            <p>
                                The goal of this tool is to help students see how their knowledge in a specific area
                                has increased over time.
                            </p>
                            <p>
                                This tool allows faculty to define a question that students will be asked to answer on
                                two different occasions - before and after they've learned about a topic or subject.
                                The students will not be able to see their 'Pre Question' response while completing
                                their 'Post Question' response. Faculty also have the ability to add a
                                ‘Wrap-up Question’ that can be used to ask students to reflect on how their answers
                                changed between the ‘Pre’ and ‘Post’ submissions – shining a light on what they’ve
                                learned.
                            </p>
                            <h4 class="hardBreakAboveX1">Activity Title</h4>
                            <input type="text" class="form-control" name="PrePostTitle" id="prePostTitleText" rows="1">
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
        if ($USER->instructor) {
            header( 'Location: '.addSession('instructor-home.php') ) ;
        }
    }
} else {
    if (!$main_Id) {
        ?>
        <div class="text-center hardBreakAboveX2">
            <h3>The Instructor has not yet configured this tool.</h3>
        </div>
        <?php
    } else {
        header('Location: ' . addSession('student-home.php'));
    }
}

$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();



