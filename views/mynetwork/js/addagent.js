$(document).ready(function () {

    $("#frmAddAgent").on('click', "#btn_cancel", function () {
        var url = $(this).attr("data-url");

        window.location = url;
    });


    $("#frmAddAgent").on('change', "#country", function () {
        var value = $(this).val();

        if (value === 'MY') {
            $("#states").removeClass('hidden');
        } else {
            $("#states").addClass('hidden');
        }
    });

    $("#frmAddAgent").on('keyup', '#sponsor_id', function () {

        var url = $(this).attr("data-url");
        var agent_id = $(this).val();

        $("#sponsor_id").attr("data-verify", "0");

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

    });

    $("#frmAddAgent").on('focusout', '#sponsor_id', function () {

        var verify = $(this).attr("data-verify");

        if (verify == 0) {
            $(this).val("");
        }

        window.setTimeout(function () {
            showAgentList(false);
        }, 200);

    }).on('click', ".agentID", function () {

        var agent_id = $(this).attr("href");

        $("#sponsor_id").val(agent_id);
        $("#sponsor_id").attr("data-verify", "1");
        return false;
    });

    $("#dob_m").change(function () {
        dobChk();
    });
    $("#dob_d").change(function () {
        dobChk();
    });
    $("#dob_y").change(function () {
        dobChk();
    });

    $('#chkusername').click(function () {


        var username = $('#username').val();

        if (username != "") {

            $('#chkusername').html('Checking...');
            var url = $(this).attr('data-url');
            var datavalue = $('#username').val();
            var data = {'username': datavalue};
            $.post(url, data, function (o) {

                if (o == 'min_error') {
                    username_feedbk(true);
                    alert('Username too short. (Min. 3 character.)');
                } else {
                    username_feedbk(o);
                }

            }, 'json');

        }

    });

    $("#username").bind("change paste keydown", function (event) {
        if (event.keyCode == 32) {
            event.preventDefault();
        } else {
            username_feedbk('reset');
        }
    });

    $("#frmAddAgent").submit(function () {

        loading(true);
        
        var dob_m = $('#dob_m').val();
        var dob_d = $('#dob_d').val();
        var dob_y = $('#dob_y').val();

        var chkUsername = $("#chkusername").attr('data-check');

        var url = $(this).attr("action");
        var data = $(this).serialize() + '&chkusername=' + chkUsername;

//console.log(data);

        $.post(url, data, function (o) {
//            console.log(o);
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                window.location = o.msg;
            }
        }, 'json');

        return false;
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

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Register Now");
        $("#btn_submit").removeAttr('disabled');
    }
}
