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
echo('<div class="container-fluid">
    <div class="row"><h2>' .$question["question_title"].'</h2></div>
    <div id="exit_page_container">
        <div class="row">    
            <a href="pre-question.php">
                   <input type="submit" class="btn btn-success" value="Pre Question">             
            </a>
        </div>
        <div class="row">  
            <a href="post-question.php">
                   <input type="submit" class="btn btn-success" value="Post Question">             
            </a>
        </div>
        <div class="row">  
            <a href="wrap-up-question.php">
                   <input type="submit" class="btn btn-success" value="Wrap up">             
            </a>
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

