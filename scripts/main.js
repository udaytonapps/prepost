/*Main Javascript File*/
var PrePostJS = (function () {
    var prePostJS = {};

    prePostJS.toggleWrapUp = function () {
        if (document.getElementById('wrapUpRow').hidden) {
            document.getElementById('wrapUpRow').hidden = false;
            document.getElementById('wrapUpRowTitle').hidden = false;
        }
        else {
            document.getElementById('wrapUpRow').hidden = true;
            document.getElementById('wrapUpRowTitle').hidden = true;
        }
        _toggleReviewCard();
    };
    prePostJS.deleteQuestionConfirm = function () {
        return confirm("Are you sure you want to delete this question and all associated answers? This cannot be undone.");
    };

    _toggleReviewCard = function() {
        var sess = $('input#sess').val();
        $.ajax({
            url: "actions/ToggleWrapUp.php?PHPSESSID=" + sess,
            success: function (response) {
            }
        });
    };
    return prePostJS;
})();