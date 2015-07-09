var timer;
var progressBar;
function loadingPage() {
    x = 0;
    timer = setInterval(function() {
        x = ++x % 4;
        $(".loading-text").html("Loading" + Array(x + 1).join("."));
    }, 500);
}

function stopLoading() {
    clearInterval(timer);
    $("#loading-ov").hide("puff", 1000);
}


function updateVideoSize() {
    var screenW = $(window).width();
    var screenH = $(window).height();

    var screenAR = screenH / screenW;

    if (screenAR > 0.56) {

        $("#bg-video").css('height', '100%');
        $("#bg-video").css('width', 'auto');

        var vidW = $("#bg-video").width();
        var vidH = $("#bg-video").height();

        var vidL = (vidW - screenW) / 2;
        vidL = -vidL;

        $("#bg-video").css('margin-left', vidL);
        $("#bg-video").css('margin-top', 'auto');
        $("#bg-video").css('margin-bottom', 'auto');

    } else if (screenAR < 0.56) {
        $("#bg-video").css({
            'height': 'auto',
            'width': '100%'
        });

        var vidW = $("#bg-video").width();
        var vidH = $("#bg-video").height();

        var vidT = (vidH - screenH) / 2;
        vidT = -vidT;

        $("#bg-video").css('margin-top', vidT);
        $("#bg-video").css('margin-left', 'auto');
        $("#bg-video").css('margin-right', 'auto');
    } else {
        $("#bg-video").css({
            'position': 'absolute',
            'height': 'auto',
            'width': '100%'
        });
    }
}

$(window).load(function() {
    loadingPage();
    setTimeout(function() {
        stopLoading();
        updateVideoSize();
    }, 5000);


});

$(window).resize(function() {
    updateVideoSize();
});

$(document).ready(function() {

    var bgVideo = document.getElementById("bg-video");

    bgVideo.autoplay = true;
    bgVideo.loop = true;
    myVid.preload = "auto";
    bgVideo.play();

});
