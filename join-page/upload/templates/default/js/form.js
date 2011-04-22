/* $Id */
$(document).ready(function() {
    var defaultValue = $("#email").val();
    var formAction = $("#subscribe").attr("action");

    $("#subscribe").attr("action", "");

    $("#email").focus(function() {
        if ($(this).val() == defaultValue) {
            $(this).val("");
        }
    });

    $("#email").blur(function() {
        if ($(this).val() == "") {
            $(this).val(defaultValue);
        }
    });

    $("#submit").click(function() {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        if ($("#email").val() == defaultValue || !emailReg.test($("#email").val())) {
            return false;
        }
        else {
            $("#subscribe").attr("action", formAction);
            $("#subscribe").submit();
        }
    });
});
