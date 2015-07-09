$(document).ready(function () {

    getAgentList();

    $("#frmAgentList").on("keyup", "#s", function (e) {
        $("#p").val("1");
        getAgentList();
    });

    $("#frmAgentList").submit(function () {
        var url = $(this).attr("data-url");
        var s = $("#s").val();
        
        
        window.location = url + "?s=" + s;
        return false;
    });

});
function getAgentList() {
    $("#agentList").html("<div class='col-xs-12 text-center'><i class='fa fa-spinner fa-spin fa-3x'></i><br/><br/><p>Generating agent list. Please wait...</p></div>");
    var url = $("#agentList").attr("data-url");
    var s = $("#s").val();
    var p = $("#p").val();

    var data = {
        's': s,
        'p': p
    };

    $.get(url, data, function (o) {
        $("#agentList").html(o);
    }, 'json');

}
