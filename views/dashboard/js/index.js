$(document).ready(function() {

    topSponsor();
    
    $("#fx-gps-title").Morphext({
        animation: "pulse"
        
    });
    $("#fx-gps-value").Morphext({
        animation: "pulse",
        separator: "|"
    });

});

function topSponsor() {
    var url = $("#topSponsor").attr("data-url");

    $.get(url, function(o) {
        $("#topSponsor").html(o);
    }, 'json');
}
