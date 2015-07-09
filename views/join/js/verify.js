$(document).ready(function() {

    setTimeout(function() {
        verify_check();
    }, 3000);


});

function verify_check() {
    var a = $("#a").val();
    var s = $("#s").val();

    var url = BASE_PATH + 'join/verify_check';
    var data = {
        "code": a,
        "salt": s
    };

    $.post(url, data, function(o) {
        if (o) {
            window.location = BASE_PATH + "join/verify_success?u=" + s;
        } else {
            window.location = BASE_PATH + "join/verify_failed";
        }

    }, 'json');
}