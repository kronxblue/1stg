$(document).ready(function() {

    $("#frmContact").submit(function() {
        loading(true);
        var url = $(this).attr("action");
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                clearForm("#frmContact");
                alert_run(true, o.msg);
            }
        }, 'json');

        return false;
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
        $("#btn_submit").html("Submit <i class='fa fa-send fa-fw'></i>");
        $("#btn_submit").removeAttr('disabled');
    }
}