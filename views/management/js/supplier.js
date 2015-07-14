$(document).ready(function() {

    supplierList();
    
    $("#manage_supplier").on("click","#btnSearch", function(){
        var url = $(this).attr("data-url");
        var data = $("#s").val();
        window.location = url + data;
    });

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
