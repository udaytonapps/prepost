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
                        <p>Once you've set up the Pre/Post Reflection, click on the pencil icon next to any item you'd like to modify. When you are finished editing the item, click on the save icon or press the 'Enter' key to save your changes.</p>
                        <h5>Editing the Title</h5>
                        <p>You can edit the title of this Pre/Post Reflection by clicking the pencil icon next to the title at the top of this page.</p>
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
                            <p>Answer the Pre-Question by typing in box and pressing the Submit button. Once your response has been submitted to the Pre-Question, you may see that you have a waiting period. When the waiting period has expired, return to or refresh the page to answer the Post-Question.</p>
                            <p>Once you have submitted your answer to the Post-Question, you will be able to see and review your answers to both questions. There may be a final Wrap-Up Question to which you should respond.</p>
                            <p><em>Once you submit an answer to a question, you cannot edit your answer.</em></p>
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
