<?php
require_once('../config.php');

use \Tsugi\Core\LTIX;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

// Start of the output
$OUTPUT->header();

$OUTPUT->bodyStart();

$OUTPUT->topNav();

if ($USER->instructor) {
    $OUTPUT->splashPage(
        "Pre/Post Reflection",
        __("Create questions for a student to answer<br />before and after an activity."),
        "actions/MarkSeenGoToHome.php"
    );
} else {
    $OUTPUT->splashPage(
        "Pre/Post Reflection",
        __("Your instructor has not yet configured this learning app.")
    );
}

$OUTPUT->footerStart();

$OUTPUT->footerEnd();