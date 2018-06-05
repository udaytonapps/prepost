<?php

require_once "../config.php";
require_once "dao/PP_DAO.php";

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

// Retrieve the launch data if present
$LTI = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);
$main_Id = $PP_DAO->getMainId($CONTEXT->id, $LINK->id);
// Start of the output
$OUTPUT->header();
?>

    <!-- Our main css file that overrides default Tsugi styling -->
    <link rel="stylesheet" type="text/css" href="styles/main.css" xmlns="http://www.w3.org/1999/html">

<?php

$OUTPUT->bodyStart();

include("menu.php");
$user_ID = $USER->id;
$question = $PP_DAO->getQuestion($main_Id);
$student_answer = $PP_DAO->getStudentAnswers($question["question_id"],$user_ID);
if (isset($student_answer["pre_modified"])) {
    header('Location: ' . addSession('student-home.php'));
    } else {
    echo('<div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-left ">
                <h2>' . $question["question_title"] . '
                <br />
                <small>Pre Question</small>
                </h2>
                    <form method="post" class="question-form" action="actions/AddAnswer.php">
                    <h4>' . $question["pre_question"] . '</h4>
                        <input type="hidden" name="pre_answer" value="pre_answer" id="pre_answer"/>
                        <textarea class="form-control" name="pre_answer_text" rows="12" autofocus required>' . $student_answer["pre_answer"] . '</textarea>
                        <div class="text-right answer-buttons" id="pre_answer_container_footer">
                            <a href="student-home.php" class="btn btn-danger"> 
                                Cancel
                            </a>
                            <input type="submit" class="btn btn-success" value="Save">
                        </div>
                    </form>
            </div>
        </div>
    </div>');
}

$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();