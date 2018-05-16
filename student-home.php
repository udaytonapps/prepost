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
echo('<div class="container-fluid">
    <div class="row"><h2>' .$question["question_title"].'</h2></div>
    <div class="row"><p>PLACEHOLDER TEXT</p></div>
    </div>');

$status = 0;//0 = no answers 1 = pre done 2 = pre and post done(No wrap up question) 3 = pre and post done (wrap up question) 4 = all done
$wrapUpStatus = 0;

if($question["show_wrap_up_text"]==1){
    $wrapUpStatus = 1;
}
if (!isset($student_answer["pre_modified"])) {
    $status = 0;
}else if(!isset($student_answer["post_answer"])) {
    $status = 1;
}else if ($wrapUpStatus == 1){
    if(!isset($student_answer["wrap_up_answer"])){
        $status = 3;
    } else {
        $status = 4;
    }
}else {
    $status = 2;
}

echo('<div class="container-fluid">
    <div class="list-group">');
    if($status == 0){
        echo('<a href="pre-question.php" class="list-group-item list-group-item-info">
            <div class="row">
                <div class="col-sm-1 question-text"></div>');
    } else {
        echo('<a href="pre-question.php" class="list-group-item disabled">
                <div class="row">
                    <div class="col-sm-1 question-text"><span class="fa fa-3x fa-check"></span></div>');
    }
    echo('
        <div class="col-sm-11 question-text">   
            <h4 class="list-group-item-heading">Pre Question</h4>
            <p class="list-group-item-text">Answer prior to the course</p>
        </div>
    </div>
    </a>');
    if($status == 1){
        echo('<a href="post-question.php" class="list-group-item list-group-item-info">
            <div class="row">
                <div class="col-sm-1 question-text"></div>');
    } else {
        echo('<a href="post-question.php" class="list-group-item disabled">
                <div class="row">');
        if($status > 1){
            echo('<div class="col-sm-1 question-text"><span class="fa fa-3x fa-check"></span></div>');
        }else{
            echo('<div class="col-sm-1 question-text"></div>');
        }
    }
    echo('<div class="col-sm-11 question-text">  
            <h4 class="list-group-item-heading">Post Question</h4>
            <p class="list-group-item-text">Answer after the course</p>
            </div>
        </div>
        </a>');
    if($wrapUpStatus==1) {
        if($status == 3){
            echo('<a href="wrap-up-question.php" class="list-group-item list-group-item-info">
            <div class="row">
                <div class="col-sm-1 question-text"></div>');
        } else {
            echo('<a href="wrap-up-question.php" class="list-group-item disabled">
                <div class="row">');
            if($status > 3){
                echo('<div class="col-sm-1 question-text"><span class="fa fa-3x fa-check"></span></div>');
            }else{
                echo('<div class="col-sm-1 question-text"></div>');
            }
        }
        echo('<div class="col-sm-11 question-text">  
          <h4 class="list-group-item-heading">Wrap Up Question</h4>
          <p class="list-group-item-text">Answer after the other two questions</p>
          </div>
          </div>
        </a>
        ');
    }
    echo('
    </div>
</div>');

////////////////////////////-/////////////////////////////
$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();

