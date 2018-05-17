/*Main Javascript File*/
var PrePostJS = (function () {
    var prePostJS = {};

    prePostJS.deleteQuestionConfirm = function () {
        return confirm("Are you sure you want to delete this question and all associated answers? This cannot be undone.");
    };

    return prePostJS;
})();