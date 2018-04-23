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
echo('<div class="container-fluid">
    <div class="row">      
        <div class="col-sm-5 col-sm-offset-1 text-left "> <h2>'.$question["question_title"].'</h2></div> 
        <div class="col-sm-6 text-right question-actions">
            <a class="btn btn-primary"  data-toggle="modal">Preview</a>
            <a class="btn btn-success" data-toggle="modal">Edit</a>
            <a class="btn btn-danger" action="actions/removequestion.php">
                <span class="fa fa-trash"></span>
            </a>
        </div>
    </div>
    
    <div id="questionContainer">
    
    <!--Pre Question-->
    <div class="row">  
        <div class="col-sm-8 col-sm-offset-1 question-text">    
        <h4>Pre Question</h4>
        </div>
    </div>
    <div class="row">          
        <div class="col-sm-8 col-sm-offset-1 question-text">    
        <textarea class="form-control" name="Question" rows="4" disabled="disabled">'.$question["pre_question"].'</textarea>
        </div>
        <div class="col-sm-3 text-right question-actions">
            <a class="btn btn-primary"  data-toggle="modal">Report</a>
            <a class="btn btn-success" data-toggle="modal">Edit</a>
            <a class="btn btn-danger" action="actions/removequestion.php">
                <span class="fa fa-trash"></span>
            </a>
        </div>
    </div>
    
    <!--Post Question-->
    <div class="row">     
        <div class="col-sm-8 col-sm-offset-1 question-text">    
        <h4>Post Question</h4>
        </div>
    </div>
    <div class="row">             
        <div class="col-sm-8 col-sm-offset-1 question-text">    
        <textarea class="form-control" name="Question" rows="4" disabled="disabled">'.$question["post_question"].'</textarea>
        </div>
        <div class="col-sm-3 text-right question-actions">
            <a class="btn btn-primary"  data-toggle="modal">Report</a>
            <a class="btn btn-success" data-toggle="modal">Edit</a>
            <a class="btn btn-danger" action="actions/removequestion.php">
                <span class="fa fa-trash"></span>
            </a>
        </div>
    </div>
    
    <!--Wrap up question-->
    <div class="row">   
        <div class="col-sm-8 col-sm-offset-1 question-text">    
        <div class="checkbox">
            <label><h4><input type="checkbox" name="show_wrap_up_text" id="show_wrap_up_text>
            <!--label><h4><input type="checkbox" name="show_wrap_up_text" id="show_wrap_up_text" onclick="PrePostJS.toggleWrapUpTextBox();"-->
            Include Wrap-up Question
            </h4></label>
        </div>
        </div>
    </div>
    <div class="row">  
    
        <div class="col-sm-8 col-sm-offset-1 question-text">    
          <p>A wrap-up question can be used to give users a third text box to reflect on how their answer changed between their pre and post entries.</p>
        </div>
    </div>
    <div class="row">        
        <div class="col-sm-8 col-sm-offset-1 question-text">    
        <textarea class="form-control" name="PrePostWrapUpText" id="prePostWrapUpText" rows="4" disabled="disabled">'.$question["wrap_up_text"].'</textarea>
        </div>
        <div class="col-sm-3 text-right question-actions">
            <a class="btn btn-primary"  data-toggle="modal">Report</a>
            <a class="btn btn-success" data-toggle="modal">Edit</a>
            <a class="btn btn-danger" action="actions/removequestion.php">
                <span class="fa fa-trash"></span>
            </a>
        </div>
    </div>
    </div>
</div>');
////////////////////////////-/////////////////////////////
$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();

