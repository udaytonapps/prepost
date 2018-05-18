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
$question = $PP_DAO->getQuestion($main_Id);
$answers = $PP_DAO->getAllStudentAnswers($question["question_id"]);



if($USER->instructor){
    echo('<div class="container-fluid">
<div class="row">
            <div class="col-sm-10 col-sm-offset-1 text-left "><h2>Student Results</h2></div>
 </div>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1 text-left ">
        
    
    
    <div id="post_answer_container">
            <ul class="list-group">');
    $i = 0;
    $wrapup = 0;
    if($question["show_wrap_up_text"]== 1){
        $wrapup = 1;
    }

    echo('<li class="list-group-item dark"><div class="row">');
    if($wrapup == 1) {
        echo('<div class="col-sm-3 text-left">Student</div>
              <div class="col-sm-3 text-center">Pre Answer</div>
              <div class="col-sm-3 text-center">Post Answer</div>
              <div class="col-sm-3 text-center" > Wrap Up Answer </div >');
    } else {
        echo('<div class="col-sm-4 text-center">Student</div>
              <div class="col-sm-4 text-center">Pre Answer</div>
              <div class="col-sm-4 text-center">Post Answer</div>');
    }

    echo('</div></li>');
    foreach($answers as $inner_array){
        if ( ($i & 1) == 0 ) {
            echo('<li class="list-group-item">');
        }else{
            echo('<li class="list-group-item dark">');
        }
        echo('<div class="row">');
            if($wrapup == 1) {
                    echo('<div class="col-sm-3">');
                }else{
                    echo('<div class="col-sm-4">');
                }echo('<a  class = "nameLink" data-target="#' . $answers[$i]["user_id"] . '_All"  data-toggle="modal">' . $PP_DAO->findDisplayName($answers[$i]["user_id"]) . '</a></div>
                            <div class="modal fade" id="' . $answers[$i]["user_id"] . '_All" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">' . $PP_DAO->findDisplayName($answers[$i]["user_id"]) . '\'s Question Answers</h4>
                                        </div>
                                        <div class="modal-body scroll">
                                            <div class="row lines">
                                                <input type="hidden" name="pre_question" value="pre_question"/>
                                                <h4>Pre Question Answer</h4>
                                                <p>' . $answers[$i]["pre_answer"] . '</p>
                                            </div>
                                            <div class="row lines">
                                                <h4>Post Question Answer</h4>
                                                <input type="hidden" name="pre_question" value="pre_question"/>
                                                <p>' . $answers[$i]["post_answer"] . '</p>
                                            </div>');
                                            if($wrapup == 1) {
                                                echo('<div class="row lines">
                                                    <h4>Wrap Up Question Answer</h4>
                                                    <input type="hidden" name="pre_question" value="pre_question"/>
                                                    <p>' . $answers[$i]["wrap_up_answer"] . '</p>
                                                </div>');
                                            }
                                        echo('</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Exit</button>
                                        </div>
                                    </div>
                                </div>
                        </div>');
            if (isset($answers[$i]["pre_answer"])) {
                if($wrapup == 1) {
                    echo('<div class="col-sm-3 text-center">');
                }else{
                    echo('<div class="col-sm-4 text-center">');
                }
                echo('<span aria-hidden="true" class="fa fa-2x fa-check checkMark"></span></div>');
            }
            if (isset($answers[$i]["post_answer"])) {
                if($wrapup == 1) {
                    echo('<div class="col-sm-3 text-center">');
                }else{
                    echo('<div class="col-sm-4 text-center">');
                }
                echo('<span aria-hidden="true" class="fa fa-2x fa-check checkMark"></span></div>');
            }
        if($wrapup == 1) {
            if (isset($answers[$i]["wrap_up_answer"])) {
                echo('<div class="col-sm-3 text-center">
                    <span aria-hidden="true" class="fa fa-2x fa-check checkMark"></span>
                </div>');
            }
        }
        echo('</div></li>');
        $i++;
    }
    echo('</ul></div></div></div>');
}else{
    header('Location: ' . addSession('student-home.php'));
}
////////////////////////////-/////////////////////////////
$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();