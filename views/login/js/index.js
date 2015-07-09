$(document).ready(function() {
    $('#frm_login').submit(function() {

        alert_run("info", "Authentication loading. Please wait...");

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

    $('.btn-forgot-pass').click(function() {

//        alert_run("info", "Authentication loading. Please wait...");

        var url = $(this).attr('href');
        var emailPrompt = prompt("Enter your email address :");
        var data = "email=" + emailPrompt;

        if (emailPrompt != null) {
            $.post(url, data, function(o) {
                if (o.r == 'false') {
                    alert_run(false, o.msg);
                } else {
                    alert_run(true, o.msg);
//                window.location = o.msg;
                }
            }, 'json');
        }




        return false;
    });
});

function alert_run(cond, msg) {
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

