$(document).ready(function() {

    $("#account_setup li a").click(function() {
        return false;
    });

//    PASSWORD
    $("#frm_password").submit(function() {
        loading(true);

        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');
        return false;
    });

//    DETAILS
    $("#frm_details").submit(function() {

        loading(true);

        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');
        return false;
    });

    $("#country").bind('change', function() {
        var value = $(this).val();

        if (value === 'MY') {
            $("#states").removeClass('hidden');
        } else {
            $("#states").addClass('hidden');
        }
    });

//    BANK
    $("#frm_bank").submit(function() {
        loading(true);
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');
        return false;
    });

    $("#btn_skip_bank").click(function() {
        var url = $(this).attr("data-url");
        var data = $("#frm_bank").serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });

//    BENEFICIARY
    $("#frm_beneficiary").submit(function() {
        loading(true);
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });

    $("#btn_skip_beneficiary").click(function() {

        var url = $(this).attr("data-url");
        var data = $("#frm_beneficiary").serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });

//    PAYMENT

    $("#payment_d").change(function() {
        dateChk();
    });
    $("#payment_m").change(function() {
        dateChk();
    });
    $("#payment_y").change(function() {
        dateChk();
    });
    $("#payment_h").change(function() {
        timeChk();
    });
    $("#payment_mn").change(function() {
        timeChk();
    });

    $("#frm_payment").submit(function() {
        loading(true);
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });
    

    $("#listPin").click(function() {
        var url = $(this).attr("data-url");
        var tgtWin = window.open(url, "_blank", "height=500, width=800, toolbar=no");

    });

});

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
    $('#alert').slideDown(function() {
        $('.close').click(function() {
            $(this).parent().slideUp();
        });
    });
}

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Save");
        $("#btn_submit").removeAttr('disabled');
    }
}

function dateChk() {
    var month = $("#payment_m").val();
    var day = $("#payment_d").val();
    var year = $("#payment_y").val();

    if (month == "-1" || day == "-1" || year == "-1") {
        $("#payment_date").val('');
    } else {
        var payment_date = year + '-' + num_pad(month, 2) + '-' + num_pad(day, 2);
        $("#payment_date").val(payment_date);
    }
}

function timeChk() {
    var hour = $("#payment_h").val();
    var minute = $("#payment_mn").val();
    var second = '00';

    if (hour == "-1" || minute == "-1") {
        $("#payment_time").val('');
    } else {
        var payment_time = hour + ':' + num_pad(minute, 2) + ':' + num_pad(second, 2);
        $("#payment_time").val(payment_time);
    }
}
