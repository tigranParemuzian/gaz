/**
 * Created by tigran on 7/30/15.
 */

$(document).ready(function(){
    getDataTerminals();
    getCount();
    navbarData();
    setInterval(getDataTerminals, 10000);
    deleteLast();
    setInterval(calcSecNav, 1000);
    clerDellData()

});

var timeRest = 600;

function calcSecNav(){
    timeRest = timeRest - 1;
    var calcSec = $('#calculate-secounds');

    if(timeRest <= 10) {
        calcSec.css({"color": "#FF0000"});
    }
    calcSec.text(timeRest);
}

var t = [];

/**
 * This function use to get data
 */
function getDataTerminals() {

    jQuery.ajax({
        url: "/api/gaz/terminal/counts",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            var result = resultData;

            for (var i = 0; i < result.length; i++)
            {
                var terminalNumber = result[i].number;
                t[terminalNumber] = result[i].number;
                ajaxGetDataByShlangId(result[i].number, null);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

/**
 *
 * @param shlang_id
 * @param gorcarqId
 * @param summa
 */
function sendDataByTerminal(shlang_id, gorcarqId, summa)
{

    $('.info-remove-finance>.modal-dialog>.modal-content').click(function() {

        $("#remove-finance").select();
    });

    $('#btn-terminal_'+ shlang_id).click(function ()
    {
        $('.main-table').css({'border': '4px solid #fff9f6'});
        $('.terminal-'+ shlang_id).css({'border': '4px solid #4d88ff'});
        $( "#by_val"+ shlang_id ).select();
    });

    $('.terminal-'+ shlang_id).click(function () {
        $('.main-table').css({'border': '4px solid #fff9f6'});
        $('.terminal-'+ shlang_id).css({'border': '4px solid #4d88ff'});
        $( "#by_val"+ shlang_id ).select();
    });

    // get enter click event
    $(document).keypress(function(e) {
        if(e.which == 13) {
            var inputData=  e.target;

            if(inputData.id == 'by_val'+ shlang_id)
            {
                var codeBuy = inputData.value;
                var t =$('#by_val'+shlang_id);
                if(codeBuy.length == 10)
                {
                    ajaxGetDataByShlangId(shlang_id, codeBuy);
                    t.css({'display': 'none'});
                    t.show(2000);
                    t.val(null);
                }
            }
        }
    });
}


/**
 *
 * @param shlang_id
 */
function ajaxGetDataByShlangId(shlang_id, codeBuy) {

    jQuery.ajax({
        url: "/api/gazs/"+ shlang_id +"/terminal",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            var result = resultData;

            if(result != 'worning')
            {
                if(codeBuy != null)
                {
                    var summa = result.cost;
                    var gorcarqId = result.gotcarqId;
                    var terminal_id = result.number;

                    sendRequest(codeBuy, terminal_id, gorcarqId, summa );
                }
                getCountByTerminal(shlang_id);
                calcResoultByTerminalId(result);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

/**
 * this function get counts of terminals
 */
function getCount()
{
    jQuery.ajax({
        url: "/api/gaz/count",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            var result = resultData;
            if(result != null)
            {
                for (var i = 0; i < result.length; i++) {
                    var dataInfo = $('.data_' + result[i].number + '>.panelRefresh>.panel-heading>.count');
                    var content = $('.terminal-'+result[i].number);
                    if(result[i].cnt>1)
                    {
                        content.css({"background-color": "darksalmon"});
                        dataInfo.show();
                        dataInfo.html('Չվճարված գործարքներ`<b  style="color: red"> ' + result[i].cnt +' հատ</b> </h4>');
                    }
                    else if(result[i].cnt ==1)
                    {
                        dataInfo.hide();
                        content.css({"background-color": "darksalmon"});
                    }
                    else {
                        //content.addClass('zoro');
                        content.css({"background-color": ""});
                        dataInfo.hide()
                    }

                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function getCountByTerminal(shlang_id) {

    jQuery.ajax({
        url: "/api/gazs/"+ shlang_id +"/count/by/terminal",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            var result = resultData;
            var dataInfo = $('.data_' + shlang_id + '>.panelRefresh>.panel-heading>.count');
            var content = $('.terminal-' + shlang_id);
            if(result.cnt>1)
            {
                content.css({"background-color": "darksalmon"});
                dataInfo.show();
                dataInfo.html('Չվճարված գործարքներ`<b  style="color: red"> ' + result.cnt +' հատ</b> </h4>');
            }
            else if(result.cnt == 1)
            {
                dataInfo.hide();
                content.css({"background-color": "darksalmon"});
            }
            else {
                content.css({"background-color": ""});
                $('.real_price_val' + shlang_id).html('Վճարման ենթակա գործարք չկա:');
                dataInfo.hide();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });


}

/**
 *
 * @param data
 */
function calcResoultByTerminalId(data)
{
    if(data != null)
    {
        var summa = data.cost;
        var gorcarqId = data.gotcarqId;
        var shlang_id = data.number;

        $('#send_' + shlang_id +'');
        $('#sale_val' + shlang_id +'');
        $('.real_price_val' + shlang_id).html('Վճարման գումարը՝ </br><b>' + summa + '</b> դ.');
        $('#price_val' + shlang_id).hide();
        $('.data_' + shlang_id).show();
        sendDataByTerminal(shlang_id, gorcarqId, summa);
    }
}



/**
 *
 * @param codeBuy
 * @param shlang_id
 * @param gotcarq
 * @param priceVal
 * @param summa
 */
function sendRequest(codeBuy, shlang_id, gotcarq, summa)
{
    jQuery.ajax({
            url: '/api/gazs/inputs',
            type: "POST",
            contentType: 'application/json; charset=utf-8',
            async: true,
            dataType:"json",

            data: JSON.stringify({
                "client": codeBuy,
                "gotcarq": gotcarq,
                "summa": summa,
                "terminalId": shlang_id
            }),
            success:function(ansvwe)
            {
                if(ansvwe.message== "success")
                {
                    afterSuccess(ansvwe);
                }
                else if(ansvwe.message == "warning") {

                    afterError(ansvwe, shlang_id);
                }
            }
        });
}

/**
 *
 * @param message
 */
function afterSuccess(message)
{
    var termInfo = $('.cost_price_val' + message.terminalId);
    if(message.deposit >0) {
        termInfo.html( 'Վճարվել է <b>' +message.cache + '</b>  դ.: </br>Կուտակվել է <b>' + message.deposit + '</b> դ.:');
    }
    else {
        termInfo.html( 'Վճարվել է <b>' +message.cache + '</b>  դ.:');
    }

    $('#by_val'+ message.terminalId).val(null);
    var $terminal = message.terminalId;
    if($terminal > 0)
    {
        getCountByTerminal($terminal);
        ajaxGetDataByShlangId($terminal, null);
    }
    navbarData();
}

/**
 *
 * @param message
 */
function afterError(message, shlang_id)
{
    var termInfo = $('.cost_price_val' + shlang_id);
    if(message.msg) {

        termInfo.text( message.msg );
    }
    else {
        setTimeout(function(){
            location.reload();
        }, 200);
    }

    $('#by_val'+ message.terminalId).val(null);
    var $terminal = message.terminalId;
    if($terminal > 0)
    {
        getCountByTerminal($terminal);
        ajaxGetDataByShlangId($terminal, null);
    }
    navbarData();
}

function deleteLast()
{
    var terminalId = null;
    $("button").click(function() {
        var id = this.id;

        for (var i = 0; i < t.length; i++) {

            if(id == 'btn-dell-'+t[i])
            {
                terminalId = t[i];
                $('.info-remove-finance>.modal-dialog>.modal-content>.modal-body>.info').html(
                    '<p> Ներկայիս աշխատատող դաշտը լրացված չէ ! </p>'
                );
            }
            else if(id == 'btn-success-' + t[i])
            {
                terminalId = t[i];
                $('.info-success-finance>.modal-dialog>.modal-content>.modal-body>.info').html(
                    '<p> Ներկայիս աշխատատող դաշտը լրացված չէ ! </p>'
                );
            }
        }
    });

    $(document).keypress(function(e) {
        if(e.which == 13) {

            var inputData = e.target;

            if (inputData.id == 'remove-finance') {
                var inputElem = $('#remove-finance');
                var code = inputData.value;

                if (code.length == 10 ) {

                    inputElem.val(null);
                    inputElem.hide();
                    deleteLastreRuest(terminalId, code);
                }
                else {
                    $('.info-remove-finance>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Ներկայիս աշխատատող դաշտը լրացված չէ ! </p>');
                }
            }
            else if(inputData.id == 'pay-transfer')
            {
                var codeBuy = inputData.value;
                var t =$('#pay-transfer');
                if(codeBuy.length == 10)
                {
                    ajaxGetDataByShlangId(terminalId, codeBuy);

                    t.css({'display': 'none'});
                    t.show(2000);
                    t.val(null);
                }
            }
        }
    });
}


/**
 *
 * @param shlang_id
 * @param code
 */
function deleteLastreRuest(shlang_id, code) {

    jQuery.ajax({
        url: "/api/gazs/" + shlang_id + "/deletes/"+ code,
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            $("#terminal-id-remove").attr('value', '');
            $('#remove-finance').attr('value', '');
            var result = resultData;
            if (result != null) {
                getCountByTerminal(shlang_id);
                ajaxGetDataByShlangId(shlang_id, null);

                $('.info-remove-finance>.modal-dialog>.modal-content>.modal-body>.info').html('<p>' + resultData + '</p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

/**
 *
 */
function clerDellData() {

    $('.info-remove-finance>.modal-dialog>.modal-content>.modal-header>button').click(function(){
        $('#remove-finance').val(null);
        $('#remove-finance').show();
        $('.info-remove-finance>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Ներկայիս աշխատատող դաշտը լրացված չէ ! </p>')
    })
}

/**
 *
 */
function navbarData() {

        jQuery.ajax({
            url: "/api/gaz/nav/data",
            type: "GET",
            contentType: 'application/json; charset=utf-8',
            async: true,
            success: function (resultData) {

            var submited = resultData.submited;
            var many = resultData.many;
            var failed = resultData.failed;
            var failedMany = resultData.failedMany;
            var cashMany = resultData.cashMany;
            var manyCart = resultData.cartMany;

            var countSubmited = $('.info-count>.modal-dialog>.modal-content>.modal-body>.all-data');
            var missing = $('.info-count>.modal-dialog>.modal-content>.modal-body>.missing-data');
            var cash = $('.info-cost>.modal-dialog>.modal-content>.modal-body>.cash-data');
            var all = $('.info-cost>.modal-dialog>.modal-content>.modal-body>.all-data');
            var failedCash = $('.info-cost>.modal-dialog>.modal-content>.modal-body>.missing-data');
            var cartMany = $('.info-cost>.modal-dialog>.modal-content>.modal-body>.cart-many');

            if (submited != null) {

                countSubmited.html('<p> Ընդունված գործարքներ` <b > '+ submited +' </b> </p>');
            }
            else {
                countSubmited.html('<p> Ընդունված գործարքներ` <b > 0 </b> </p>');
            }

            if (failed != null) {

                missing.html('<p> Չընդունած գործարքներ` <b > '+ failed +' </b> </p>');
            }
            else {
                missing.html('<p> Չընդունած գործարքներ` <b > 0 </b> </p>');
            }

            if (many != null) {

                all.html('<p> Ընդունված գումար` <b > '+ many +' </b> դ. </p>');
            }
            else {
                all.html('<p> Ընդունված գումար` <b > 0 </b> դ. </p>');
            }

            if (failedMany != null) {

                failedCash.html('<p> Չընդունած գումար` <b > '+ failedMany +' </b> դ. </p>');
            }
            else {
                failedCash.html('<p> Չընդունած գումար` <b > 0 </b> դ. </p>');
            }

            if(cashMany != null)
            {
                cash.html('<p> Դրամարկղի գումար՝ <b>' + cashMany + '</b> դ․ </p>');
            }
            else {
                cash.html('<p> Դրամարկղի գումար՝ <b> 0 </b> դ․ </p>');
            }

            if(manyCart != null)
            {
                cartMany.html('<p> Աշխատողի հաշվին կա՝ <b>' + manyCart + '</b> դ․ </p>');
            }
            else {
                cartMany.html('<p> Աշխատողի հաշվին կա՝ <b> 0 </b> դ․ </p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}