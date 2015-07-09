$(document).ready(function () {

    $(".have-tooltip").tooltip();

//    COMMISSION LIST

    commissionList();

    $(document).on("change", "#ftype", function () {
        var t = $(this).val();
        var m = $("#fmonth").val();
        filter(t, m);
    });

    $(document).on("change", "#fmonth", function () {
        var m = $(this).val();
        var t = $("#ftype").val();
        filter(t, m);
    });
});

function commissionList() {
    var url = $("#commissionsList").attr("data-url");
    var t = $("#ftype").val();
    var m = $("#fmonth").val();
    var p = $("#p").val();

    var data = {
        'ftype': t,
        'fmonth': m,
        'p': p
    };

    $.get(url, data, function (o) {
        $("#commissionsList").html(o);
    }, 'json');
}

function filter(type, month) {
    var url = $("#url").val();
    window.location = url + "?type=" + type + "&month=" + month;
}
