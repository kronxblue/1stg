$(document).ready(function () {

//    COMMISSION LIST

    commissionList();

    $(document).on("change", "#ftype", function () {
        var t = $(this).val();
        var m = $("#fmonth").val();
        filter(t, m);
    });

    $(document).on("change", "#fmonth", function () {
        var m = $(this).val();
        var t = $("#ftype").val();
        filter(t, m);
    });

    $("#agentCommission").on('keyup', '#agent_id', function () {

        var url = $(this).attr("data-url");
        var agent_id = $(this).val();

        $("#agent_id").attr("data-verify", "0");

        if (agent_id != "") {

            showAgentList(true);
            var data = {
                "agent_id": agent_id
            };

            $(".agentList").html("<div class='text-center agentID col-xs-12'><i class='fa fa-spinner fa-spin fa-fw fa-2x'></i></div>");

            $.get(url, data, function (o) {
                $(".agentList").html(o);
            }, 'json');
        } else {
            showAgentList(false);
        }

    });

    $("#agentCommission").on('focusout', '#agent_id', function () {

        var verify = $(this).attr("data-verify");

        if (verify == 0) {
            $(this).val("");
        }

        window.setTimeout(function () {
            showAgentList(false);
        }, 200);

    }).on('click', ".agentID", function () {

        var agent_id = $(this).attr("href");

        $("#agent_id").val(agent_id);
        $("#agent_id").attr("data-verify", "1");
        
        var url = $("#agent_id").attr("redirect-url");
        
        window.location = url + "?agent_id=" + agent_id;
        return false;
    });

});
function commissionList() {
    var url = $("#commissionsList").attr("data-url");
    var agent_id = $("#agent_id").val();
    var t = $("#ftype").val();
    var m = $("#fmonth").val();
    var p = $("#p").val();

    var data = {
        'agent_id': agent_id,
        'ftype': t,
        'fmonth': m,
        'p': p
    };

    $.get(url, data, function (o) {
        $("#commissionsList").html(o);
    }, 'json');
}

function filter(type, month) {
    var url = $("#url").val();
    window.location = url + "&type=" + type + "&month=" + month;
}

function showAgentList(cond) {
    if (cond == true) {
        $(".agentList").removeClass("hidden");
    } else {
        $(".agentList").addClass("hidden");
        $(".agentList").html("");
    }
}
