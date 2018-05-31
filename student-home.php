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
    <link rel="stylesheet" type="text/css" href="styles/main.css">

<?php

$OUTPUT->bodyStart();

include("menu.php");
$user_ID = $USER->id;
$question = $PP_DAO->getQuestion($main_Id);
$student_answer = $PP_DAO->getStudentAnswers($question["question_id"],$user_ID);

if(!isset($question["question_id"])){
    echo('<div class="text-center hardBreakAboveX2">
            <h3>The Instructor has not yet configured this tool.</h3>
        </div>');
}else {
    echo('<div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 text-left ">
                <h2>' . $question["question_title"] . '</h2>

                <p>Please submit your responses to the Pre Question and Post Question using the boxes below. You will 
                only be able to provide a submission to the Post Question once you have answered the Pre Question. 
                In some cases a Wrap-up Question will also be included at the end of the activity. </p>
            </div>    
');

        $status = 0;//0 = no answers 1 = pre done 2 = pre and post done(No wrap up question) 3 = pre and post done (wrap up question) 4 = all done
        $wrapUpStatus = 0;

        if ($question["show_wrap_up_text"] == 1) {
            $wrapUpStatus = 1;
        }
        if (!isset($student_answer["pre_modified"])) {
            $status = 0;
        } else if (!isset($student_answer["post_answer"])) {
            $status = 1;
        } else if ($wrapUpStatus == 1) {
            if (!isset($student_answer["wrap_up_answer"])) {
                $status = 3;
            } else {
                $status = 4;
            }
        } else {
            $status = 2;
        }

        echo('
    <div class="col-sm-6 col-sm-offset-3 text-left ">
        <div class="list-group">');
        if ($status == 0) {
            echo('<a href="pre-question.php" class="list-group-item list-group-item-info">
                <div class="row">
                    <div class="col-sm-1 text-center  question-text arrowIcon"><span class="fa fa-2x fa-arrow-right"></span></div>');
        } else {
            echo('<a href="pre-question.php" class="list-group-item disabled done">
                    <div class="row">
                        <div class="col-sm-1 text-center  question-text "><span class="successIcon fa fa-2x fa-check"></span></div>');
        }
        echo('
            <div class="col-sm-8 question-text ">   
                <h3 class="list-group-item-heading questionTitle">Pre Question</h3>
            </div>
        </div>
        </a>');
        if ($status == 1) {
            echo('<a href="post-question.php" class="list-group-item list-group-item-info">
                <div class="row">
                    <div class="col-sm-1 text-center  question-text arrowIcon" ><span class="fa fa-2x fa-arrow-right"></span></div>');
        } else {

            if ($status > 1) {
                echo('<a href="post-question.php" class="list-group-item disabled done">
                    <div class="row">
                        <div class="col-sm-1 text-center  question-text"><span class="successIcon fa fa-2x fa-check"></span>
                    </div>');
            } else {
                echo('<a href="post-question.php" class="list-group-item disabled">
                    <div class="row"><div class="col-sm-1 text-center  question-text">
                </div>');
            }
        }
        echo('<div class="col-sm-8 question-text">  
                <h3 class="list-group-item-heading questionTitle">Post Question</h3>
                </div>
            </div>
            </a>');
        if ($wrapUpStatus == 1) {
            if ($status == 3) {
                echo('<a href="wrap-up-question.php" class="list-group-item list-group-item-info">
                <div class="row">
                    <div class="col-sm-1 text-center  question-text arrowIcon"><span class="fa fa-2x fa-arrow-right"></span></div>');
            } else {

                if ($status > 3) {
                    echo('<a href="wrap-up-question.php" class="list-group-item disabled done">
                    <div class="row">
                        <div class="col-sm-1 text-center  question-text">
                            <span class="successIcon fa fa-2x fa-check"></span>
                        </div>');
                } else {
                    echo('<a href="wrap-up-question.php" class="list-group-item disabled">
                        <div class="row">
                        <div class="col-sm-1 text-center  question-text"></div>');
                }
            }
            echo('<div class="col-sm-8 question-text">  
              <h3 class="list-group-item-heading questionTitle">Wrap Up Question</h3>
              </div>
              </div>
            </a>
            ');
        }
        echo('</div>
        </div>
        <div class="col-sm-10 col-sm-offset-1 text-left ">
            ');
    if(($status==2) || ($status==4)){
                if($USER->instructor) {
                    echo('<a href="instructor-home.php" class="btn btn-primary"  data-toggle="modal">Back</a>
                        <span>           </span>');
                }
                echo('<a href="answer-results.php" class="btn btn-primary"  data-toggle="modal">Your Answers</a>
                </div>
            ');
    }
    echo('</div></div>
</div>');
}
////////////////////////////-/////////////////////////////
$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();

