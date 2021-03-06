/**
 * Created by tigran on 7/30/15.
 */

var intervalLocal = null;
var intervalReal = null;

$(document).ready(function(){
    intervalLocal = setInterval(ajaxCallLocale, 5000);
    intervalReal = setInterval(ajaxCallReal, 5000);
});

function ajaxCallLocale() {
    jQuery.ajax({
        url: "http://192.168.1.3:8739/jsonp/GetMonitor            ",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            clearInterval(intervalReal);
            var data = resultData.result;
            calculateData(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function ajaxCallReal() {
        jQuery.ajax({
            url: "http://46.130.127.109:8739/jsonp/GetMonitor            ",
            type: "GET",
            contentType: 'application/json; charset=utf-8',
            async: true,
            success: function (resultData) {
                clearInterval(intervalLocal);
                var data = resultData.result;

                calculateData(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
}

function calculateData(data)
{

    for (var i = 0; i < data.length; i++) {

        var status = data[i].status;
        var summa = data[i].summa;
        var shlang_id =  data[i].shlang_id;
        var qash =  data[i].qash;
        var caval =  data[i].caval;
        var temperatura =  data[i].temperatura;
        var ed_izm =  data[i].ed_izm;

        var sumLen = summa;
        var summ = sumLen.substring(sumLen.length-2);
        var price;
        if(summ != 0)
        {
            if(summ <= 25)
            {
                price = Number(summa) - summ;
            }
            else if((summ > 25 && summ <= 50) || (summ > 50 && summ <= 75))
            {
                price = Number(summa) - summ + 50;
            }
            else if (summ > 75 && summ <= 100){

                price = Number(summa) - summ + 100;
            }
            else
            {
                price = summa;
            }
        }
        else {
            price = summa;
        }

        if (status == 'Ավարտ' || status == 'Հանգիստ') {
            $('#main_' + shlang_id).css({"background-color": "#bdbdbd", "border-radius": "10px", "margin-top": "10px", "min-height": "100px"});
        }
        else if (status == 'Դադար') {
            $('#main_' + shlang_id).css({"background-color": "#90a4ae", "border-radius": "10px", "margin-top": "10px", "min-height": "100px"});
        }
        else if (status == 'Վթար') {
            $('#main_' + shlang_id).css({"background-color": "#d50000", "border-radius": "10px", "margin-top": "10px", "min-height": "100px"});
        }
        else if (status == 'Պատվեր') {
            $('#main_' + shlang_id).css({"background-color": "#80cbc4", "border-radius": "10px", "margin-top": "10px", "min-height": "100px"});
        }
        else if (status == 'Նստեցում') {
            //$('#main_div_'+ shlang_id).addClass('pulse');
            $('#main_' + shlang_id).css({"background-color": "#1AFF1A", "border-radius": "10px", "margin-top": "10px", "min-height": "100px"});
        }
        else if (status == 'Լիցքավորում') {
            //$('#main_div_'+ shlang_id).addClass('pulse');
            $('#main_' + shlang_id).css({"background-color": "#66ffff", "border-radius": "10px", "margin-top": "10px", "min-height": "100px"});
            var pluse = $('#main_div_'+ shlang_id).find('.pulse');
            if(pluse != null)
            {
                $('#main_div_'+ shlang_id).removeClass('pulse');
            }
        }

        if(ed_izm=='Լրիվ'){
            $('.zakaz-' + shlang_id).html('Պատվեր <b>լրիվ</b>');
        }
        else{
            $('.zakaz-' + shlang_id).html('Պատվեր <b>' + data[i].zakaz+'</b> դ.');
        }

        $('.data' + shlang_id).html('<b> Գումար ' + price + ' դ. </b> </br> ' +
            'Քաշ ' + qash + '/'+ caval+' Խմ</br>  ' +
            'Ջերմ. ' + temperatura+ ' C</br>');
        $('#' + shlang_id + '').html(status);

    }
}