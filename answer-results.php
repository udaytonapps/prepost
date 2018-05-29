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
$user_ID = $USER->id;
$question = $PP_DAO->getQuestion($main_Id);
$answers = $PP_DAO->getStudentAnswers($question["question_id"],$user_ID);
$wrapup = 0;
if($question["show_wrap_up_text"]== 1){
    $wrapup = 1;
}

$preAnswerDate = new DateTime($answers["pre_modified"]);

$formattedPreDate = $preAnswerDate->format("m-d-y")." at ".$preAnswerDate->format("h:i A");

$postAnswerDate = new DateTime($answers["post_modified"]);

$formattedPostDate = $postAnswerDate->format("m-d-y")." at ".$postAnswerDate->format("h:i A");

$wrapupAnswerDate = new DateTime($answers["wrap_up_modified"]);

$formattedWrapupDate = $wrapupAnswerDate->format("m-d-y")." at ".$wrapupAnswerDate->format("h:i A");

include("menu.php");
echo('<div class="container-fluid">
    <div class="row">  
        <div class="col-sm-10 col-sm-offset-1 text-left ">
            <h2>Responses - ' . $PP_DAO->findDisplayName($answers["user_id"]) . '</h2>
            <div class="row lines">
                <div class = "questionDateText">'.$formattedPreDate.'</div>
                <div>
                    <h4>Pre Question Answer</h4>
                    <p>' . $answers["pre_answer"] . '</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">  
        <div class="col-sm-10 col-sm-offset-1 text-left ">
            <div class="row lines">  
                <div class = "questionDateText">'.$formattedPostDate.'</div>
                <div>
                    <h4>Post Question Answer</h4>
                    <p>' . $answers["post_answer"] . '</p>
                </div>
                
                
            </div>
        </div>
    </div>');
if($wrapup == 1) {
    echo('<div class="row">  
        <div class="col-sm-10 col-sm-offset-1 text-left ">
            <div class="row lines">
                <div class = "questionDateText">'.$formattedWrapupDate.'</div>
                <div>
                    <h4>Wrap Up Question Answer</h4>
                    <p>' . $answers["wrap_up_answer"] . '</p>
                </div>
            </div>
        </div>
    </div>
    ');
}
    echo('<div class="col-sm-10 col-sm-offset-1 text-left ">
            <div class="row lines">
            <a href="student-home.php" class="btn btn-primary"  data-toggle="modal">Done</a>
            </div>
        </div>
    </div>
</div>');