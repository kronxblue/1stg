$(document).ready(function () {
    $('.close').click(function () {
        $(this).parent().slideUp();
    });

    $('#supplier').on("click", ".btn-more-desc", function () {

        var currentElement = $(this);

        var url = $(this).attr("href");
        var viewData = $(this).attr("data-view");
        var supplierId = $(this).attr("data-supplier");
        var data = {
            "view": viewData,
            "supplier_id": supplierId
        };

        $.post(url, data, function (o) {
            currentElement.parent('td').children('.desc').html(o);
            if (viewData == 0) {
                currentElement.attr("data-view", 1);
                currentElement.html("<i class='fa fa-angle-up fa-fw'></i>");
            } else {
                currentElement.attr("data-view", 0);
                currentElement.html("<i class='fa fa-angle-down fa-fw'></i>");
            }
        }, 'json');

        return false;
    });
    
    $("#supplier").on("click","#btnSearch", function(){
        var url = $(this).attr("data-url");
        var data = $("#s").val();
        window.location = url + data;
    });

    supplierList();

});

function supplierList() {
    var parentObj = $("#supplierList");

    var url = parentObj.attr("data-url");
    var s = $("#s").val();
    var p = $("#p").val();

    var data = {
        "s": s,
        "p": p
    };

    $.get(url, data, function (o) {
        $("#supplierList").html(o);
    }, 'json');
}
