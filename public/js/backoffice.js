$(document).ready(function() {

//    SIDEMENU
    $(".sidemenu-toggle").bind('click', function() {
        var content_wrap = $(".content-wrap");
        content_wrap.toggleClass('sidemenu-open');
        return false;

    });

//    ICON HOVER SPIN
    $("a").hover(function() {
        $(this).children('i').toggleClass('fa-spin');
    });

//    SUBMENU TOGGLE
    $(".has-submenu a.submenu-toggle").bind('click', function() {
        var submenu = $(this).parent('.has-submenu');
        var this_a = $(this).attr('data-parent');

        $(".navigation").find("li.has-submenu").each(function() {

            var a = $(this).children('a').attr('data-parent');

            if (this_a != a) {
                var submenu_open = $(this).hasClass('submenu-open');

                if (submenu_open) {
                    $(this).toggleClass('submenu-open', 400);
                }
            }
        });

        submenu.toggleClass('submenu-open', 400);

        return false;
    });

//    LINK NOT AVAILABLE
    $(document).on('click', '.unavailable-link', function() {
        alert("We're so sorry. This feature is not ready yet. We will notify you when it's ready.\n\nThank you.\n1STG Support Team.");
        return false;
    });

    $(document).on('click', '.rfalse', function() {

        return false;
    });

//    MESSAGES DROPDOWN
    $(document).on('click', '#messages', function() {
        toggleLoading(this, true);

        var url = $(this).attr("href");

        $.get(url, function(o) {
            console.log(o);
        }, 'json');





    });
});

function toggleLoading(itemID, cond) {
    var dropdown_loading = $(itemID).parent(".dropdown").children(".dropdown-menu").children(".row").children(".col-xs-12").children(".dropdown-loading");

    if (cond) {
        dropdown_loading.removeClass("hidden");
    } else {
        dropdown_loading.addClass("hidden");
    }
}

