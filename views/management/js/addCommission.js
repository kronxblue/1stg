$(document).ready(function () {

    $("#frmAddCommission").on("change", "#commission_type", function () {
        var url = $(this).attr("data-url");
        var type = $(this).val();

        var data = {
            "type": type
        };

        $.post(url, data, function (o) {

            if (o == false) {
                $("#from").attr("readonly", true);
                $("#from").val("");
                $("#subject").val("");
                $("#from").attr("placeholder", "");
                $("#from").attr("data-type", 0);

            } else {
                $("#from").attr("readonly", false);
                $("#from").attr("placeholder", o.placeholder);
                $("#from").attr("data-type", o.dataType);
                $("#from").attr("data-verify", "0");
                $("#from").val("");
                $("#subject").val(o.subject);
                $(".subject").html(o.subject);
            }

            console.log(o);
        }, 'json');

    });



    $("#frmAddCommission").on("keyup", "#from", function () {

        var dataType = $(this).attr("data-type");

        if (dataType == 1) {
            $(this).attr("data-verify", "0");
            var url = $(this).attr("data-url");
            var agent_id = $(this).val();

            $("#from").attr("data-verify", "0");

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
        } else {
            $(this).attr("data-verify", "1");
        }

    });

    $("#frmAddCommission").on("focusout", "#from", function () {

        var verify = $(this).attr("data-verify");

        if (verify == 0) {
            $(this).val("");
            $(".subject").html($("#subject").val());
        } else {
            $(".subject").html($("#subject").val() + " <b>" + $("#from").val() + "</b>");
        }

        window.setTimeout(function () {
            showAgentList(false);
        }, 200);

    }).on('click', ".agentID", function () {

        var agent_id = $(this).attr("href");
        var username = $(this).attr("username");
        var accType = $(this).attr("acc-type");
        var subject = $("#subject").val();

        $(".subject").html(subject + " <b>" + username + " - " + accType + "</b>");
        $("#from").val(agent_id);
        $("#from").attr("username", username);
        $("#from").attr("data-verify", "1");

        return false;
    });

    $("#frmAddCommission").on("click", "#btnDate", function () {
        $("#date").datepicker("show");
    });

    $("#frmAddCommission").on("click", "#btnDateRelease", function () {
        $("#dateRelease").datepicker("show");
    });


});

function showAgentList(cond) {
    if (cond == true) {
        $(".agentList").removeClass("hidden");
    } else {
        $(".agentList").addClass("hidden");
        $(".agentList").html("");
    }
}
