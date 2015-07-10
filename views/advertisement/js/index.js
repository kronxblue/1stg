$(document).ready(function () {

    $("#detailsModal").on("show.bs.modal", function (event) {
        var btnDetails = $(event.relatedTarget);


        var url = btnDetails.data("url");
        var data = {
            "ads_id": btnDetails.data("adsid")
        };

        $.post(url, data, function (o) {
            var result = JSON.parse(o);
            
            fillDetails(result);
        });


    });

    $("#advertisement").on("click", "#btnSearch", function () {
        var url = $(this).attr("data-url");
        var data = $("#s").val();
        window.location = url + data;
    });

});

function fillDetails(data) {
    var modalObj = $("#modal-body");
    var day_left = modalObj.children("div").children("#day_left").html(data.day_left);
    var day_left = modalObj.children("div").children("#duration").html(data.period);
    var day_left = modalObj.children("div").children("#payment").html(data.payment);
    var day_left = modalObj.children("div").children("#commission").html(data.commission);
    var day_left = modalObj.children("div").children("#link").html(data.link);
    var day_left = modalObj.children("div").children("#hashtag").html(data.hashtag);
    var day_left = modalObj.children("div").children("#adsImg").html(data.adsImg);
}
