$(document).ready(function() {

    $('#chkusername').click(function() {


        var username = $('#username').val();

        if (username != "") {

            $('#chkusername').html('Checking...');
            var url = $(this).attr('data-url');
            var datavalue = $('#username').val();
            var data = {'username': datavalue};
            $.post(url, data, function(o) {

                if (o == 'min_error') {
                    username_feedbk(true);
                    alert('Username too short. (Min. 3 character.)');
                } else {
                    username_feedbk(o);
                }

            }, 'json');

        }

    });

    $("#username").bind("change paste keydown", function(event) {
        if (event.keyCode == 32) {
            event.preventDefault();
        } else {
            username_feedbk('reset');
        }
    });

    $("#dob_m").change(function() {
        dobChk();
    });
    $("#dob_d").change(function() {
        dobChk();
    });
    $("#dob_y").change(function() {
        dobChk();
    });

    $('#frm_join').submit(function() {
        
        loading(true);

        var dob_m = $('#dob_m').val();
        var dob_d = $('#dob_d').val();
        var dob_y = $('#dob_y').val();

        var chkUsername = $("#chkusername").attr('data-check');

        var url = $(this).attr('action') + 'join/exec';
        var data = $(this).serialize() + '&chkusername=' + chkUsername;

        $.post(url, data, function(o) {
            console.log(o);
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });
});

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Create my 1STG account!");
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

function username_feedbk(cond) {

    if (cond == true) {
        $('#chkusername').attr('data-check', '-1');
        $('#chkusername').removeClass('btn-info');
        $('#chkusername').removeClass('btn-success');
        $('#chkusername').addClass('btn-danger');
        $('#chkusername').html("Not available");
        $('#username-parent').removeClass('has-success');
        $('#username-parent').addClass('has-error');
        $('#username').focus();
    } else if (cond == false) {
        $('#chkusername').attr('data-check', '1');
        $('#chkusername').removeClass('btn-info');
        $('#chkusername').removeClass('btn-danger');
        $('#chkusername').addClass('btn-success');
        $('#chkusername').html("Available");
        $('#username-parent').removeClass('has-error');
        $('#username-parent').addClass('has-success');
        $('#username').focus();
    } else {
        $('#chkusername').attr('data-check', '0');
        $('#chkusername').addClass('btn-info');
        $('#chkusername').removeClass('btn-danger');
        $('#chkusername').removeClass('btn-success');
        $('#chkusername').html("Check availability");
        $('#username-parent').removeClass('has-error');
        $('#username-parent').removeClass('has-success');
    }

}

function dobChk() {
    var month = $("#dob_m").val();
    var day = $("#dob_d").val();
    var year = $("#dob_y").val();

    if (month == "-1" || day == "-1" || year == "-1") {
        $("#dob").val('');
    } else {
        var dob = year + '-' + num_pad(month, 2) + '-' + num_pad(day, 2);
        $("#dob").val(dob);
    }
}

