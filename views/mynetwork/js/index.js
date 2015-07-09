$(document).ready(function() {

//    USER IMAGE FUNCTION DOWNLINE LIST

    $(".userImage").click(function() {
        return false;
    });

    $("#downlineList").on("mouseover", ".userImage", function() {
        var userImage = $(this).attr('data-image');
        $(this).append("<div id='userImage'><img src='" + userImage + "' class='img-thumbnail' width='50px' height='50px' /></div>");
    });

    $("#downlineList").on("mouseleave", ".userImage", function() {
        var userImage = $(this).attr('data-image');
        $("#userImage").remove();
    });

    $("#downlineList").on("click", ".userImage", function() {
        return false;
    });

//    DOWNLINE LIST
    downlineList();

    $("#btnSearch").bind("click", function() {

        var s = $("#s").val();

        if (s !== "") {
            var link = $("#s").attr("data-url");
            window.location = link + s;
        }

        return false;
    });

});

function downlineList() {
    var url = $("#downlineList").attr("data-url");
    var s = $("#s").val();
    var p = $("#p").val();

    var data = {
        's': s,
        'p': p
    };

    $.get(url, data, function(o) {
        $("#downlineList").html(o);
        $("#searchDownline").removeClass('hidden');
    }, 'json');
}