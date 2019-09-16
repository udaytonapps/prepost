<?php

require_once('../config.php');
require_once('dao/PP_DAO.php');

use PP\DAO\PP_DAO;
use Tsugi\Core\LTIX;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$p = $CFG->dbprefix;

$PP_DAO = new PP_DAO($PDOX, $p);

include("menu.php");

$mainInfo = $PP_DAO->getMainInfo($_SESSION["main_id"]);

// Start of the output
$OUTPUT->header();

include("tool-header.html");

$OUTPUT->bodyStart();

$OUTPUT->topNav($menu);

echo('<div class="container-fluid">');

$OUTPUT->flashMessages();

$OUTPUT->pageTitle("Results <small>by Question</small>", true);

?>
    <section id="questionResponses">
        <div class="list-group">
            <?php
            $numPreResponses = 0;
            $preResponses = $PP_DAO->getPreResponses($_SESSION["main_id"]);
            if ($preResponses) {
                $numPreResponses = count($preResponses);
            }
            ?>
            <div class="list-group-item response-list-group-item">
                <div class="row">
                    <div class="col-sm-3 header-col">
                        <a href="#responsesPre" class="h4 response-collapse-link" data-toggle="collapse">
                            Pre-Question
                            <span class="fa fa-chevron-down rotate" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="col-sm-offset-1 col-sm-8 header-col">
                        <div class="flx-cntnr flx-row flx-nowrap flx-start">
                            <span class="flx-grow-all"><?=$mainInfo["pre_question"]?></span>
                            <span class="badge response-badge"><?=$numPreResponses?></span>
                        </div>
                    </div>
                    <div id="responsesPre" class="col-xs-12 results-collapse collapse">
                        <?php
                        // Sort by modified date with most recent at the top
                        foreach ($preResponses as $response) {
                            if (!$PP_DAO->isUserInstructor($CONTEXT->id, $response["user_id"])) {
                                $responseDate = new DateTime($response["pre_modified"]);
                                $formattedResponseDate = $responseDate->format("m/d/y")." | ".$responseDate->format("h:i A");
                                ?>
                                <div class="row response-row">
                                    <div class="col-sm-3">
                                        <h5><?=$PP_DAO->findDisplayName($response["user_id"])?></h5>
                                        <p><?=$formattedResponseDate?></p>
                                    </div>
                                    <div class="col-sm-offset-1 col-sm-8">
                                        <p class="response-text"><?=$response["pre_answer"]?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            $numPostResponses = 0;
            $postResponses = $PP_DAO->getPostResponses($_SESSION["main_id"]);
            if ($postResponses) {
                $numPostResponses = count($postResponses);
            }
            ?>
            <div class="list-group-item response-list-group-item">
                <div class="row">
                    <div class="col-sm-3 header-col">
                        <a href="#responsesPost" class="h4 response-collapse-link" data-toggle="collapse">
                            Post-Question
                            <span class="fa fa-chevron-down rotate" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="col-sm-offset-1 col-sm-8 header-col">
                        <div class="flx-cntnr flx-row flx-nowrap flx-start">
                            <span class="flx-grow-all"><?=$mainInfo["post_question"]?></span>
                            <span class="badge response-badge"><?=$numPostResponses?></span>
                        </div>
                    </div>
                    <div id="responsesPost" class="col-xs-12 results-collapse collapse">
                        <?php
                        // Sort by modified date with most recent at the top
                        foreach ($postResponses as $response) {
                            if (!$PP_DAO->isUserInstructor($CONTEXT->id, $response["user_id"])) {
                                $responseDate = new DateTime($response["post_modified"]);
                                $formattedResponseDate = $responseDate->format("m/d/y")." | ".$responseDate->format("h:i A");
                                ?>
                                <div class="row response-row">
                                    <div class="col-sm-3">
                                        <h5><?=$PP_DAO->findDisplayName($response["user_id"])?></h5>
                                        <p><?=$formattedResponseDate?></p>
                                    </div>
                                    <div class="col-sm-offset-1 col-sm-8">
                                        <p class="response-text"><?=$response["post_answer"]?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            if ($mainInfo["wrap_question"] && trim($mainInfo["wrap_question"]) !== '') {
                $numWrapResponses = 0;
                $wrapResponses = $PP_DAO->getWrapResponses($_SESSION["main_id"]);
                if ($wrapResponses) {
                    $numWrapResponses = count($wrapResponses);
                }
                ?>
                <div class="list-group-item response-list-group-item">
                    <div class="row">
                        <div class="col-sm-3 header-col">
                            <a href="#responsesWrap" class="h4 response-collapse-link" data-toggle="collapse">
                                Wrap-Up Question
                                <span class="fa fa-chevron-down rotate" aria-hidden="true"></span>
                            </a>
                        </div>
                        <div class="col-sm-offset-1 col-sm-8 header-col">
                            <div class="flx-cntnr flx-row flx-nowrap flx-start">
                                <span class="flx-grow-all"><?=$mainInfo["wrap_question"]?></span>
                                <span class="badge response-badge"><?=$numWrapResponses?></span>
                            </div>
                        </div>
                        <div id="responsesWrap" class="col-xs-12 results-collapse collapse">
                            <?php
                            // Sort by modified date with most recent at the top
                            foreach ($wrapResponses as $response) {
                                if (!$PP_DAO->isUserInstructor($CONTEXT->id, $response["user_id"])) {
                                    $responseDate = new DateTime($response["wrap_modified"]);
                                    $formattedResponseDate = $responseDate->format("m/d/y")." | ".$responseDate->format("h:i A");
                                    ?>
                                    <div class="row response-row">
                                        <div class="col-sm-3">
                                            <h5><?=$PP_DAO->findDisplayName($response["user_id"])?></h5>
                                            <p><?=$formattedResponseDate?></p>
                                        </div>
                                        <div class="col-sm-offset-1 col-sm-8">
                                            <p class="response-text"><?=$response["wrap_answer"]?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>

<?php

include("help.php");

$OUTPUT->footerStart();

include("tool-footer.html");

?>
<script type="text/javascript">
    $(document).ready(function(){
        PrePostJS.initResultsPage();
    });
</script>
<?php

$OUTPUT->footerEnd();

function response_date_compare($response1, $response2) {
    $time1 = strtotime($response1['modified']);
    $time2 = strtotime($response2['modified']);
    // Most recent at top
    return $time2 - $time1;
}