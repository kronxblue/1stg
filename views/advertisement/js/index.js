$(document).ready(function () {

    $("#advertisement").on("click", ".btn-details-toggle", function () {

        var currentElement = $(this);

        var url = $(this).attr("data-url");
        var viewData = $(this).attr("data-view");
        var adsId = $(this).attr("data-id");
        var data = {
            "view": viewData,
            "ads_id": adsId
        };

        currentElement.parent('td').children('.details-toggle').toggle('blind', 300);

        return false;
    });

    advertisementList();

});

function advertisementList() {
    var parentObj = $("#adsList");

    var url = parentObj.attr("data-url");
    var p = $("#p").val();
    var spec = parentObj.attr("data-spec");
    
    console.log(spec);

    var data = {
        "p": p,
        "spec": spec
    };

    $.get(url, data, function (o) {
//        $("#supplierList").html(o);

//        console.log(o);
        
    }, 'json');
}
