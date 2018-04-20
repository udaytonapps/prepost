/*Main Javascript File*/
var PrePostJS = (function () {
    var prePostJS = {};


    prePostJS.toggleWrapUpTextBox = function () {
        if(document.getElementById('prePostWrapUpText').disabled)
        {
            document.getElementById('prePostWrapUpText').disabled=false;
        }
        else {
            document.getElementById('prePostWrapUpText').disabled=true;
        }
    };


    return prePostJS;
})();