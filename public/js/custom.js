$(document).ready(function () {

});

var BASE_PATH = 'http://' + location.hostname + '/';

function contain_wspace(v) {
    var count = v.split(' ');
    if (count.length > 1) {
        return true;
    } else {
        return false;
    }
}

function num_pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}

function clearForm(formName) {
    var frm = $(formName);
    var frmInput = frm.find(":input");

    for (var i = 0; i < frmInput.length; ++i) {
        var type = frmInput[i].tagName.toLowerCase();

        if (type == "input" || type == "textarea" || type == "select") {
            $(frmInput[i]).val("");
        }
    }


}

function format_number(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
