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

?>
    <style type="text/css">
        body {
            background-color: #1066EB;
        }
    </style>
<?php

$OUTPUT->bodyStart();
?>
    <section class="splash-container">
        <article class="splash-content">
            <header><h1 class="splash-header">Pre/Post Reflection</h1></header>
            <?php
            if ($USER->instructor) {
                ?>
                <p class="lead">Create questions for a student to answer<br />before and after an activity.</p>
                <a href="actions/MarkSeenGoToHome.php" class="btn btn-success">Get Started</a>
                <?php
            } else {
                ?>
                <p class="lead">Your instructor has not yet configured this learning app.</p>
                <?php
            }
            ?>
        </article>
    </section>
<?php
$OUTPUT->footerStart();

$OUTPUT->footerEnd();
