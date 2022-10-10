$(document).ready(function() {
    $.ajax({
        ContentType: "application/json; charset=utf-8",
        url: "/wp-json/vizar/telepulesek",
        dataType: "html",
        type: "get",
        success: function(data) {
            $('#telepules').html(data);
        }
    });
});