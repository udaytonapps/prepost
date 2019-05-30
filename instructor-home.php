<?php

require_once "../config.php";
require_once "dao/PP_DAO.php";

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

// Retrieve the launch data if present
$LTI = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

if (!$USER->instructor) {
    header('Location: ' . addSession('student-home.php'));
}

// Start of the output
$OUTPUT->header();

include("tool-header.html");

$OUTPUT->bodyStart();

$toolTitle = $PP_DAO->getMainTitle($_SESSION["main_id"]);

if (!$toolTitle) {
    $toolTitle = "Pre/Post Reflection";
}

$hasSetupMain = $PP_DAO->hasSetupMain($_SESSION["main_id"]);

include("menu.php");

?>
    <div class="container">
        <div id="toolTitle" class="h1">
            <button id="helpButton" type="button" class="btn btn-link pull-right" data-toggle="modal" data-target="#helpModal"><span class="fa fa-question-circle" aria-hidden="true"></span> Help</button>
            <span class="flx-cntnr flx-row flx-nowrap flx-start">
                <span class="title-text-span" onclick="PrePostJS.editTitleText();" tabindex="0"><?=$toolTitle?></span>
                <a id="toolTitleEditLink" class="toolTitleAction" href="javascript:void(0);" onclick="PrePostJS.editTitleText();">
                    <span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
                    <span class="sr-only">Edit Title Text</span>
                </a>
            </span>
        </div>
        <form id="toolTitleForm" action="actions/UpdateMainTitle.php" method="post" style="display:none;">
            <label for="toolTitleInput" class="sr-only">Title Text</label>
            <div class="h1 flx-cntnr flx-row flx-nowrap flx-start">
                <textarea class="title-edit-input flx-grow-all" id="toolTitleInput" name="toolTitle" rows="2"><?=$toolTitle?></textarea>
                <a id="toolTitleSaveLink" class="toolTitleAction" href="javascript:void(0);">
                    <span class="fa fa-fw fa-save" aria-hidden="true"></span>
                    <span class="sr-only">Save Title Text</span>
                </a>
                <a id="toolTitleCancelLink" class="toolTitleAction" href="javascript:void(0);">
                    <span class="fa fa-fw fa-times" aria-hidden="true"></span>
                    <span class="sr-only">Cancel Title Text</span>
                </a>
            </div>
        </form>
        <p class="lead">Create a question that students can respond to before and after an activity.</p>
<?php

