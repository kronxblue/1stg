$(document).ready(function() {
    $("#filterMonth").on("change", "#f", function() {
        var url = $(this).attr("data-url");
        var f;
        if ($(this).val() != "") {
            f = "?f=" + $(this).val();
        } else {
            f = "";
        }

        window.location = url + f;
    });

    getCommissionStatement();

});

function getCommissionStatement() {
    var url = $("#resellerCommission").attr("data-url");
    var p = $("#p").val();
    var f = $("#f").val();
    var type = $("#type").val();

    var data = {
        'p': p,
        'f': f,
        'type': type
    };

    $.get(url, data, function(o) {
        $("#resellerCommission").html(o);
    }, 'json');
}

