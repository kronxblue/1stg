$(document).ready(function() {

    $("#frmWithdrawal").submit(function() {
        loading(true);

        var url = $(this).attr("action");
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

    $("#filterMonth").on("change", "#f", function() {
        getWithdrawalStatement();
    });

    $("#withdrawalHistory").on("click", ".btn-cancel-withdraw", function() {
        var url = $(this).attr("href");
        var id = $(this).attr("data-id");
        var no = $(this).attr("data-no");
        var data = {
            "id": id
        };

        var conf_delete = confirm("Are you sure want to cancel this (#" + no + ") withdrawal request?");

        if (conf_delete == true) {
            $.post(url, data, function(o) {
                if (o.r == 'false') {
                alert(o.msg);
            } else {
                alert(o.msg);
                getWithdrawalStatement();
            }
            }, 'json');
        }

        return false;

    });

    getWithdrawalStatement();

});

function getWithdrawalStatement() {
    var url = $("#withdrawalHistory").attr("data-url");
    var p = $("#p").val();
    var f = $("#f").val();

    var data = {
        'p': p,
        'f': f
    };

    $.get(url, data, function(o) {
        $("#withdrawalHistory").html(o);
    }, 'json');
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