if (!$hasSetupMain) {
    // Instructor hasn't setup the pre and post yet so show the form.
    ?>
    <form action="actions/CreatePrePost.php" method="post">
        <h3>Pre-Question</h3>
        <div class="form-group">
            <label for="preQuestionTextInput" class="sr-only">Pre-Question Text</label>
            <textarea class="form-control" id="preQuestionTextInput" name="preQuestionText" rows="3" required></textarea>
        </div>
        <h3>Wait Time <small>Optional</small></h3>
        <p>How long must students wait between completing their pre-response and starting their post-response?</p>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group flx-cntnr flx-row flx-nowrap flx-start">
                    <label for="waitTime" class="sr-only">Wait Time</label>
                    <input type="text" class="form-control" id="waitTime" name="waitTime">
                    <label for="waitTimeUnit" class="sr-only">Wait Time Unit</label>
                    <select class="form-control" id="waitTimeUnit" name="waitTimeUnit">
                        <option value="min">Minutes</option>
                        <option value="hrs">Hours</option>
                        <option value="days">Days</option>
                    </select>
                </div>
            </div>
        </div>
        <h3>Post-Question</h3>
        <div class="form-group">
            <label for="postQuestionTextInput" class="sr-only">Post-Question Text</label>
            <textarea class="form-control" id="postQuestionTextInput" name="postQuestionText" rows="3" required></textarea>
        </div>
        <h3>Wrap-Up Question <small>Optional</small></h3>
        <p>A wrap-up question can be used to give users a third text box to reflect on how their answer changed between their pre and post responses.</p>
        <div class="form-group">
            <label for="wrapUpQuestionTextInput" class="sr-only">Wrap-Up Question Text</label>
            <textarea class="form-control" id="wrapUpQuestionTextInput" name="wrapUpQuestionText" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
    <?php
} else {
    // Instructor setup the pre and post question once so show the interactive build page
    $mainInfo = $PP_DAO->getMainInfo($_SESSION["main_id"]);
    ?>
    <section id="theQuestions">
        <h2 class="hdr-nobot-mrgn"><small>Pre-Question</small></h2>
        <div id="preQuestionRow" class="h3 inline hdr-notop-mrgn flx-cntnr flx-row flx-nowrap flx-start question-row">
            <div class="flx-grow-all question-text">
                <span class="question-text-span" onclick="PrePostJS.editPreQuestionText();" id="questionTextPre" tabindex="0"><?= $mainInfo["pre_question"] ?></span>
                <form id="preQuestionTextForm" action="actions/UpdatePreQuestion.php" method="post" style="display:none;">
                    <label for="preQuestionTextInput" class="sr-only">Pre-Question Text</label>
                    <textarea class="form-control" id="preQuestionTextInput" name="questionText" rows="2" required><?= $mainInfo["pre_question"] ?></textarea>
                </form>
            </div>
            <a id="preQuestionEditAction" href="javascript:void(0);" onclick="PrePostJS.editPreQuestionText();">
                <span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
                <span class="sr-only">Edit Pre-Question Text</span>
            </a>
            <a id="preQuestionSaveAction" href="javascript:void(0);" style="display:none;">
                <span aria-hidden="true" class="fa fa-fw fa-save"></span>
                <span class="sr-only">Save Pre-Question</span>
            </a>
            <a id="preQuestionCancelAction" href="javascript:void(0);" style="display: none;">
                <span aria-hidden="true" class="fa fa-fw fa-times"></span>
                <span class="sr-only">Cancel Pre-Question</span>
            </a>
        </div>
        <h2 class="hdr-right-icon-mrgn flx-cntnr flx-row flx-nowrap flx-center"><span class="fa fa-clock-o hdr-icon-cntr" aria-hidden="true"></span> <small>Wait Time</small></h2>
        <?php
        $waitTimeText = '<em>No wait time set.</em>';
        if ($mainInfo["wait_seconds"] > 0) {
            $waitTimeText = secondsToTime($mainInfo["wait_seconds"]);
            if ($mainInfo["wait_seconds"] % (24*60*60) === 0) {
                $waitUnit = "days";
                $waitTime = $mainInfo["wait_seconds"] / 24 / 60 / 60;
            } else if ($mainInfo["wait_seconds"] % (60*60) === 0) {
                $waitUnit = "hrs";
                $waitTime = $mainInfo["wait_seconds"] / 60 / 60;
            } else {
                $waitUnit = "min";
                $waitTime = $mainInfo["wait_seconds"] / 60;
            }
        }
        ?>
        <div id="waitTimeRow" class="h3 inline hdr-notop-mrgn flx-cntnr flx-row flx-nowrap flx-start question-row">
            <div class="flx-grow-all text-center question-text">
                <span class="h4 inline question-text-span" onclick="PrePostJS.editWaitTime()" id="waitTimeText" tabindex="0"><?= $waitTimeText ?></span>
                <form id="waitTimeForm" action="actions/UpdateWaitTime.php" method="post" style="display:none;">
                    <div class="form-group flx-cntnr flx-row flx-nowrap flx-start">
                        <label for="waitTime" class="sr-only">Wait Time</label>
                        <input type="text" class="form-control" id="waitTime" name="waitTime" value="<?= $waitTime ?>">
                        <label for="waitTimeUnit" class="sr-only">Wait Time Unit</label>
                        <select class="form-control" id="waitTimeUnit" name="waitTimeUnit">
                            <option <?= $waitUnit === 'min' ? 'selected' : '' ?> value="min">Minutes</option>
                            <option <?= $waitUnit === 'hrs' ? 'selected' : '' ?> value="hrs">Hours</option>
                            <option <?= $waitUnit === 'days' ? 'selected' : '' ?> value="days">Days</option>
                        </select>
                    </div>
                </form>
            </div>
            <a id="waitTimeEditAction" href="javascript:void(0);" onclick="PrePostJS.editWaitTime()">
                <span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
                <span class="sr-only">Edit Wait Time</span>
            </a>
            <a id="waitTimeSaveAction" href="javascript:void(0);" style="display:none;">
                <span aria-hidden="true" class="fa fa-fw fa-save"></span>
                <span class="sr-only">Save Wait Time</span>
            </a>
            <a id="waitTimeCancelAction" href="javascript:void(0);" style="display: none;">
                <span aria-hidden="true" class="fa fa-fw fa-times"></span>
                <span class="sr-only">Cancel Wait Time</span>
            </a>
        </div>
        <h2 class="hdr-nobot-mrgn"><small>Post-Question</small></h2>
        <div id="postQuestionRow" class="h3 inline hdr-notop-mrgn flx-cntnr flx-row flx-nowrap flx-start question-row">
            <div class="flx-grow-all question-text">
                <span class="question-text-span" onclick="PrePostJS.editPostQuestionText();" id="questionTextPost" tabindex="0"><?= $mainInfo["post_question"] ?></span>
                <form id="postQuestionTextForm" action="actions/UpdatePostQuestion.php" method="post" style="display:none;">
                    <label for="postQuestionTextInput" class="sr-only">Post-Question Text</label>
                    <textarea class="form-control" id="postQuestionTextInput" name="questionText" rows="2" required><?= $mainInfo["post_question"] ?></textarea>
                </form>
            </div>
            <a id="postQuestionEditAction" href="javascript:void(0);" onclick="PrePostJS.editPostQuestionText();">
                <span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
                <span class="sr-only">Edit Post-Question Text</span>
            </a>
            <a id="postQuestionSaveAction" href="javascript:void(0);" style="display:none;">
                <span aria-hidden="true" class="fa fa-fw fa-save"></span>
                <span class="sr-only">Save Post-Question</span>
            </a>
            <a id="postQuestionCancelAction" href="javascript:void(0);" style="display: none;">
                <span aria-hidden="true" class="fa fa-fw fa-times"></span>
                <span class="sr-only">Cancel Post-Question</span>
            </a>
        </div>
        <hr>
        <h2 class="hdr-nobot-mrgn"><small>Wrap-Up Question</small></h2>
        <div id="wrapQuestionRow" class="h3 inline hdr-notop-mrgn flx-cntnr flx-row flx-nowrap flx-start question-row">
            <div class="flx-grow-all question-text">
                <span class="question-text-span" onclick="PrePostJS.editWrapQuestionText()" id="questionTextWrap" tabindex="0">
                    <?= (!$mainInfo["wrap_question"] || trim(!$mainInfo["wrap_question"]) === '') ? '<em>No wrap-up question.</em>' : $mainInfo["wrap_question"] ?>
                </span>
                <form id="wrapQuestionTextForm" action="actions/UpdateWrapQuestion.php" method="post" style="display:none;">
                    <label for="wrapQuestionTextInput" class="sr-only">Wrap-Up Question Text</label>
                    <textarea class="form-control" id="wrapQuestionTextInput" name="questionText" rows="2" required><?= !$mainInfo["wrap_question"] ? '' : $mainInfo["wrap_question"] ?></textarea>
                </form>
            </div>
            <a id="wrapQuestionEditAction" href="javascript:void(0);" onclick="PrePostJS.editWrapQuestionText()">
                <span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
                <span class="sr-only">Edit Wrap-Up Question Text</span>
            </a>
            <a id="wrapQuestionSaveAction" href="javascript:void(0);" style="display:none;">
                <span aria-hidden="true" class="fa fa-fw fa-save"></span>
                <span class="sr-only">Save Wrap-Up Question</span>
            </a>
            <a id="wrapQuestionCancelAction" href="javascript:void(0);" style="display: none;">
                <span aria-hidden="true" class="fa fa-fw fa-times"></span>
                <span class="sr-only">Cancel Wrap-Up Question</span>
            </a>
        </div>
    </section>
    <?php
}
?>
    </div>

    <input type="hidden" id="sess" value="<?php echo($_GET["PHPSESSID"]) ?>">
<?php

include("help.php");

$OUTPUT->footerStart();

include("tool-footer.html");

$OUTPUT->footerEnd();

function secondsToTime($seconds) {
    $dtF = new DateTime('@0');
    $dtT = new DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}