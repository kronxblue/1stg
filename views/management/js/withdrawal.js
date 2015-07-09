$(document).ready(function() {

    getWithdrawList(0, "waitingReview", "rp");
    getWithdrawList(1, "waitingProcess", "pp");
    getWithdrawList("all", "summaryWithdraw", "sp");

    $("#managePayment").on('click', "#btnSearch", function() {
        var url = $(this).attr("data-url");
        var s = $("#s").val();

        window.location = url + s;
    });

    $("#manageWithdrawal").on('click', "#btn-review-all, #btn_cancel", function() {
        $("#allAction").toggle("blind", 500);

    });
    
    $("#manageWithdrawal").on('click', "#btn-search", function() {
        
        var url = $(this).attr("data-url");
        var s = $("#s").val();
        
        window.location = url + s;

    });

});

function getWithdrawList(status, area_id, pagination_id) {
    var url = $("#" + area_id).attr("data-url");
    var p_id = pagination_id;
    var p = $("#" + pagination_id).val();
    var s = $("#s").val();
    var data = {
        'status': status,
        'p_id': p_id,
        'p': p,
        's': s
    };
    
    

    $.get(url, data, function(o) {
//        alert(o);
        $("#" + area_id).html(o);
    }, 'json');
}
