$(document).ready(function () {

    $("#ivoviz").change(function() {
        if(this.checked) {
            $('#calculated-ivo').css('display', 'block');
        }else{
            $('#calculated-ivo').css('display', 'none');
        }
    });

    $("#szennyviz").change(function() {
        if(this.checked) {
            $('#calculated-szenny').css('display', 'block');
        }else{
            $('#calculated-szenny').css('display', 'none');
        }
    });


    $('#calculate').click(function (e) {

        if ($('#telepules').val() == ''){
            toastr.error('Válassza ki a települést!');
            return
        }
        if ($('#fogyasztas').val() == ''){
            toastr.error('Adja meg a fogyasztást!');
            return
        }
        if( $('#ivoviz').is(":checked") == false && $('#szennyviz').is(":checked") == false){
            toastr.error('Válasszon ki legalább egy közműszolgáltatást!');
            return
        }

        e.preventDefault();
        fd = new FormData;
        fd.append('telepules', $('#telepules').val());
        fd.append('felhasznalas', $('#felhasznalas').val());
        fd.append('ivoviz', $('#ivoviz').val());
        fd.append('szennyviz', $('#szennyviz').val());
        fd.append('fogyasztas', $('#fogyasztas').val());

        $.ajax({
            ContentType: "application/json; charset=utf-8",
            url: "/wp-json/vizar/results",
            dataType: "html",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            cache: false,
            success: function (data) {
                $('#hidden').html(data);
                calculate();
            }
        });
    });

    function calculate(){

        var vizteher = $('#vizteher').val()*1.27;
        var ivoalap = $('#ivoalap').val()*1.27;
        var szennyvizalap = $('#szennyvizalap').val()*1.27;
        var vizszolg = $('#vizszolg').val()*1.27;
        var szennyvizszolg = $('#szennyvizszolg').val()*1.27;
        var fogyasztas = $('#fogyasztas').val();

        if(ivoalap === undefined){
            ivoalap = 0;
        }
        if(szennyvizalap === undefined){
            szennyvizalap = 0;
        }
        if(vizteher === undefined){
            vizteher = 0;
        }

        ivo_fogy = vizszolg*fogyasztas;
        ivo_teljes = ivoalap + ivo_fogy;
        szenny_fogy = szennyvizszolg*fogyasztas;
        szenny_teljes = szennyvizalap + szenny_fogy + vizteher;
        vizteher_teljes = vizteher*fogyasztas;

        ivoviz_resp = '<br><p><b>Ivóvíz-szolgáltatás díja ÁFÁ-val együtt:</b></p> ' + ivo_fogy.toFixed(2) + ' Ft vízdíj + ' + ivoalap.toFixed(2) + ' Ft alapdíj = ' + ivo_teljes.toFixed(2) + ' Ft (ÁFÁval együtt)';
        szennyviz_resp = '<p><b>Szennyvíz-szolgáltatás díja ÁFÁ-val együtt:</b></p> ' + szenny_fogy.toFixed(2) + ' Ft szennyvízdíj + ' + vizteher_teljes.toFixed(2) + ' Ft vízterhelési díj + ' + szennyvizalap.toFixed(2) + ' Ft alapdíj = ' + szenny_teljes.toFixed(2) + ' Ft (ÁFÁval együtt)';

        if($('#vizszolg').val() == ""){
            ivoviz_resp = '<p>Ivóvíz-szolgáltatást nem végez társaságunk a kiválasztott településen.</p>';
        }
        if($('#szennyvizszolg').val() == ""){
            szennyviz_resp = '<p>Szennyvízszolgáltatást nem végez társaságunk a kiválasztott településen.</p>';
        }
    

        $('#calculated-ivo').html(ivoviz_resp); 
        $('#calculated-szenny').html(szennyviz_resp) 
        $('#calc-container').css('display', 'block');
    }

});