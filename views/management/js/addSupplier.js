$(document).ready(function() {

    $("#frmAddSupplier").submit(function() {
        loading(true);
        var url = $(this).attr("action");
        var data = $(this).serialize();
        
//        console.log(data);

        $.post(url, data, function(o) {
            console.log(o);
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {
                loading(false);
                window.location = o.msg;
            }
        }, 'json');

        return false;
    });

    $("#frmAddSupplier").on("change", "#agent_id", function() {
        
        var element = $(this);
        
        if (element.val() != "") {
            $("#sect2").removeClass("hidden");
        } else {
            $("#sect2").addClass("hidden");
        }
    });
    
    $("#frmAddSupplier").on("change", "#comp_state", function() {
        
        var s = $(this).val();
        var d = $("#comp_state option[value='" + s + "']").text();

        if (s == "") {
            $("#state_other").removeAttr("placeholder");
            $("#state_other").attr("readonly", "readonly");
            $("#state_other").val("Select state.");
        } else if (s == "oth") {
            $("#state_other").removeAttr("readonly");
            $("#state_other").attr("placeholder", "Enter state for this company.");
            $("#state_other").val("");
        } else {
            $("#state_other").attr("readonly", "readonly");
            $("#state_other").val(d);
        }
    });

});

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Submit!");
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
