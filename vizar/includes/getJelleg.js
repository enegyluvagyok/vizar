$(document).ready(function () {
    $('#telepules').change(function () {
        var telepules = $(this).val();
        $.ajax({
            ContentType: "application/json; charset=utf-8",
            url: "/wp-json/vizar/agazatok?telepules="+telepules,
            dataType: "html",
            type: "get",
            success: function (data) {
                $('#felhasznalas').html(data);
                $('#felhasz_container').css('display', 'block');
            }
        });
    });
});