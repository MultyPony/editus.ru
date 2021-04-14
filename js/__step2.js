$(function(){    
    // if ($('#softpages').length >0){
//        $('#block').hide();

        let main_file_name = 'editus.php';

        $('#cover').hide();
        $('#topapercover').hide();
        $('.megatitle').text('Конфигурация блока');
//        
        $('#toblock').hide();
        $('#toadd').hide();
        $('#toselcover').click(function(){
           window.location = 'order.php'; 
        });
        $('#topapercover').click(function(){
            $('#block').fadeOut(function(){
                $('.megatitle').text('Конфигурация обложки');
                $('#cover').fadeIn();
            });
        });
        $('#topaperblock').click(function(){
            $('#add').fadeOut(function(){
                $('.megatitle').text('Конфигурация блока');
                $('#block').fadeIn();
                
            });
        });
        $('#toadd').click(function(){
            $("input[type=submit]").show();
            let deliveryType = $('input[name=typedeliv]:checked').val();
            $.post('include/project_ajax.php',
                {
                    'do':'calc',
                    'orderid': $('input[name=orderid]').val(),
                    'size_paper': $('input[name=size]:checked').val(),
                    'pages' : $('#softpages').val(),
                    'count' : $('#softcount').val(),
                    'bind' : $('input[name=binding]:checked').val(),
                    'papertype_block': $('input[name=paperblock]:checked').val(),
                    'printtype_block': $('input[name=colorblock]:checked').val(),
                    'papertype_cover' : $('input[name=cover]').val(), 
                    'lamination' : $('input[name=lamination]:checked').val(),
                    'isbnChecked' : Boolean($('input[name=isbn]').is(':checked')),
                    'delivery_type' : deliveryType,
                    'city_id_for_CDEK' : deliveryType == 'pickup-point' ? $('#hidden_del_citytoid').val() : false,
                }, function(data) {
                    let response = JSON.parse(data);
                    let bindType = $('input[name=binding]:checked').val();
                    let bindTypeText = $('input[name=binding]:checked').siblings().text();
                    let coverType = $('input[name=binding]:checked').data('coverType');
                    let coverTitle = (coverType == 'soft' ? 'Мягкая' : 'Твёрдая');
                    
                    coverTitle = coverTitle + ' обложка'
                    $('.typeofcover').text(coverTitle);
                    $('.bind_img').attr("src", `img/bindtype_${bindType}.jpg`);

                    $('.bind_name').text(bindTypeText);

                    let lamination = $('input[name=lamination]:checked').val();
                    $('.lamination_type').text(lamination == 'matte' ? 'матовой' : 'глянцевой');

                    $('.pr_printtypeblock_name').text(response.printTypeBlockName);
                    $('.pr_papertypeblock_name').text(response.paperTypeBlockName);
                    $('.count').text($('#softcount').val());
                    $('.total').text(response.total);
                    $('.delivcost').text(response.deliveryCost);
                    $('.date-of-readiness').text(response.dateOfReadiness);










                    $('#ads input[type=checkbox]').change(function(){
                        var curtotal = parseInt($('#totslpriceor').val());
                        var addprice = 0;
                        var flag = false;
                        $('#ads input[type=checkbox]:checked').each(function(index,el){
                            if ($(el).val()==10){
                                flag = true;
                            }
                            addprice += parseInt($('#'+$(el).val()).val());
                        });
                        if (flag){
                            $('#bookstore').fadeIn();
                            $('#countdisp').text(' <16!').fadeIn();
                            $('#countdisp1').text(' (в т.ч. 16 экз. в РКП)').fadeIn();
                            $('#bookstore input').attr('checked',true);
                        }else{
                            $('#bookstore input').attr('checked',false);
                            $('#bookstore').fadeOut();
                            $('#countdisp').fadeOut();
                            $('#countdisp1').fadeOut();
                        }
                        $('#totslprice').val(addprice+curtotal);
                        $('#vpr').text(addprice+curtotal);
                    });
            }); // $.post
            
            
            $('#block').fadeOut(function(){
                $('#add').fadeIn();
                $('.megatitle').text('Стоимость печати');
            });
        });
        $('input[name=colorcover]').change(function(){
            color = $('input[name=colorblock]:checked').val();
            $('#toblock').fadeOut();
            $.post('include/project_ajax.php',{'do':'getPaperTypeCover', 'cover': $('input[name=cover]').val(),'color': color},function(data){
                $('#paperTypeCover').html(data);
                $('#paperTypeCover').fadeIn();
                $('input[name=papercover]').change(function(){
                    $('#toblock').fadeIn();
                });
            });
        });
        $('#toblock').click(function(){
            $('#cover').fadeOut(function(){
                $('.megatitle').text('Конфигурация блока');
                $('#block').fadeIn();
            });
        });
        $('input[name=colorblock]').change(function(){
            $('#toadd').hide();
            color = $('input[name=colorblock]:checked').val();
            $('#paperTypeBlock').fadeOut();
            $('#paperSizeBlock').fadeOut();
            $('#count').fadeOut();
            $('#binding').fadeOut();
            $.post('include/project_ajax.php',{'do':'getPaperTypeBlock', 'color': color}, function(data){
                $('#paperTypeBlock').html(data);
                $('#paperTypeBlock').fadeIn(function(){
                    $('input[name=paperblock]').change(function(){
                        // $('#paperSizeBlock').fadeOut();
                        $('#count').fadeOut();
                        $('#binding').fadeOut();
                        $('#toadd').fadeOut();
                        // $.post('include/project_ajax.php',{'do':'getPaperSizeBlock'},function(data){
                            // $('#paperSizeBlock').html(data);     
                            // $('#paperSizeBlock').fadeIn();
                            // $('input[name=size]').change(function(){
                                // $('#toadd').fadeOut();
                                // $('#count').fadeIn();
                                $.post('include/project_ajax.php',
                                    {
                                        'do':'getPaperTypeBind',
                                        'orderid': $('input[name=orderid]').val(),
                                        'cover': $('input[name=cover]').val(),
                                        'size_paper': $('input[name=size]:checked').val()
                                    }, 
                                    function(data){
                                        let jsonResp = JSON.parse(data);
                                        let softRes = '';
                                        let hardRes = '';
                                        
                                        // console.log(jsonResp);
                                        jsonResp.forEach(function(item, index, array) {
                                            if(item.coverType === 'soft') {
                                                softRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="soft" value="${item.bindingId}" /></td>`;
                                            } else if (item.coverType === 'hard') {
                                                hardRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="hard" value="${item.bindingId}" /></td>`;
                                            }
                                        });
                                        // $('#binding').html(data);
                                        $('#binding-soft').html(softRes);
                                        $('#binding-hard').html(hardRes);
                                        $('#binding').fadeIn();
                                        $('input[name=binding]').change(function(){
                                            $('.lamination-wrap').fadeIn();
                                            $('input[name=lamination]').change(function(){
                                                calculateMass();
                                                $('#count').fadeIn();
                                                $('#additional-services').fadeIn();


                                                
                                            });
                                        });

                                    });
                                // });
                        // });
                    });
                });
            });
        });

        // $('input[name=typedeliv]').change(function(){
        //     $('#toadd').fadeIn(); // Кнопка далее
        //     $('#pvz_cdek').fadeOut();
        //     $('#newaddress').fadeOut();
        //     $('#deliveryaddress').fadeOut();
        //     $('#providers').fadeOut();
        //     $('#deliveryaddress').select();
        //     if ($('input[name=typedeliv]:checked').val()=='pickup'){
        //         if ($('#isorg').length >0){
        //             $('#isorg').fadeIn();
        //             if ($('#isorg input[name=isorg]:checked').val()==1){
        //                     $('#deliveryaddress').fadeIn();
        //             }
        //             $('#isorg input[name=isorg]').change(function(){
        //                 if ($('#isorg input[name=isorg]:checked').val()==1){
        //                     $('#deliveryaddress').fadeIn();
        //                 }else{
        //                     $('#deliveryaddress').fadeOut();
        //                 }
        //             });
        //             // calctotal(true);
                    
        //         }
        //         else{
        //             // calctotal(true);
        //         }
        //     } else if ($('input[name=typedeliv]:checked').val()=='pickup-point') {


        //     } else {
        //         $('#selectaddress').show();
        //         $('#selectaddressbill').hide();
        //         $('#deliveryaddress').fadeIn();
        //         $('#deliveryfirm').fadeIn();
        //         if ($('#so1_addresses_sel').val()=='new'){
        //             $('#newaddress').fadeIn();
        //             $('#providers').fadeOut();
        //             $('#completeorder').fadeOut();
        //             if ($('#isorg').length >0){
        //                 $('#isorg').fadeOut();
        //             }
        //             $.post(main_file_name+'?do=orderstep2',{'do':'getregion', 'countryid':$('#so1_country_sel').val()},function(data){
        //                $('#so1_region_sel').html(data);
        //                if ($('#so1_region_sel option:selected').hasClass('iscity')){
        //                     $('#so15').val($('#so1_region_sel option:selected').text());
        //                     $('#so15_tr').hide();
        //                }
        //             });
        //         }else{
        //             // calctotal();
        //         }
        //     }
        // });

        $('input[name=count]').change( evt => {
            calculateMass();
        });

        function calculateMass() {
            $('input[name=typedeliv]').prop('disabled', true);
            console.log(window.cartWidjet.cargo.reset());
            console.log(window.cartWidjet.cargo.get());
            $.post('include/project_ajax.php',{'do':'getSessionDataForMassa'}, function(data) {
                if (data != '') {
                    // console.log(data);
                    bookData = JSON.parse(data);

                    let bookWidth = bookData.bookWidth;
                    let bookHeight = bookData.bookHeight;
                    let pageCount = bookData.pageCount;
                    let circulation = document.querySelector('input[name=count]').value;
                    let paperWeight = $('input[name=paperblock]:checked').data( "weight");
                    let massa = (paperWeight * ((bookHeight * bookWidth) / 1e+9) * circulation * (pageCount / 2 + 10)) * 1000;
                    massa = (massa / 1000.1);

                    console.log(`
                    Ширина стр: ${bookWidth}
                    Высота стр: ${bookHeight}
                    Кол-во стр: ${pageCount}
                    Тираж: ${circulation}
                    Вес стр: ${paperWeight}
                    Масса: ${massa}
                    `);
                    window.cartWidjet.cargo.add({
                        length: 25,
                        width: 17,
                        height: 7,
                        weight: massa, 
                    });
                    console.log(window.cartWidjet.cargo.get());
                }
                $('input[name=typedeliv]').prop('disabled', false);
            });
        }

        function getMass() {
            var res = false;
            $.post('include/project_ajax.php',{'do':'getSessionDataForMassa'}, function(data) {
                if (data != '') {
                    // console.log(data);
                    bookData = JSON.parse(data);

                    let bookWidth = bookData.bookWidth;
                    let bookHeight = bookData.bookHeight;
                    let pageCount = bookData.pageCount;
                    let circulation = document.querySelector('input[name=count]').value;
                    let paperWeight = $('input[name=paperblock]:checked').data( "weight");
                    let massa = (paperWeight * ((bookHeight * bookWidth) / 1e+9) * circulation * (pageCount / 2 + 10)) * 1000;
                    // massa = (massa / 1000.1);
                    console.log(massa);
                    window.massaForProviders = massa;
                }
            });
            return window.massaForProviders;
        }


        $('input[name=isbn]').change( evt => {
            let oldValue = $('#softcount').val();
            let isbnPrice = '';
            $.post('include/project_ajax.php',{'do':'getISBNprice'}, function(data) {
                if (data != '') {
                    isbnPrice = data;
                }
            });
            if (evt.target.checked) {
                $('#softcount').val(+oldValue + 16);
                // Add to total
                // $('#totslprice').val(+($('#totslprice').val()) + isbnPrice);
                // $('#vpr').text(+($('#vpr').text()) + isbnPrice );
            } else {
                $('#softcount').val(oldValue - 16);
                // Remove from total
                // $('#totslprice').val(+($('#totslprice').val()) - isbnPrice);
                // $('#vpr').text(+($('#vpr').text()) - isbnPrice );
            }
            calculateMass();
        });

        window.showPvzFields = function() {
            $('#os3_pvz_address').val(`${window.pvz.cityName}, ${window.pvz.PVZ.Address}`);
            $('#os3_delivery_price').val(window.pvz.price + ' руб.');
            $('#hidden_del_price').val(window.pvz.price);
            $('#hidden_del_citytoid').val(window.pvz.city);
            $('#pvz_cdek').fadeIn();
            // Показать итог стоимость и кнопку оплатить
            // $('#os3_providers_sel option:selected').val(2)
            $('#prwithdeliv').text(parseInt($('#totalcosts').val()) + parseInt(window.pvz.price));
            $('#os3_total').fadeIn();
            $('#completeorder').fadeIn();
        }


        $('#softpages').change(function(){
             $('#toadd').fadeOut();
             $.post('include/project_ajax.php',{'do':'getPaperTypeBind', 'pages':$('#softpages').val(),'cover': $('input[name=cover]').val()},function(data){
                $('#binding').html(data);
                $('#binding').fadeIn();
                $('input[name=binding]').change(function(){
                    $.post('include/project_ajax.php',{'do':'getPagesCorrect', 'pages':$('#softpages').val(),'bind' : $('input[name=binding]:checked').val()},function(data){
                        if (data != 0){
                            $('#softpages').css('border', '1px solid #FF0000');
                            $('#softpages').val(parseInt($('#softpages').val())+parseInt(data));
                            $('#addpages').val(parseInt(data));
                        }else{
                            $('#softpages').css('border', '');
                        }
                    });
                    $('#toadd').fadeIn();
                });
             });
        });

        $('#delivery input[name=typedeliv]').change(function(){
            $('#toadd').fadeIn(); // Кнопка далее
            $('#pvz_cdek').fadeOut();
            $('#newaddress').fadeOut();
            $('#deliveryaddress').fadeOut();
            $('#providers').fadeOut();
            $('#deliveryaddress').select();
            if ($('#delivery input[name=typedeliv]:checked').val()=='pickup'){
                if ($('#isorg').length >0){
                    $('#isorg').fadeIn();
                    if ($('#isorg input[name=isorg]:checked').val()==1){
                            $('#deliveryaddress').fadeIn();
                    }
                    $('#isorg input[name=isorg]').change(function(){
                        if ($('#isorg input[name=isorg]:checked').val()==1){
                            $('#deliveryaddress').fadeIn();
                        }else{
                            $('#deliveryaddress').fadeOut();
                        }
                    });
                    // calctotalos3(true);
                    
                }
                else{
                    // calctotalos3(true);
                }
            } else if ($('#delivery input[name=typedeliv]:checked').val()=='deliver'){
                $('#selectaddress').show();
                $('#selectaddressbill').hide();
                $('#deliveryaddress').fadeIn();
                $('#deliveryfirm').fadeIn();
                if ($('#os3_addresses_sel').val()=='new'){
                    $('#newaddress').fadeIn();
                    $('#providers').fadeOut();
                    $('#completeorder').fadeOut();
                    if ($('#isorg').length >0){
                        $('#isorg').fadeOut();
                    }
                    $.post(main_file_name+'?do=orderstep2',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
                       $('#os3_region_sel').html(data);
                       if ($('#os3_region_sel option:selected').hasClass('iscity')){
                            $('#os35').val($('#os3_region_sel option:selected').text());
                            $('#os35_tr').hide();
                       }
                    });
                }else{
                    // calctotalos3();
                }
            }
            else if ($('#delivery input[name=typedeliv]:checked').val()=='pickup-point') {
                if (window.pvz == undefined) {
                    $('#os3_total').fadeOut();
                    $('#completeorder').fadeOut();
                }
                else {
                    $('#pvz_cdek').fadeIn();
                    // $('#os3_total').fadeIn();
                    // $('#completeorder').fadeIn();

                    //Вывести итог с учетом доставки ПВЗ
                    // $('#prwithdeliv').text(parseInt($('#totalcosts').val()) + parseInt(window.pvz.price));
                }
            }
        });

        $('#os3_addresses_sel').change(function() {
            if ($(this).val()=='new'){
                $('#newaddress').fadeIn();
                $('#providers').fadeOut();
                $('#completeorder').fadeOut();
                if ($('#isorg').length >0){
                    $('#isorg').fadeOut();
                }
                $.post(main_file_name+'?do=orderstep2',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
                   $('#os3_region_sel').html(data);
                   if ($('#os3_region_sel option:selected').hasClass('iscity')){
                        $('#os35').val($('#os3_region_sel option:selected').text());
                        $('#os35_tr').hide();
                   }
                });
            } else {
                $('#newaddress').fadeOut();
                if ($('#delivery input[name=typedeliv]:checked').val()!='pickup'){
                    providersos3($(this).val());
                }else{
                    if ($('#isorg').length >0){
                        $('#isorg').fadeIn();
                    }
                }
            }
        });

        function calctotalos3(f){
            if (typeof(f)=='undefined' && $('#delivery input[name=typedeliv]:checked').val()!='pickup'){
                var tot = parseInt($('#totalcosts').val())+parseInt($('#os3_providers_sel option:selected').attr('title'));
                if (isNaN(tot)){
                    $('#prwithdeliv').text(parseInt($('#totalcosts').val()));
                    $('#completeorder').fadeOut();
                }else{
                   $('#prwithdeliv').text(tot);
                   $('#completeorder').fadeIn();
                }
            }else{
                $('#prwithdeliv').text(parseInt($('#totalcosts').val()));
                $('#completeorder').fadeIn();
            }
            $('#os3_total').fadeIn();
            if ($('#isorg').length >0){
                $('#isorg').fadeIn();
            }
        }
        function providersos3(addressid,f){
            let massa = getMass();
            $.post(main_file_name+'?do=orderstep2',{'do':'getproviders', 'addressid':addressid, 'massa': massa, 'orderid':$('#os3_orderid').val()},function(data){
                $('#providers').fadeIn();
                $('#os3_providers_sel').html(data);
                if (f!=false){
                    calctotalos3();
                }
            });
        }
})