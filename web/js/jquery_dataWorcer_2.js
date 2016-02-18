/**
 * Created by tigran on 7/30/15.
 */

$(document).ready(function(){
    setInterval(ajaxGetData, 3000);
    setInterval(calcResoult, 9000);
});

function ajaxGetData() {
    jQuery.ajax({
        url: "http://46.130.127.109:8739/jsonp/GetLast",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            var result = resultData.result;
            calcResoult(result)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function calcResoult(data)
{
    for (var i = 0; i < data.length; i++) {
        
        var status = data[i].status;
        var summa = data[i].summa;
        var gorcarqId =  data[i].id;
        var shlang_id =  data[i].shlang_id;
        var qash =  data[i].qash;
        var caval =  data[i].caval;
        var temperatura =  data[i].temperatura;
        var ed_izm =  data[i].ed_izm;
        
        if (status == 'Դադար') {
            $('.cart' + shlang_id).css({"background-color": "#90a4ae"});
            if(ed_izm=='Լրիվ'){
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել լրիվ');
            }
            else{
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
            }
            $('#' + shlang_id + '').html(shlang_id + ' ' + status);
        }
        else if (status == 'Վթար') {
            $('.cart' + shlang_id).css({"background-color": "#d50000"});
            if(ed_izm=='Լրիվ'){
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել լրիվ');
            }
            else{
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
            }
            $('#' + shlang_id + '').html(shlang_id + ' ' + status);
        }
        else if (status == 'Պատվեր') {
            $('.cart' + shlang_id).css({"background-color": "#80cbc4"});
            $('#' + shlang_id + '').html(shlang_id + ' ' + status);
            if(ed_izm=='Լրիվ'){
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել լրիվ');
            }
            else{
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
            }
        }
        else if (status == 'Նստեցում') {
            $('#main_div_'+ shlang_id).addClass('pulse');
            $('.cart' + shlang_id).css({"background-color": "#97d533"});
            if(ed_izm=='Լրիվ'){
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել լրիվ');
            }
            else{
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
            }
            $('#' + shlang_id + '').html(shlang_id + ' ' + status);
        }
        else if (status == 'Լիցքավորում') {
            var pluse = $('#main_div_'+ shlang_id).find('.pulse');
            if(pluse != null)
            {
                $('#main_div_'+ shlang_id).removeClass('pulse');
            }
            $('.cart' + shlang_id).css({"background-color": "#b3e5fc"});

            if(ed_izm=='Լրիվ'){
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել լրիվ');
            }
            else{
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
            }

            $('#' + shlang_id + '').html(shlang_id + ' ' + status);
        }
        else if (status == 'Ավարտ' || status == 'Հանգիստ') {
            $('#' + shlang_id + '').html(shlang_id + ' ' + status + '<i id="clicable' + shlang_id + '" class="material-icons right clicable">more_vert</i>');

            if(ed_izm=='Լրիվ'){
                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել լրիվ');
            }
            else{

                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
            }
            $('.opened' + shlang_id + '').css({"background-color": "#76ff03"});

            if(ed_izm=='Լրիվ'){

                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C </br></br> Լիցքավորել լրիվ');
                $('#opened' + shlang_id + '').html(shlang_id + ' ' + status +'<i id="clicable' + shlang_id + '" class="material-icons right clicable">close</i>');
                $('.end' + shlang_id + '').html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C ');
            }
            else{

                $('.data' + shlang_id).html(' Գումար ' + summa + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C </br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                $('#opened' + shlang_id + '').html(shlang_id + ' ' + status +' <i id="clicable' + shlang_id + '" class="material-icons right clicable">close</i>');
                $('.end' + shlang_id + '').html(' Գումար ' + data[i].zakaz + ' դրամ </br> Քաշ ' + qash + '/'+ caval+' Խմ</br>  Ջերմաստիճան ' + temperatura+ ' C ');
            }
            $('#clicable' + shlang_id + '').click();
            $('a').hide();
            $('#send_' + shlang_id +'').hide();
            $('#sale_val' + shlang_id +'').hide();

            var sumLen = summa;
            var summ = sumLen.substring(sumLen.length-2);
            var price;
            if(summ >= 50 && summ != 0)
            {
                price = 100 - summ + Number(summa);
            }
            else if(summ != 0)
            {
                price =  50 - summ + Number(summa);
            }
            else {
                price = summa;
            }
            $('#price_val' + shlang_id).val(price);
            var priceVal = $('#price_val' + shlang_id).val();
            //priceVal = $('#sale_val' +  shlang_id +'').hide();
            var codeBuy = $('#by_val'+ shlang_id).val();
            var  codeSal= $('#sale_val'+ shlang_id).val();

            if(gorcarqId != null)
            {
                getRequest(codeBuy, codeSal, shlang_id, gorcarqId, priceVal);
            }
            else {
                console.log(codeBuy, codeSal, shlang_id, gorcarqId, priceVal); stop();
            }

        }
    }
}
function getRequest(codeBuy, codeSal, shlang_id, gotcarq, priceVal)
{
    jQuery.ajax({
            url: '/app_dev.php/api/gazs/inputs',
            type: "POST",
            contentType: 'application/json; charset=utf-8',
            async: true,
            dataType:"json",

            data: JSON.stringify({
                "client": codeBuy,
                "worker": codeSal,
                "price": $('#price_val' +shlang_id).val(),
                "gotcarq": gotcarq,
                "summa": priceVal,
                "terminalId": shlang_id
            }),
            success:function(ansvwe)
            {
                if(ansvwe.message== "success")
                {
                    afterSuccess(ansvwe);
                }
            }
        });
}

function afterSuccess(message)
{
    if(message.clientState != 6 && message.clientState != 3)
    {
        $('#by_val'+ message.terminalId).val(message.clientCode);
    }
    $('#clicable4' + message.terminalId + '').click();

}
