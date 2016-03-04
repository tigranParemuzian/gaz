/**
 * Created by tigran on 1/24/16.
 */

$(document).ready(function(){
    changeWorker();
    manyTransfer();
    getInfoClient();
    endWork();
    selectInputs()
});

function selectInputs() {

    setInterval(function(){
            var infoTransfer = $('#div-info-transfer').attr('style');
            var infoManyInCart = $('.info-many-in-cart').attr('style');
            var infoEndWork = $('.info-end-work').attr('style');
            var infoRemoveFinance = $('.info-remove-finance').attr('style');
            var infoSuccessFinance = $('.info-success-finance').attr('style');

            if(infoTransfer != 'display: none;')
            {
               $('#input-worker').select();
            }

            if(infoManyInCart != 'display: none;')
            {
                $('#input-client-code').select();
            }

            if(infoEndWork != 'display: none;')
            {
                $('#input-end-work').select();
            }

            if(infoRemoveFinance != 'display: none;')
            {
                $('#remove-finance').select();
            }

            if(infoSuccessFinance != 'display: none;')
            {
                $('#pay-transfer').select();
            }
    }, 1000)
}
/**
 * this function change worker
 *
 */
function changeWorker()
{

    $('.many-transfer').click(function(){

       var oldWorker = $('#input-old-worker').val();
       var newWorker = $('#input-new-worker').val();

        if((oldWorker != null && newWorker!= null) && (oldWorker.length == 10 && newWorker.length == 10 ))
        {
            changeWorkerPost(oldWorker, newWorker);
        }
        else
        {
            $('.info-many-transfer>.modal-dialog>.modal-content>.modal-body>.info-form-error').html('<p> Ներկայիս աշխատատող կամ Նոր աշխատող դաշտերը լրացված չեն </p>');
        }
    });
}

/**
 * this function send data for change worker
 *
 * @param oldWorker
 * @param newWorker
 */
function changeWorkerPost(oldWorker, newWorker)
{
    jQuery.ajax({
        url: '/api/gazs/changes',
        type: "POST",
        contentType: 'application/json; charset=utf-8',
        async: true,
        dataType:"json",

        data: JSON.stringify({
            "oldWorker": oldWorker,
            "newWorker": newWorker
        }),
        success:function(ansvwe)
        {
            if(ansvwe.message== "success") {

                setTimeout(function(){
                    location.reload();
                }, 1);
            }
            else {

                $('.info-many-transfer>.modal-dialog>.modal-content>.modal-body>.info-form-error').html('<p> Ներկայիս աշխատատող կամ Նոր աշխատող դաշտերը լրացված չեն </p>');
            }
        }
    });
}

/**
 * This function get info about client by cart code
 */
function getInfoClient()
{
    $(document).keypress(function(e) {

        if (e.which == 13) {
            var inputData = e.target;

            if (inputData.id == 'input-client-code') {
                var codeWorker = inputData.value;
                var inputCode = $('#input-client-code');

                if (codeWorker.length == 10) {
                    getDataRuest(codeWorker);
                    inputCode.val(null);
                }
                else {
                    inputCode.val(null);
                    inputCode.select();

                    $('.info-many-in-cart>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Քարտային տվիալները մուտքագրված չեն կամ սխալ են մուտքագրված </p>')
                }
            }
        }
    });
}

/**
 *
 * @param code
 */
