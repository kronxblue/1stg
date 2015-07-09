$(document).ready(function() {

    $("#resend_details").on('click', function() {

        alert_run("info", "Processing to resend your account details. Please wait...");

        var email = $(this).attr('data-email');

        var url = $(this).attr('href');
        var data = {
            "email": email
        };

        $.post(url, data, function(o) {
            if (o) {
                alert_run(o, "<b>Successful!</b> Your account details has been send to " + email + ".");
            } else {
                alert_run(o, "<b>Failed!</b> Can't email your account details, please refresh the browser and click 'click here to resend your account details' again.");
            }
        }, 'json');
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