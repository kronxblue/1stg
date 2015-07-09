
$(document).ready(function () {

    $("#tools").on("click", ".download", function () {

        var url = $(this).attr("href");
        var data = {
            "id": $(this).attr("data-id")
        };

        $.post(url, data, function (o) {
            if (o.r == 'false') {
                alert(o.msg);
            } else {
                window.location.href = o.msg;
            }
        }, 'json');

        return false;
    });
    
    $(".toolsDesc").tooltip();

});
