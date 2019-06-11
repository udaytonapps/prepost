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
                        <h4>General Help</h4>
                        <p>Use this page to add a Pre-Question and Post-Question for your students to answer. You may optionally include an amount of time students must wait before responding to the Post-Question and/or a Wrap-Up Question for students to answer at the end.</p>
                        <p>Students will not be able to see their response to the Pre-Question until they've responded to the Post-Question.</p>
                        <h5>Modifying Pre/Post Settings</h5>
                        <p>Once you've submitted the form to set up the Pre/Post Reflection, you may modify the pre-question, post-question, wait time, or wrap-up question by clicking the edit icon next to the item you'd like to modify.</p>
                        <h5>Editing the Title</h5>
                        <p>You can edit the title of this Pre/Post Reflection by clicking the edit icon next to the title at the top of this page.</p>
                        <?php
                        break;
                    case 'results-question.php':
                        ?>
                        <h4>Viewing Results</h4>
                        <p>You are viewing the results by question. Click on a question below to see what students answered for that question.</p>
                        <p>For each question, students are sorted with the most recently modified at the top.</p>
                        <?php
                        break;
                    case 'results-student.php':
                        ?>
                        <h4>Viewing Results</h4>
                        <p>You are viewing the results by student. Click on a student below to see how that student answered each question.</p>
                        <p>Students are sorted with the most recently submitted at the top of the list.</p>
                        <?php
                        break;
                    case 'student-home.php':
                        if ($USER->instructor) {
                            ?>
                            <h4>Student View</h4>
                            <p>You are seeing what a student will see when they access this tool. However, your answers will be cleared once you leave student view.</p>
                            <p>Your answers will not show up in any of the results.</p>
                            <?php
                        } else {
                            ?>
                            <h4>What do I do?</h4>
                            <p>Answer the Pre-Question below. Once you’ve answered the Pre-Question you will be given a Post-Question. There may be a waiting period before you can see and respond to the Post-Question.</p>
                            <p>After your Pre-Question and Post-Question responses have been submitted, there may be a final Wrap-Up Question to respond to.</p>
                            <p><em>Once you submit an answer to a question you can NOT edit your answer.</em></p>
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
