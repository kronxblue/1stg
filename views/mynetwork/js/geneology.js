$(document).ready(function() {

    var data_cond = $("#alert").attr("data-cond");

    if (data_cond) {
        $('#alert').slideDown(function() {
            $('.close').click(function() {
                $(this).parent().slideUp();
            });
        });
    }

});

function alert_run(cond, msg) {
//    loading(false);
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