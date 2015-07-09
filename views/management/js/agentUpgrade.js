$(document).ready(function () {

    $("#payment_date").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        clearBtn: true,
        todayBtn: "linked"
    });

    $("#frmAgentUpgrade").on("change", "#acc_type", function () {
        var code = $(this).val();
        getAccDetails(code);
    });

    $("#frmAgentUpgrade").submit(function () {
        loading(true);
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function (o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });
});

function getAccDetails(code) {

    var acc_type = "";

    var url = $("#acc_type").attr("data-url");
    var data = {
        'code': code
    };

    $.post(url, data, function (o) {
        $("#ads_pin_limit").val(o.ads_pin_limit);
        $("#payment_price").val(o.price);

        if (code != "") {
            var agent_id = $("#agent_id").val();

            $("#payment_for").val(agent_id + " - " + o.label + " (RM" + format_number(o.price) + ")");
        } else {
            $("#payment_for").val("");
        }

    }, 'json');


}

function alert_run(cond, msg) {
    loading(false);
    $('#alert-body').html(msg);
    if (cond == false) {
        $('#alert').removeClass('alert-info');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-danger');
    } else if (cond == true) {
        $('#alert').removeClass('alert-info');
        $('#alert').removeClass('alert-danger');
        $('#alert').addClass('alert-success');
    } else {
        $('#alert').removeClass('alert-success');
        $('#alert').removeClass('alert-danger');
        $('#alert').addClass('alert-info');
    }
    $('#alert').slideDown(function () {
        $('.close').click(function () {
            $(this).parent().slideUp();
        });
    });
}

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Submit");
        $("#btn_submit").removeAttr('disabled');
    }
}
