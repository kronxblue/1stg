$(document).ready(function() {
    $('.close').click(function() {
        $(this).parent().slideUp();
    });

    $('#supplier').on("click", ".btn-contact-toggle", function() {

        $(this).parent('td').children('.contact-toggle').toggle('blind', 300);

        return false;
    });

});
