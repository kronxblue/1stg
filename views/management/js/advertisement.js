$(document).ready(function () {

    $("#detailsModal").on("show.bs.modal", function (event) {
        var btnDetails = $(event.relatedTarget);


        var url = btnDetails.data("url");
        var data = {
            "ads_id": btnDetails.data("adsid")
        };
        console.log(url);
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
    
    modalObj.parent(".modal-content").children(".modal-header").children("h4").children("#ads_name").html(data.ads_name);
    modalObj.parent(".modal-content").children(".modal-header").children("h4").children("#comp_name").html(data.comp_name);
    
    modalObj.children("div").children("#day_left").html(data.day_left);
    modalObj.children("div").children("#duration").html(data.period);
    modalObj.children("div").children("#payment").html(data.payment);
    modalObj.children("div").children("#commission").html(data.commission);
    modalObj.children("div").children("#link").html(data.link);
    modalObj.children("div").children("#hashtag").html(data.hashtag);
    modalObj.children("div").children("#adsImg").html(data.adsImg);
}
