<?php

require_once('../config.php');
require_once('dao/PP_DAO.php');

use \Tsugi\Core\LTIX;
use \PP\DAO\PP_DAO;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

// Start of the output
$OUTPUT->header();

include("tool-header.html");

$OUTPUT->bodyStart();

$toolTitle = $PP_DAO->getMainTitle($_SESSION["main_id"]);

if (!$toolTitle) {
    $toolTitle = "Pre/Post Reflection";
}

include("menu.php");

if ($PP_DAO->hasSetupMain($_SESSION["main_id"])) {
    $mainInfo = $PP_DAO->getMainInfo($_SESSION["main_id"]);
    $studentResponses = $PP_DAO->getStudentResponses($_SESSION["main_id"], $USER->id);
    ?>
    <div class="container">
        <h1>
            <button id="helpButton" type="button" class="btn btn-link pull-right" data-toggle="modal"
                    data-target="#helpModal"><span class="fa fa-question-circle" aria-hidden="true"></span> Help
            </button>
            <?= $toolTitle ?>
        </h1>
        <h2 class="hdr-nobot-mrgn"><small>Pre-Question</small></h2>
        <?php
        if (!$studentResponses || !$studentResponses["pre_answer"] || trim($studentResponses["pre_answer"]) === '') {
            // No pre answer so show submission form
            ?>
            <form id="answerFormPre" action="actions/AnswerPreQuestion.php" method="post">
                <div class="form-group">
                    <label class="h3" for="answerTextPre"><?= $mainInfo["pre_question"] ?></label>
                    <textarea class="form-control" id="answerTextPre" name="answerTextPre" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
            <?php
        } else {
            // Student answered the pre question
            $preDateTime = new DateTime($studentResponses['pre_modified']);
            $formattedPreDate = $preDateTime->format("m/d/y") . " | " . $preDateTime->format("h:i A");
            ?>
            <h3 class="sub-hdr"><?= $mainInfo["pre_question"] ?></h3>
            <p>Submitted <?= $formattedPreDate ?></p>
            <?php
            if (isPostReleased($studentResponses["pre_modified"], new DateTime('now', new DateTimeZone($CFG->timezone)), $mainInfo["wait_seconds"])) {
                // if post is not complete show post form
                if (!$studentResponses["post_answer"] || trim($studentResponses["post_answer"]) === '') {
                    ?>
                    <p class="alert alert-info">Your response will be available once you have responded to the post-question.</p>
                    <h2 class="hdr-nobot-mrgn"><small>Post-Question</small></h2>
                    <form id="answerFormPost" action="actions/AnswerPostQuestion.php" method="post">
                        <div class="form-group">
                            <label class="h3" for="answerTextPost"><?= $mainInfo["post_question"] ?></label>
                            <textarea class="form-control" id="answerTextPost" name="answerTextPost" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                    <?php
                } else {
                    // Post was finished so show responses and wrap-up form if needed
                    $postDateTime = new DateTime($studentResponses['post_modified']);
                    $formattedPostDate = $postDateTime->format("m/d/y") . " | " . $postDateTime->format("h:i A");
                    ?>
                    <p><?= $studentResponses["pre_answer"] ?></p>
                    <h2 class="hdr-nobot-mrgn"><small>Post-Question</small></h2>
                    <h3 class="sub-hdr"><?= $mainInfo["post_question"] ?></h3>
                    <p>Submitted <?= $formattedPostDate ?></p>
                    <p><?= $studentResponses["post_answer"] ?></p>
                    <?php
                    if ($mainInfo["wrap_question"] && trim($mainInfo["wrap_question"] !== '')) {
                        // There is a wrap question
                        ?>
                        <h2 class="hdr-nobot-mrgn"><small>Wrap-Up Question</small></h2>
                        <?php
                        if (!$studentResponses["wrap_answer"] || trim($studentResponses["wrap_answer"]) === '') {
                            // No response to wrap-up yet
                            ?>
                            <form id="answerFormWrap" action="actions/AnswerWrapQuestion.php" method="post">
                                <div class="form-group">
                                    <label class="h3" for="answerTextWrap"><?= $mainInfo["wrap_question"] ?></label>
                                    <textarea class="form-control" id="answerTextWrap" name="answerTextWrap" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                            <?php
                        } else {
                            $wrapDateTime = new DateTime($studentResponses['wrap_modified']);
                            $formattedWrapDate = $wrapDateTime->format("m/d/y") . " | " . $wrapDateTime->format("h:i A");
                            ?>
                            <h3 class="sub-hdr"><?= $mainInfo["wrap_question"] ?></h3>
                            <p>Submitted <?= $formattedWrapDate ?></p>
                            <p><?= $studentResponses["wrap_answer"] ?></p>
                            <?php
                        }
                    }
                }
            } else {
                ?>
                <p class="alert alert-info">Your response will be available once you have responded to the post-question.</p>
                <h2 class="hdr-nobot-mrgn"><small>Post-Question</small></h2>
                <p class="alert alert-warning alert-padding">The post-question will be available <strong><?= secondsToTime($mainInfo["wait_seconds"]) ?></strong> after you respond to the pre-question.</p>
                <?php
            }
        }
        ?>
    </div>
    <?php
} else {
    ?>
    <div class="container">
        <h1>Pre/Post Reflection</h1>
        <p class="lead">Your instructor has not yet configured this learning app.</p>
    </div>
    <?php
}

include("help.php");

$OUTPUT->footerStart();

include("tool-footer.html");

$OUTPUT->footerEnd();

function isPostReleased($preModified, $currentTime, $waitSeconds) {
    $preModifiedDate = new DateTime($preModified);
    $timeDifference = $currentTime->getTimestamp() - $preModifiedDate->getTimestamp();
    return $timeDifference > $waitSeconds;
}

function secondsToTime($seconds) {
    $days = floor($seconds / (3600*24));
    $seconds  -= $days*3600*24;
    $hours = floor($seconds/3600);
    $seconds -= $hours*3600;
    $minutes = floor($seconds/60);

    $waitTimeString = '';
    if ($days != 0) {
        if ($days == 1) {
            $waitTimeString = $days . ' day';
        } else {
            $waitTimeString = $days . ' days';
        }
    }
    if ($hours != 0) {
        if ($hours == 1) {
            $waitTimeString = $waitTimeString === '' ? $hours . ' hour' : $waitTimeString . ', ' . $hours . ' hour';
        } else {
            $waitTimeString = $waitTimeString === '' ? $hours . ' hour' : $waitTimeString . ', ' . $hours . ' hours';
        }
    }
    if ($minutes != 0) {
        if ($minutes == 1) {
            $waitTimeString = $waitTimeString === '' ? $minutes .' minute' : $waitTimeString . ', ' . $minutes .' minute';
        } else {
            $waitTimeString = $waitTimeString === '' ? $minutes .' minutes' : $waitTimeString . ', ' . $minutes .' minutes';
        }
    }
    return $waitTimeString;
}