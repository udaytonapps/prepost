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
if (!isset($student_answer["pre_modified"])) {
    echo('<div class="container-fluid">
    <div class="list-group">
        <a href="pre-question.php" class="list-group-item list-group-item-info">
        <div class="row">             
            <div class="col-sm-12 col-sm-offset-1 question-text">    
                <h4 class="list-group-item-heading">Pre Question</h4>
                <p class="list-group-item-text">Answer prior to the course</p>
            </div>
        </div>
        </a>
        <a href="post-question.php" class="list-group-item disabled">
        <div class="row">             
            <div class="col-sm-12 col-sm-offset-1 question-text">  
              <h4 class="list-group-item-heading">Post Question</h4>
              <p class="list-group-item-text">Answer after the course</p>
              </div>
          </div>
        </a>
        ');
        if($question["show_wrap_up_text"]==1)
        echo('
        <a href="wrap-up-question.php" class="list-group-item disabled">
        <div class="row">             
            <div class="col-sm-12 col-sm-offset-1 question-text">  
          <h4 class="list-group-item-heading">Wrap Up Question</h4>
          <p class="list-group-item-text">Answer after the other two questions</p>
          </div>
          </div>
        </a>
        ');
    echo('
    </div>
</div>');
}else if(!isset($student_answer["post_answer"])) {
    echo('<div class="container-fluid">
    <div class="list-group">
        <a href="pre-question.php" class="list-group-item disabled">
        <div class="row">             
            <div class="col-sm-1 question-text">   
                <span class="fa fa-3x fa-check"></span>
            </div>
            <div class="col-sm-11 question-text">   
                <h4 class="list-group-item-heading">Pre Question</h4>
                <p class="list-group-item-text">Answer prior to the course</p>
            </div>
        </div>
        </a>
        <a href="post-question.php" class="list-group-item  list-group-item-info">
        <div class="row">             
            <div class="col-sm-12 col-sm-offset-1 question-text">  
              <h4 class="list-group-item-heading">Post Question</h4>
              <p class="list-group-item-text">Answer after the course</p>
              </div>
          </div>
        </a>
         ');
        if($question["show_wrap_up_text"]==1)
        echo('
        <a href="wrap-up-question.php" class="list-group-item disabled">
        <div class="row">             
            <div class="col-sm-12 col-sm-offset-1 question-text">  
          <h4 class="list-group-item-heading">Wrap Up Question</h4>
          <p class="list-group-item-text">Answer after the other two questions</p>
          </div>
          </div>
        </a>
        ');
    echo('
    </div>
</div>');
}else if($question["show_wrap_up_text"]==1) {
    if(!isset($student_answer["wrap_up_answer"])) {
        echo('<div class="container-fluid">
        <div class="list-group">
            <a href="pre-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text">   
                    <h4 class="list-group-item-heading">Pre Question</h4>
                    <p class="list-group-item-text">Answer prior to the course</p>
                </div>
            </div>
            </a>
            <a href="post-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text">   
                  <h4 class="list-group-item-heading">Post Question</h4>
                  <p class="list-group-item-text">Answer after the course</p>
                  </div>
              </div>
            </a>
            <a href="wrap-up-question.php" class="list-group-item list-group-item-info">
            <div class="row">             
                <div class="col-sm-12 col-sm-offset-1 question-text">  
              <h4 class="list-group-item-heading">Wrap Up Question</h4>
              <p class="list-group-item-text">Answer after the other two questions</p>
              </div>
              </div>
            </a>
        </div>
        </div>');
    }else {
        echo('<div class="container-fluid">
        <div class="list-group">
            <a href="pre-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text">   
                    <h4 class="list-group-item-heading">Pre Question</h4>
                    <p class="list-group-item-text">Answer prior to the course</p>
                </div>
            </div>
            </a>
            <a href="post-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text">   
                  <h4 class="list-group-item-heading">Post Question</h4>
                  <p class="list-group-item-text">Answer after the course</p>
                  </div>
              </div>
            </a>
            <a href="wrap-up-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text">  
              <h4 class="list-group-item-heading">Wrap Up Question</h4>
              <p class="list-group-item-text">Answer after the other two questions</p>
              </div>
              </div>
            </a>
        </div>
        </div>');
    }
}else {
    echo('<div class="container-fluid">
        <div class="list-group">
            <a href="pre-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text ">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text">   
                    <h4 class="list-group-item-heading"><span class="text-muted">Pre Question</span></h4>
                    <p class="list-group-item-text text-muted">Answer prior to the course</p>
                </div>
            </div>
            </a>
            <a href="post-question.php" class="list-group-item disabled">
            <div class="row">             
                <div class="col-sm-1 question-text">   
                    <span class="fa fa-3x fa-check"></span>
                </div>
                <div class="col-sm-11 question-text text-muted">   
                  <h4 class="list-group-item-heading">Post Question</h4>
                  <p class="list-group-item-text">Answer after the course</p>
                  </div>
              </div>
            </a>
        </div>
        </div>');
}




////////////////////////////-/////////////////////////////
$OUTPUT->footerStart();
?>
    <!-- Our main javascript file for tool functions -->
    <script src="scripts/main.js" type="text/javascript"></script>
<?php
$OUTPUT->footerEnd();

