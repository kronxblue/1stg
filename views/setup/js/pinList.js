$(document).ready(function() {

    var url = $("#pinList").attr("data-url");
    var page = $("#pinList").attr("data-page");
    var filterby = $("#filterby").val();
    var sortby = $("#sortby").val();

    $("#filterby").change(function() {
        filterby = $(this).val();

        page = "1";
        $("#pinList").attr("data-page", page);

        getListPin(url, page, sortby);
    });

    $("#sortby").change(function() {
        sortby = $(this).val();

        page = "1";
        $("#pinList").attr("data-page", page);

        getListPin(url, page, sortby);
    });

    getListPin(url, page, sortby);

    $(".pinList").on("click", ".btnSelect", function() {
        var pin = $(this).attr("data-pin");
        var a = $(window.opener.document).find("#ads_pin");
        a.val(pin);
        window.close();
    });

    $(".pinList").on("click", ".pagination-link", function() {

        page = $(this).attr("data-page");
        $("#pinList").attr("data-page", page);

        getListPin(url, page, sortby);
    });

    $("#frmCheckPin").submit(function() {
        var url = $(this).attr("action");
        var data = $(this).serialize();

        $.post(url, data, function(o) {
            if (o.r == 'false') {
                alert_run(false, o.msg);
            } else {

                $("#pinResult").html(o.msg);
            }
        }, 'json');

        return false;
    });


});

function getListPin(url, page, sort) {
    
    var acc_type = window.opener.document.getElementById("acc_type").value;

    var data = {
        "page": page,
        "sort": sort,
        "acc_type" : acc_type
    };

    $.get(url, data, function(o) {
        $("#pinList").html(o);
    }, 'json');

}

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

function loading(cond) {
    if (cond) {
        $("#btn_submit").html("Loading...");
        $("#btn_submit").attr('disabled', 'disabled');
    } else {
        $("#btn_submit").html("Save");
        $("#btn_submit").removeAttr('disabled');
    }
}
