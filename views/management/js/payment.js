$(document).ready(function() {

    waitingList();
    summaryList();

    $("#managePayment").on('click', "#btnSearch", function() {
        var url = $(this).attr("data-url");
        var s = $("#s").val();

        window.location = url + s;
    });

});

function waitingList() {
    var url = $("#waitingPayment").attr("data-url");
    var wp = $("#wp").val();

    var data = {
        'p': wp
    };

    $.get(url, data, function(o) {
        $("#waitingPayment").html(o);
    }, 'json');
}

function summaryList() {
    var url = $("#summaryPayment").attr("data-url");
    var sp = $("#sp").val();
    var s = $("#s").val();

    var data = {
        'p': sp,
        's': s
    };

    $.get(url, data, function(o) {
        $("#summaryPayment").html(o);
    }, 'json');
}