function getDataRuest(code) {

    jQuery.ajax({
        url: "/api/gazs/"+code+"/info/by/cart",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            $('#input-client-code').attr('value', '');

            var result = resultData;
            if (result != null) {
                var paymentType = null;
                if(result.payment_types == 1)
                {
                    paymentType = 'փոխանցումով';
                }
                else if(result.payment_types == 0)
                {
                    paymentType = 'անվճար';
                }
                else {
                    paymentType = 'կանխիկ';
                }

                $('.info-many-in-cart>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Քարտատեր ' + result.name + ' ' + result.last_name + '</p> ' +
                    '                                                                       <p> Համարներն են՝ '+ result.care_number +'</p>' +
                                                                                            '<p> Հաշվեկշռին՝ '+ result.deposit_limit +' դրամ</p>' +
                                                                                            '<p> Կուտակային՝ '+ result.cash_info +' դրամ</p>' +
                                                                                            '<p> Զեղճման տոկոսն է`'+ result.percent +'%</p>' +
                                                                                            '<p> Վճարում է՝ '+ paymentType +' </p>')

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 404)
            {
                $('#input-client-code').attr('value', '');
                $('.info-many-in-cart>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Մուտքագրված քարտատերը գոյություն չունի </p>');
            }
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function manyTransfer()
{
    var formMany = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.form-many').hide();
    var formDirector = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.form-director').hide();
    var infoResponse = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.info-response').hide();
    var formWorker = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.form-worker');
    var formInfo = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.info-form');
    var formSelect = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.select-type').hide();
    var formBack = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.back').hide();
    var formBackLink = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.back >a');
    var formOther = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.other').hide();

    $('#button-info-transfer').click(function(){

        formMany.hide();
        formDirector.hide();
        infoResponse.hide();
        formSelect.hide();
        formOther.hide();
        formBack.hide();
        formWorker.show();
        $('#input-worker').show();
        $('#input-worker').val(null);
        $('#input-many').val(null);
        $('#input-director').val(null);
        $('#input-message').val(null);
        formInfo.show();
        formInfo.html( '<p> Մուտքագրեք փոխանցողի քարտային տվյալը։</p>');
    });

    // check enter
    $(document).keypress(function(e) {
        if(e.which == 13) {
            var inputData=  e.target;

            if(inputData.id == 'input-worker')
            {
                var codeWorker = inputData.value;

                if(codeWorker.length == 10)
                {

                formWorker.hide();
                formMany.show();
                formInfo.html( '<p> Մուտքագրեք փոխանցվող գումարի չափը:</p>');
                $('#input-many').select();

                $(document).keypress(function(e) {
                    if(e.which == 13) {
                        var inputData = e.target;

                        if (inputData.id == 'input-many') {
                            var many = inputData.value;

                            if(many != null)
                            {

                                jQuery.ajax({
                                    url: "/api/gazs/" + codeWorker + "/many",
                                    type: "GET",
                                    contentType: 'application/json; charset=utf-8',
                                    async: true,
                                    success: function (resultData) {
                                        if(parseInt(many) <= parseInt(resultData)) {
                                            formMany.hide();
                                            formSelect.show();
                                            infoResponse.html(null);
                                        }
                                        else {
                                            infoResponse.show();
                                            infoResponse.html( '<p style="color: red">Փոխանցումը հնարավոր չէ կատարել: Աշխատողի հաշվին գումարը բավարար չէ:<br/> Հաշվին կա ' + parseInt(resultData) + ' դրամ</p>');
                                            $('#input-many').val(null);
                                            $('#input-many').select();
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        if(jqXHR.status == 404)
                                        {
                                            infoResponse.show();
                                            infoResponse.html( '<p style="color: red">Փոխանցումը հնարավոր չէ կատարել: Աշխատողի ' + codeWorker + ' գոյություն չունի</p>');
                                            $('#input-many').val(null);
                                            $('#input-many').select();
                                        }
                                        console.log(jqXHR, textStatus, errorThrown);
                                    }
                                });


                                formSelect.on('change', function (e) {

                                    var optionSelected = $("option:selected", this).text();
                                    if(optionSelected === 'Փողանցել')
                                    {
                                        formSelect.hide();
                                        formDirector.show();
                                        formBack.show();
                                        formInfo.html( '<p>'+ many +' գումարը ստանալու համար խնդրում ենք մուտքագրել ստացողի քարտային տվիալները:</p>');
                                        $('#input-director').select();

                                    }
                                    else if(optionSelected === 'Աիլ ծախսեր')
                                    {

                                        formSelect.hide();
                                        formOther.show();
                                        formBack.show();
                                        formInfo.html( '<p>'+ many +' գումարը ստանալու համար խնդրում ենք մուտքագրել ծախսեի նպատակը:</p>');
                                        $('#input-message').select();
                                    }

                                    formBackLink.click(function(){
                                        formSelect.show();
                                        formOther.hide();
                                        formBack.hide();
                                        formDirector.hide();
                                        formInfo.html( '<p>'+ many +' գումարը ստանալու համար խնդրում ենք մուտքագրել ելքի նպատակը:</p>');
                                    });
                                });
                                $(document).keypress(function(e) {
                                    if (e.which == 13) {

                                        var inputData = e.target;

                                        if (inputData.id == 'input-director') {
                                            var codeDirector = inputData.value;

                                            if (codeDirector.length == 10) {

                                                postManyTransfer(codeWorker, many, codeDirector);

                                            }
                                        }
                                        else if(inputData.id == 'input-message')
                                        {
                                            var message = inputData.value;

                                            if (message.length != 0) {
                                                console.log(message);

                                                postManyTransfer(codeWorker, many, null, message);

                                            }
                                        }
                                    }
                                });
                            }
                            else {

                                infoResponse.show();
                                infoResponse.html( '<p style="color: red">Փոխանցումը հնարավոր չէ կատարել: Գումար դաշտը լրացված չէ:</p>');
                                $('#input-many').val(null);
                                $('#input-many').select();
                            }
                        }
                    }
                })
                }
                else {

                    infoResponse.show();
                    infoResponse.html( '<p style="color: red">Փոխանցումը հնարավոր չէ կատարել: Քարտը անվավեր է:</p>');
                    $('#input-worker').val(null);
                }
            }
        }
    })
}

function postManyTransfer(worker, cash, director, message)
{

    var infoResponse = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.info-response');
    var formBack = $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.back').hide();
    infoResponse.show();
    jQuery.ajax({
        url: '/api/gazs/manies/transfers',
        type: "POST",
        contentType: 'application/json; charset=utf-8',
        async: true,
        dataType:"json",

        data: JSON.stringify({
            "worker": worker,
            "cash": cash,
            "director": director,
            "message": message
        }),
        success:function(ansvwe)
        {
            window.navbarData();
            if(ansvwe.message== "success") {

                $('#input-director').hide();
                $('#input-message').hide();
                $('#input-worker').hide();
                $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.info-form').hide();

                if(ansvwe.senderName != ansvwe.recipientName && ansvwe.transferInfo == null) {
                    infoResponse.html('<p>' + ansvwe.cash + ' դրամ գումարը հաջողությամբ փոխանցված է '
                        + ansvwe.senderName + 'ից '
                        + ansvwe.recipientName +'ի հաշվին:'
                        + ansvwe.senderName +'ի հաշվին մնաց <b>'+ ansvwe.cashBalance +'</b> դրամ</p>');
                }
                else {
                    infoResponse.html('<p>' + ansvwe.cash + ' դրամ գումարը հաջողությամբ փոխանցված է '
                        + ansvwe.senderName + 'ից '
                        + ansvwe.transferInfo +'ի նպատակով:'
                        + ansvwe.senderName +'ի հաշվին մնաց <b>'+ ansvwe.cashBalance +'</b> դրամ</p>')
                }

            }
            else {

                infoResponse.html('<p style="color: red"> Գումարը չի կարող փոխանցվել։ Ձեր հասհվին կա '+ ansvwe.cashBalance +' դրամ: </p>');
                $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.form-many').hide();
                $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.form-director').hide();
                $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.form-worker').show();
                $('.info-transfer>.modal-dialog>.modal-content>.modal-body>.info-form').html('<p> Մուտքագրեք փոխանցողի քարտային տվյալը կրկին։ </p>');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 400)
            {
                $('#input-director').attr('value', '');
                $('#input-many').attr('value', '');

                infoResponse.html('<p style="color: red"> Մուտքագրված քարտատերը գոյություն չունի </p>');
            }
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function endWork() {

    jQuery.ajax({
        url: "/api/gaz/last/change",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {

            var result = resultData;

            $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').html('<p>Նախորդ աշխատանքի ավարտին գումարը կազմել է՝ <b> '+ result.cash +' </b> դրամ։ </p>' +
                '<p>Աշխատանքային ֆոնդին փոխանցվել է՝ <b>'+ result.payment_percent +'</b> դրամ։</p>')

        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 404)
            {
                $('#input-client-code').attr('value', '');
                $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').html('<p style="color: red"> Աշխատանքի ավարտի մասին տեղեկատվություն չկա։ </p>');
            }
            console.log(jqXHR, textStatus, errorThrown);
        }
    });

    $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').html('<p style="color: red"> Աշխատանքը չի կարղ ավարտվել։ Քարտը սխալ է մուտքագրվել։ </p>');

    $(document).keypress(function(e) {
        if(e.which == 13) {
            var inputData=  e.target;

            if(inputData.id == 'input-end-work')
            {
                var codeWorker = inputData.value;

                if(codeWorker.length == 10) {

                    changeRest(codeWorker);

                    $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info-last').hide();
                }
                else {
                    $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info-last').hide();
                    $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').html('<p style="color: red"> Աշխատանքը չի կարղ ավարտվել։ Քարտը սխալ է մուտքագրվել։ </p>');

                    $('#info-work-end').click(function(){
                        $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').hide();
                        $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info-last').show();
                    });
                }
                $('#input-end-work').val(null);
            }
        }
    });
}

function changeRest(code)
{
    jQuery.ajax({
        url: "/api/gazs/"+code+"/ended/change",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            $('#input-end-work').attr('value', '');

            var result = resultData;
            if (result.message == 'success') {

                $('#input-client-code').hide();
                $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Աշխատանքն ավարտված է։ Գումարը կազմել է՝ <b> '+ result.data.cash +' </b> դրամ։ </p>' +
                    '<p>Աշխատանքային ֆոնդին փխանցվել է՝ <b>'+ result.data.paymentPercent +'</b> դրամ։</p>')

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 404)
            {
                $('#input-client-code').attr('value', '');
                $('.info-end-work>.modal-dialog>.modal-content>.modal-body>.info').html('<p> Մուտքագրված քարտատերը գոյություն չունի </p>');
            }
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

