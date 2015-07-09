$(document).ready(function() {

    $("#frmRequestActivation").submit(function() {
        var url = $(this).attr("action");
        var data = $(this).serialize();
        var email = $("#email").val();

        loading(true);

        if (email == "") {
            alert_run(false, "<b>Email</b> cannot be empty.");
        } else {

            $.post(url, data, function(o) {
                if (o) {
                    alert_run(o, "<b>Successful!</b> Your account activation link has been send to " + email + ". Redirecting, please wait...");
                    setTimeout(function() {
                        window.location = BASE_PATH + "login";
                    }, 2000);
                } else {
                    alert_run(o, "<b>Failed!</b> Can't email your activation link, please make sure you have register your 1STG account with this email. Or try to refresh your browser and try again.");
                }
            }, 'json');
        }


        return false;
    });
});

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Resend Activation Link");
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