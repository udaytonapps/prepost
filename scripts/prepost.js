var PrePostJS = (function () {
    var prePostJS = {};

    prePostJS.initResultsPage = function () {
        $('.results-collapse.collapse').on('show.bs.collapse', function(){
            var rowDiv = $(this).parent();
            rowDiv.find(".fa.rotate").addClass("open");
            rowDiv.parent().addClass("selected-row");
        }).on('hide.bs.collapse', function(){
            var rowDiv = $(this).parent();
            rowDiv.find(".fa.rotate").removeClass("open");
            rowDiv.parent().removeClass("selected-row");
        });
    };

    prePostJS.editTitleText = function() {
        $("#toolTitle").hide();
        var titleForm = $("#toolTitleForm");
        titleForm.show();
        titleForm.find("#toolTitleInput").focus()
            .off("keypress").on("keypress", function(e) {
            if(e.which === 13) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: titleForm.prop("action"),
                    data: titleForm.serialize(),
                    success: function(data) {
                        $(".title-text-span").text($("#toolTitleInput").val());
                        var titleText = $("#toolTitle");
                        titleText.show();
                        titleForm.hide();
                        $("#toolTitleCancelLink").hide();
                        $("#toolTitleSaveLink").hide();
                        $("#flashmessages").html(data.flashmessage);
                        _setupAlertHide();
                    }
                });
            }
        });
        $("#toolTitleSaveLink").show()
            .off("click").on("click", function(e) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: titleForm.prop("action"),
                data: titleForm.serialize(),
                success: function(data) {
                    $(".title-text-span").text($("#toolTitleInput").val());
                    var titleText = $("#toolTitle");
                    titleText.show();
                    titleForm.hide();
                    $("#toolTitleCancelLink").hide();
                    $("#toolTitleSaveLink").hide();
                    $("#flashmessages").html(data.flashmessage);
                    _setupAlertHide();
                }
            });
        });
        $("#toolTitleCancelLink").show()
            .off("click").on("click", function(e) {
            var titleText = $("#toolTitle");
            titleText.show();
            titleForm.hide();
            $("#toolTitleInput").val($(".title-text-span").text());
            $("#toolTitleCancelLink").hide();
            $("#toolTitleSaveLink").hide();
        });
    };

    prePostJS.editPreQuestionText = function() {
        let questionText =$("#questionTextPre");
        questionText.hide();
        $("#preQuestionEditAction").hide();

        let theForm = $("#preQuestionTextForm");

        theForm.show();
        theForm.find('#preQuestionTextInput').focus()
            .off("keypress").on("keypress", function(e) {
            if(e.which === 13) {
                e.preventDefault();
                if ($('#preQuestionTextInput').val().trim() === '') {
                    alert("Cannot save blank pre-question.");
                } else {
                    // Still has text in question. Save it.
                    $.ajax({
                        type: "POST",
                        url: theForm.prop("action"),
                        data: theForm.serialize(),
                        success: function(data) {
                            questionText.text($('#preQuestionTextInput').val());
                            questionText.show();
                            $("#preQuestionEditAction").show();
                            $("#preQuestionSaveAction").hide();
                            $("#preQuestionCancelAction").hide();
                            theForm.hide();
                            $("#flashmessages").html(data.flashmessage);
                            _setupAlertHide();
                        }
                    });
                }
            }
        });
        $("#preQuestionSaveAction").show()
            .off("click").on("click", function(e) {
            if ($('#preQuestionTextInput').val().trim() === '') {
                alert("Cannot save blank pre-question.");
            } else {
                // Still has text in question. Save it.
                $.ajax({
                    type: "POST",
                    url: theForm.prop("action"),
                    data: theForm.serialize(),
                    success: function(data) {
                        questionText.text($('#preQuestionTextInput').val());
                        questionText.show();
                        $("#preQuestionEditAction").show();
                        $("#preQuestionSaveAction").hide();
                        $("#preQuestionCancelAction").hide();
                        theForm.hide();
                        $("#flashmessages").html(data.flashmessage);
                        _setupAlertHide();
                    }
                });
            }
        });

        $("#preQuestionCancelAction").show()
            .off("click").on("click", function(e) {
            let theText = $("#questionTextPre");
            theText.show();
            theForm.hide();
            $("#preQuestionTextInput").val(theText.text());
            $("#preQuestionEditAction").show();
            $("#preQuestionSaveAction").hide();
            $("#preQuestionCancelAction").hide();
        });
    };

    prePostJS.editPostQuestionText = function() {
        let questionText =$("#questionTextPost");
        questionText.hide();
        $("#postQuestionEditAction").hide();

        let theForm = $("#postQuestionTextForm");

        theForm.show();
        theForm.find('#postQuestionTextInput').focus()
            .off("keypress").on("keypress", function(e) {
            if(e.which === 13) {
                e.preventDefault();
                if ($('#postQuestionTextInput').val().trim() === '') {
                    alert("Cannot save blank post-question.");
                } else {
                    // Still has text in question. Save it.
                    $.ajax({
                        type: "POST",
                        url: theForm.prop("action"),
                        data: theForm.serialize(),
                        success: function(data) {
                            questionText.text($('#postQuestionTextInput').val());
                            questionText.show();
                            $("#postQuestionEditAction").show();
                            $("#postQuestionSaveAction").hide();
                            $("#postQuestionCancelAction").hide();
                            theForm.hide();
                            $("#flashmessages").html(data.flashmessage);
                            _setupAlertHide();
                        }
                    });
                }
            }
        });
        $("#postQuestionSaveAction").show()
            .off("click").on("click", function(e) {
            if ($('#postQuestionTextInput').val().trim() === '') {
                alert("Cannot save blank post-question.");
            } else {
                // Still has text in question. Save it.
                $.ajax({
                    type: "POST",
                    url: theForm.prop("action"),
                    data: theForm.serialize(),
                    success: function(data) {
                        questionText.text($('#postQuestionTextInput').val());
                        questionText.show();
                        $("#postQuestionEditAction").show();
                        $("#postQuestionSaveAction").hide();
                        $("#postQuestionCancelAction").hide();
                        theForm.hide();
                        $("#flashmessages").html(data.flashmessage);
                        _setupAlertHide();
                    }
                });
            }
        });

        $("#postQuestionCancelAction").show()
            .off("click").on("click", function(e) {
            let theText = $("#questionTextPost");
            theText.show();
            theForm.hide();
            $("#postQuestionTextInput").val(theText.text());
            $("#postQuestionEditAction").show();
            $("#postQuestionSaveAction").hide();
            $("#postQuestionCancelAction").hide();
        });
    };

    prePostJS.editWaitTime = function() {
        let waitText =$("#waitTimeText");
        waitText.hide();
        $("#waitTimeEditAction").hide();

        let theForm = $("#waitTimeForm");

        theForm.show();
        theForm.find('#waitTime').focus()
            .off("keypress").on("keypress", function(e) {
            if(e.which === 13) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: theForm.prop("action"),
                    data: theForm.serialize(),
                    success: function(data) {
                        if (data.waitseconds) {
                            waitText.text(_getWaitTimeDisplay(data.waitseconds));
                            waitText.show();
                            $("#waitTimeEditAction").show();
                            $("#waitTimeSaveAction").hide();
                            $("#waitTimeCancelAction").hide();
                            theForm.hide();
                        }

                        $("#flashmessages").html(data.flashmessage);
                        _setupAlertHide();
                    }
                });
            }
        });
        $("#waitTimeSaveAction").show()
            .off("click").on("click", function(e) {
                $.ajax({
                    type: "POST",
                    url: theForm.prop("action"),
                    data: theForm.serialize(),
                    success: function(data) {
                        if (data.waitseconds) {
                            waitText.text(_getWaitTimeDisplay(data.waitseconds));
                            waitText.show();
                            $("#waitTimeEditAction").show();
                            $("#waitTimeSaveAction").hide();
                            $("#waitTimeCancelAction").hide();
                            theForm.hide();
                        }

                        $("#flashmessages").html(data.flashmessage);
                        _setupAlertHide();
                    }
                });
        });

        $("#waitTimeCancelAction").show()
            .off("click").on("click", function(e) {
                let waitText =$("#waitTimeText");
                waitText.show();
                theForm.hide();
                //TODO: Set the form back to the last saved wait time.
                $("#waitTimeEditAction").show();
                $("#waitTimeSaveAction").hide();
                $("#waitTimeCancelAction").hide();
        });
    };

    prePostJS.editWrapQuestionText = function() {
        let questionText =$("#questionTextWrap");
        questionText.hide();
        $("#wrapQuestionEditAction").hide();

        let theForm = $("#wrapQuestionTextForm");

        theForm.show();
        theForm.find('#wrapQuestionTextInput').focus()
            .off("keypress").on("keypress", function(e) {
            if(e.which === 13) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: theForm.prop("action"),
                    data: theForm.serialize(),
                    success: function(data) {
                        questionText.text($('#wrapQuestionTextInput').val());
                        questionText.show();
                        $("#wrapQuestionEditAction").show();
                        $("#wrapQuestionSaveAction").hide();
                        $("#wrapQuestionCancelAction").hide();
                        theForm.hide();
                        $("#flashmessages").html(data.flashmessage);
                        _setupAlertHide();
                    }
                });

            }
        });
        $("#wrapQuestionSaveAction").show()
            .off("click").on("click", function(e) {
            $.ajax({
                type: "POST",
                url: theForm.prop("action"),
                data: theForm.serialize(),
                success: function(data) {
                    questionText.text($('#wrapQuestionTextInput').val());
                    questionText.show();
                    $("#wrapQuestionEditAction").show();
                    $("#wrapQuestionSaveAction").hide();
                    $("#wrapQuestionCancelAction").hide();
                    theForm.hide();
                    $("#flashmessages").html(data.flashmessage);
                    _setupAlertHide();
                }
            });

        });

        $("#wrapQuestionCancelAction").show()
            .off("click").on("click", function(e) {
            let theText = $("#questionTextWrap");
            theText.show();
            theForm.hide();
            $("#wrapQuestionTextInput").val(theText.text());
            $("#wrapQuestionEditAction").show();
            $("#wrapQuestionSaveAction").hide();
            $("#wrapQuestionCancelAction").hide();
        });
    };

    let _setupAlertHide = function () {
        // On load hide any alerts after 3 seconds
        setTimeout(function () {
            $(".alert-banner").slideUp();
        }, 3000);
    };

    let _getWaitTimeDisplay = function(seconds) {
        let days = Math.floor(seconds / (3600*24));
        seconds  -= days*3600*24;
        let hrs   = Math.floor(seconds / 3600);
        seconds  -= hrs*3600;
        let mnts = Math.floor(seconds / 60);
        seconds  -= mnts*60;
        return days+" days, "+hrs+" hours, "+mnts+" minutes, "+seconds+" seconds";
    };

    return prePostJS;
})();