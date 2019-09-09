<?php

require_once('../config.php');
require_once('dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

include("menu.php");

$mainInfo = $PP_DAO->getMainInfo($_SESSION["main_id"]);

$students = $PP_DAO->getUsersWithAnswers($_SESSION["main_id"]);
$studentAndDate = array();
foreach($students as $student) {
    $studentAndDate[$student["user_id"]] = new DateTime($PP_DAO->getMostRecentAnswerDate($_SESSION["main_id"], $student["user_id"]));
}

// Start of the output
$OUTPUT->header();

include("tool-header.html");

$OUTPUT->bodyStart();

$OUTPUT->topNav($menu);

echo('<div class="container-fluid">');

$OUTPUT->flashMessages();

$OUTPUT->pageTitle("Results <small>by Question</small>", true);

?>
    <section id="studentResponses">
        <div class="panel panel-info">
            <div class="panel-heading response-panel-header">
                <div class="row">
                    <div class="col-xs-3">
                        <h4 class="results-table-hdr">Student Name</h4>
                    </div>
                    <div class="col-xs-3 text-center">
                        <h4 class="results-table-hdr">Pre-Question</h4>
                    </div>
                    <div class="col-xs-3 text-center">
                        <h4 class="results-table-hdr">Post-Question</h4>
                    </div>
                    <div class="col-xs-3 text-center">
                        <h4 class="results-table-hdr">Wrap-Up Question</h4>
                    </div>
                </div>
            </div>
            <div class="list-group">
                <?php
                // Sort students by mostRecentDate desc
                arsort($studentAndDate);
                foreach ($studentAndDate as $student_id => $mostRecentDate) {
                    if (!$PP_DAO->isUserInstructor($CONTEXT->id, $student_id)) {
                        $responses = $PP_DAO->getStudentResponses($_SESSION["main_id"], $student_id);
                        $formattedPreDate = '';
                        $formattedPostDate = '';
                        $formattedWrapDate = '';
                        if ($responses["pre_modified"]) {
                            $preDate = new DateTime($responses["pre_modified"]);
                            $formattedPreDate = $preDate->format("m/d/y") . " | " . $preDate->format("h:i A");
                        }
                        if ($responses["post_modified"]) {
                            $postDate = new DateTime($responses["post_modified"]);
                            $formattedPostDate = $postDate->format("m/d/y") . " | " . $postDate->format("h:i A");
                        }
                        if ($responses["wrap_modified"]) {
                            $wrapDate = new DateTime($responses["wrap_modified"]);
                            $formattedWrapDate = $wrapDate->format("m/d/y") . " | " . $wrapDate->format("h:i A");
                        }
                        ?>
                        <div class="list-group-item response-list-group-item">
                            <div class="row">
                                <div class="col-xs-3 header-col">
                                    <a href="#responses<?= $student_id ?>" class="h4 response-collapse-link" data-toggle="collapse">
                                        <?= $PP_DAO->findDisplayName($student_id) ?>
                                        <span class="fa fa-chevron-down rotate" aria-hidden="true"></span>
                                    </a>
                                </div>
                                <div class="col-xs-3 text-center header-col">
                                    <span class="h5 inline"><?= $formattedPreDate ?></span>
                                </div>
                                <div class="col-xs-3 text-center header-col">
                                    <span class="h5 inline"><?= $formattedPostDate ?></span>
                                </div>
                                <div class="col-xs-3 text-center header-col">
                                    <span class="h5 inline"><?= $formattedWrapDate ?></span>
                                </div>
                                <div id="responses<?= $student_id ?>" class="col-xs-12 results-collapse collapse">
                                    <div class="row response-row">
                                        <div class="col-sm-3">
                                            <h4 class="small-hdr hdr-notop-mrgn">
                                                <small>Pre-Question</small>
                                            </h4>
                                            <h5 class="sub-hdr"><?= $mainInfo["pre_question"] ?></h5>
                                        </div>
                                        <div class="col-sm-offset-1 col-sm-8">
                                            <p class="response-text"><?= $responses["pre_answer"] ?></p>
                                        </div>
                                    </div>
                                    <div class="row response-row">
                                        <div class="col-sm-3">
                                            <h4 class="small-hdr hdr-notop-mrgn">
                                                <small>Post-Question</small>
                                            </h4>
                                            <h5 class="sub-hdr"><?= $mainInfo["post_question"] ?></h5>
                                        </div>
                                        <div class="col-sm-offset-1 col-sm-8">
                                            <p class="response-text"><?= $responses["post_answer"] ?></p>
                                        </div>
                                    </div>
                                    <div class="row response-row">
                                        <div class="col-sm-3">
                                            <h4 class="small-hdr hdr-notop-mrgn">
                                                <small>Wrap-Up Question</small>
                                            </h4>
                                            <h5 class="sub-hdr"><?= $mainInfo["wrap_question"] ?></h5>
                                        </div>
                                        <div class="col-sm-offset-1 col-sm-8">
                                            <p class="response-text"><?= $responses["wrap_answer"] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
<?php

include("help.php");

$OUTPUT->footerStart();

include("tool-footer.html");

$OUTPUT->footerEnd();
