<?php
?>
<div id="helpModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times" aria-hidden="true"></span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Pre/Post Reflection Help</h4>
            </div>
            <div class="modal-body">
                <?php
                switch(basename($_SERVER['PHP_SELF'])) {
                    case 'instructor-home.php':
                        ?>
                        <h4>General Help</H4>
                        <?php
                        break;
                    case 'student-home.php':
                        if ($USER->instructor) {
                            ?>
                            <h4>Student View</h4>

                            <?php
                        } else {
                            ?>
                            <h4>What do I do?</h4>

                            <?php
                        }
                        break;
                    default:
                        ?>
                        <em>No help for this page.</em>
                    <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
