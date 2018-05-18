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
$numAnswers =sizeof($answers);

if ($USER->instructor) {
    echo('<div class="container-fluid">
        <div class="row">      
            <div class="col-sm-5 col-sm-offset-1 text-left "> <h2>' . $question["question_title"] . '</h2></div> 
            <div class="col-sm-6 text-right question-actions">
                <a href="#Edit_Title" class="btn btn-warning" data-toggle="modal">
                    <span class="fa fa-pencil" aria-hidden="true" title="Edit Title"></span><span class="sr-only">Edit Title</span>
                </a>
                <a href="actions/RemoveQuestion.php" class="btn btn-danger delete-video" onclick="return PrePostJS.deleteQuestionConfirm();">
                    <span class="fa fa-trash" aria-hidden="true" title="Delete Question"></span><span class="sr-only">Delete Question</span>
                </a>
            </div>
            <!-- Edit Question Title Modal -->
            <div class="modal fade" id="Edit_Title" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Question Title</h4>
                        </div>
                        <form method="post"  action="actions/EditQuestion.php">
                                <div class="modal-body scroll">
                                    <input type="hidden" name="question_title" value="question_title"/>
                                    <textarea class="form-control" name="titleText" rows="4" autofocus required>' . $question["question_title"] . '</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="questionContainer">
        <!--Pre Question-->
        <div class="row">  
            <div class="col-sm-9 col-sm-offset-1 question-text">
            <h4>Pre Question</h4>
            </div>
        </div>
        <div class="row">          
            <div class="col-sm-8 col-sm-offset-1 question-text">
            <textarea class="form-control" name="Question" rows="4" disabled="disabled">' . $question["pre_question"] . '</textarea>
            </div>
            <div class="col-sm-3 text-right question-actions">
                <a href="#Pre_Question_Report" class="btn btn-primary"  data-toggle="modal">Results (' .$numAnswers. ')</a>
                <a href="#Edit_Pre_Question" class="btn btn-warning" data-toggle="modal">
                    <span class="fa fa-pencil" aria-hidden="true" title="Edit Pre Question"></span><span class="sr-only">Edit Pre Question</span>
                </a>
            </div>
            <!-- Edit pre Question Text Modal -->
            <div class="modal fade" id="Edit_Pre_Question" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Pre Question Text</h4>
                        </div>
                        <form method="post"  action="actions/EditQuestion.php">
                                <div class="modal-body scroll">
                                    <input type="hidden" name="pre_question" value="pre_question"/>
                                    <textarea class="form-control" name="preQuestion" rows="4" autofocus required>' . $question["pre_question"] . '</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pre_Question_Report Modal -->
            <div class="modal fade" id="Pre_Question_Report" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary ">
                            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times bg-primary" aria-hidden="true"></span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Pre-Question Report</h4>
                        </div>
                        <div class="modal-body scroll student-answers">');
                            $i = 0;
                            if ($numAnswers === 0) {
                                echo('<h4 class=\'text-center\'><em>No students have answered this question yet.</em></h4>');
                            } else {
                                foreach ( $answers as $inner_array ) {
                                    $UserID = $answers[$i]["user_id"];

                                    $displayName = $PP_DAO->findDisplayName($UserID);

                                    $answerText = $answers[$i]["pre_answer"];
                                    $answerDate = new DateTime($answers[$i]["pre_modified"]);

                                    $formattedDate = $answerDate->format("m-d-y")." at ".$answerDate->format("h:i A");

                                    echo('<div class="row lines">
                                        <div class="col-sm-3"><strong>'.$displayName.'</strong><br /><small>'.$formattedDate.'</small></div>
                                        <div class="col-sm-9">'.$answerText.'</div>
                                      </div>');
                                    $i++;
                                }
                            }
                        echo('</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Post Question-->
        <div class="row">
            <div class="col-sm-9 col-sm-offset-1 question-text">
            <h4>Post Question</h4>
            </div>
        </div>
        <div class="row">             
            <div class="col-sm-8 col-sm-offset-1 question-text">
            <textarea class="form-control" name="Question" rows="4" disabled="disabled">' . $question["post_question"] . '</textarea>
            </div>
            <div class="col-sm-3 text-right question-actions">
                <a href="#Post_Question_Report" class="btn btn-primary"  data-toggle="modal">Results (' .$numAnswers. ')</a>
                <a href="#Edit_Post_Question" class="btn btn-warning" data-toggle="modal">
                    <span class="fa fa-pencil" aria-hidden="true" title="Edit Post Question"></span><span class="sr-only">Edit Post Question</span>
                </a>
            </div>
            <!-- Edit Post Question Text Modal -->
            <div class="modal fade" id="Edit_Post_Question" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Post Question Text</h4>
                        </div>
                        <form method="post"  action="actions/EditQuestion.php">
                                <div class="modal-body scroll">
                                    <input type="hidden" name="post_question" value="post_question"/>
                                    <textarea class="form-control" name="postQuestion" rows="4" autofocus required>' . $question["post_question"] . '</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Post_Question_Report Modal -->
            <div class="modal fade" id="Post_Question_Report" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary ">
                            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times bg-primary" aria-hidden="true"></span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Post-Question Report</h4>
                        </div>
                        <div class="modal-body scroll student-answers">');
                            $i = 0;
                            if ($numAnswers === 0) {
                                echo('<h4 class=\'text - center\'><em>No students have answered this question yet.</em></h4>');
                            } else {
                                foreach ( $answers as $inner_array ) {
                                    $UserID = $answers[$i]["user_id"];

                                    $displayName = $PP_DAO->findDisplayName($UserID);

                                    $answerText = $answers[$i]["post_answer"];
                                    $answerDate = new DateTime($answers[$i]["post_modified"]);

                                    $formattedDate = $answerDate->format("m-d-y")." at ".$answerDate->format("h:i A");

                                    echo('<div class="row lines">
                                        <div class="col-sm-3"><strong>'.$displayName.'</strong><br /><small>'.$formattedDate.'</small></div>
                                        <div class="col-sm-9">'.$answerText.'</div>
                                      </div>');
                                    $i++;
                                }
                            }
                        echo('</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--Wrap up question--> 
        <div class="row">     
            <div class="col-sm-9 col-sm-offset-1 question-text">    
                <div class="checkbox">
                <label><h4><input type="checkbox" name="show_wrap_up_text" id="show_wrap_up_text" onclick="PrePostJS.toggleWrapUp();"
                    ');
                        if($question["show_wrap_up_text"]== 1) {
                            echo('checked="checked"');
                        }
                echo('>Include Wrap-up Question</h4></label></div>
                <div class="col-sm-9 col-sm-offset-0 question-text">
                  <p>A wrap-up question can be used to give users a third text box to reflect on how their answer changed between their pre and post entries.</p>
                </div>
            </div>
        </div>
        <div class="row" id="wrapUpRowTitle"');
        if($question["show_wrap_up_text"]!= 1) {
            echo('hidden="false"');
        }
        echo('> 
            <div class="col-sm-9 col-sm-offset-1 question-text">
            <h4>Wrap Up Question</h4>
            </div>
        </div>   
        <div class="row" id="wrapUpRow"');
        if($question["show_wrap_up_text"]!= 1) {
            echo('hidden="false"');
        }
        echo('>     
            <div class="col-sm-8 col-sm-offset-1 question-text">    
            <textarea class="form-control" name="PrePostWrapUpText" id="prePostWrapUpText" rows="4" disabled="disabled">' . $question["wrap_up_text"] . '</textarea>
            </div>
            <div class="col-sm-3 text-right question-actions">
                <a href="#Wrap_Up_Question_Report" class="btn btn-primary"  data-toggle="modal">Results (' .$numAnswers. ')</a>
                <a href="#Edit_Wrap_Up_Text" class="btn btn-warning" data-toggle="modal">
                    <span class="fa fa-pencil" aria-hidden="true" title="Edit Wrap Up Text"></span><span class="sr-only">Edit Wrap Up Question</span>
                </a>
            </div>
            <!-- Edit Wrap Up Question Text Modal -->
            <div class="modal fade" id="Edit_Wrap_Up_Text" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Wrap Up Question Text</h4>
                        </div>
                        <form method="post"  action="actions/EditQuestion.php">
                                <div class="modal-body scroll">
                                    <input type="hidden" name="wrap_up_text" value="wrap_up_text"/>
                                    <textarea class="form-control" name="wrapUpQuestion" rows="4" autofocus required>' . $question["wrap_up_text"] . '</textarea>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Post_Question_Report Modal -->
            <div class="modal fade" id="Wrap_Up_Question_Report" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary ">
                            <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times bg-primary" aria-hidden="true"></span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Wrap-Up-Question Report</h4>
                        </div>
                        <div class="modal-body scroll student-answers">');
                            $i = 0;
                            if ($numAnswers === 0) {
                                echo('<h4 class=\'text - center\'><em>No students have answered this question yet.</em></h4>');
                            } else {
                                foreach ( $answers as $inner_array ) {
                                    $UserID = $answers[$i]["user_id"];

                                    $displayName = $PP_DAO->findDisplayName($UserID);

                                    $answerText = $answers[$i]["wrap_up_answer"];
                                    $answerDate = new DateTime($answers[$i]["wrap_up_modified"]);

                                    $formattedDate = $answerDate->format("m-d-y")." at ".$answerDate->format("h:i A");

                                    echo('<div class="row lines">
                                        <div class="col-sm-3"><strong>'.$displayName.'</strong><br /><small>'.$formattedDate.'</small></div>
                                        <div class="col-sm-9">'.$answerText.'</div>
                                      </div>');
                                    $i++;
                                }
                            }
                        echo('</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>');
?>
<input type="hidden" id="sess" value="<?php echo($_GET["PHPSESSID"]); ?>">
<?php
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

