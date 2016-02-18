/**
 * Created by tigran on 7/30/15.
 */

$(document).ready(function(){
    setInterval(ajaxcall, 5000);
});
function ajaxcall() {
    jQuery.ajax({
        url: "http://46.130.127.109:8739/jsonp/GetMonitor",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            var data = resultData.result;
            for (var i = 0; i < data.length; i++) {

                if (data[i].status == 'Ավարտ' || data[i].status == 'Հանգիստ') {
                    $('.cart' + data[i].shlang_id).css({"background-color": "#bdbdbd"});
                    if(data[i].ed_izm=='Լրիվ'){
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել լրիվ');
                    }
                    else{
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                    }
                    $('#' + data[i].shlang_id + '').html(data[i].shlang_id + ' ' + data[i].status);
                }
                else if (data[i].status == 'Դադար') {
                    $('.cart' + data[i].shlang_id).css({"background-color": "#90a4ae"});
                    if(data[i].ed_izm=='Լրիվ'){
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել լրիվ');
                    }
                    else{
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                    }
                    $('#' + data[i].shlang_id + '').html(data[i].shlang_id + ' ' + data[i].status);
                }
                else if (data[i].status == 'Վթար') {
                    $('.cart' + data[i].shlang_id).css({"background-color": "#d50000"});
                    if(data[i].ed_izm=='Լրիվ'){
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել լրիվ');
                    }
                    else{
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                    }
                    $('#' + data[i].shlang_id + '').html(data[i].shlang_id + ' ' + data[i].status);
                }
                else if (data[i].status == 'Պատվեր') {
                    $('.cart' + data[i].shlang_id).css({"background-color": "#80cbc4"});
                    $('#' + data[i].shlang_id + '').html(data[i].shlang_id + ' ' + data[i].status);
                    if(data[i].ed_izm=='Լրիվ'){
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել լրիվ');
                    }
                    else{
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                    }
                }
                else if (data[i].status == 'Նստեցում') {
                    $('#main_div_'+ data[i].shlang_id).addClass('pulse');
                    $('.cart' + data[i].shlang_id).css({"background-color": "#97d533"});
                    if(data[i].ed_izm=='Լրիվ'){
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել լրիվ');
                    }
                    else{
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                    }
                    $('#' + data[i].shlang_id + '').html(data[i].shlang_id + ' ' + data[i].status);
                }
                else if (data[i].status == 'Լիցքավորում') {
                    var pluse = $('#main_div_'+ data[i].shlang_id).find('.pulse');
                    if(pluse != null)
                    {
                        $('#main_div_'+ data[i].shlang_id).removeClass('pulse');
                    }
                    $('.cart' + data[i].shlang_id).css({"background-color": "#b3e5fc"});

                    if(data[i].ed_izm=='Լրիվ'){
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել լրիվ');
                    }
                    else{
                        $('.data' + data[i].shlang_id).html(' Գումար ' + data[i].summa + ' դրամ </br> Քաշ ' + data[i].qash + '/'+ data[i].caval+' Խմ</br>  Ջերմաստիճան ' + data[i].temperatura+ ' C</br></br> Լիցքավորել ' + data[i].zakaz+' դրամի');
                    }

                    $('#' + data[i].shlang_id + '').html(data[i].shlang_id + ' ' + data[i].status);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}