$(function(){
    var main_file_name = 'editus.php';
    if ($('#usermenu').length>0){
        $('#usermenu li').click(function(){
            $('.showm').removeClass('showm').addClass('hidem');
            $(this).children('ul').removeClass('hidem').addClass('showm');
            $('#usermenu li').removeClass('acttab');
            $(this).addClass('acttab');
        });
    }
    if ($('#listshoporders').length > 0 ){
        $('#listshoporders').tablesorter( {headers: {3: {sorter: false}, 4: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#listorders').length > 0 ){
        $('#listorders').tablesorter( {headers: {5: {sorter: false}, 6: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#showcart').length > 0 ){
        $('#showcart').tablesorter({cssHeader: 'header', headers: {0: {sorter: false}, 3: {sorter: false}}} );
        $('.editcount').css('cursor','pointer').dblclick(function(){
            var id = $(this).attr('id');
            var val = parseInt($('#'+id).text());
            var inp = $('<input id="'+id+'inp" type="text" style="width:15px; border:1 solid #000;" value="'+val+'" />').blur(function(){
                var newval = parseInt($('#'+id+'inp').val());
                if (newval == 0 || isNaN(newval) || newval<=0){
                    newval = 1;
                }
                $('#'+id).text(newval);
                if (val != newval){
                    $.post(main_file_name+'?do=showcart&a=1',{'do':'calc','itemid':parseInt(id),'count':newval},function(data){
                        $('#'+id+'res').text(data);
                        $('#showcart').trigger("update");
                        var sum = 0;
                        $('.sum').each(function(i,el){
                            sum = sum + parseFloat($(el).text());
                        });
                        $('#sum_res').text(sum);
                    });
                }
            });
            $(this).html(inp);
            $('#'+id+'inp').focus().select();
        });
    }
    if ($('#listarchive').length > 0 ){
        $('#listarchive').tablesorter({cssHeader: 'header'} );
    }
    if ($('#listprojects').length > 0 ){
         $.tablesorter.addParser({ 
            id: 'my', 
            is: function(s) { 
                return false; 
            }, 
            format: function(s) { 
                var t = parseInt(s);
                return t; 
            }, 
            type: 'numeric' 
        }); 
        $('#listprojects').tablesorter( {headers: {3:{sorter:'my'}, 4: {sorter: false}, 5: {sorter: false}}, cssHeader: 'header', textExtraction: 'simple'});
        $('.editcount').css('cursor','pointer').dblclick(function(){
            var id = $(this).attr('id');
            var val = parseInt($('#'+id).text());
            var inp = $('<input id="'+id+'inp" type="text" style="width:15px; border:1 solid #000;" value="'+val+'" />').blur(function(){
                var newval = parseInt($('#'+id+'inp').val());
                if (newval == 0 || isNaN(newval) || newval<=0){
                    newval = 1;
                }
                $('#'+id).text(newval);
                if ((val != newval)){
                    $.post(main_file_name+'?do=listprojects&a=1',{'do':'calc','orderid':parseInt(id),'count':newval},function(data){
                        $('#'+id+'res').text(data);
                        $('#listprojects').trigger("update");
                    });
                }
            });
            $(this).html(inp);
            $('#'+id+'inp').focus().select();
        });
    }
    if ($('#os3').length >0){
        $('#os3_offer').change(function(){
            $('#deliveryaddress').fadeOut();
            if ($(this).attr('checked')==true){
                $('#delivery').fadeIn();
            }else{
                $('#delivery input[name=typedeliv]').each(function(i,el){
                    $(el).attr('checked', false);
                });
                $('#delivery').fadeOut();
                $('#completeorder').fadeOut();
                $('#os3_total').fadeOut();
                $('#deliveryfirm').fadeOut();
            }
        });
        $('#delivery input[name=typedeliv]').change(function(){
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
                    calctotalos3(true);
                    
                }
                else{
                    calctotalos3(true);
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
                    $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
                       $('#os3_region_sel').html(data);
                       if ($('#os3_region_sel option:selected').hasClass('iscity')){
                            $('#os35').val($('#os3_region_sel option:selected').text());
                            $('#os35_tr').hide();
                       }
                    });
                }else{
                    calctotalos3();
                }
            }
            else if ($('#delivery input[name=typedeliv]:checked').val()=='pickup-point') {
                if (window.pvz == undefined) {
                    $('#os3_total').fadeOut();
                    $('#completeorder').fadeOut();
                }
                else {
                    $('#pvz_cdek').fadeIn();
                    $('#os3_total').fadeIn();
                    $('#completeorder').fadeIn();

                    //Вывести итог с учетом доставки ПВЗ
                    $('#prwithdeliv').text(parseInt($('#totalcosts').val()) + parseInt(window.pvz.price));
                }
            }
        });

        window.showPvzFields = function() {
            $('#os3_pvz_address').val(`${window.pvz.cityName}, ${window.pvz.PVZ.Address}`);
            $('#os3_delivery_price').val(window.pvz.price + ' руб.');
            $('#hidden_del_price').val(window.pvz.price);
            $('#pvz_cdek').fadeIn();
            // Показать итог стоимость и кнопку оплатить
            // $('#os3_providers_sel option:selected').val(2)
            $('#prwithdeliv').text(parseInt($('#totalcosts').val()) + parseInt(window.pvz.price));
            $('#os3_total').fadeIn();
            $('#completeorder').fadeIn();
        }

        $('#os3_addresses_sel').change(function(){
            if ($(this).val()=='new'){
                $('#newaddress').fadeIn();
                $('#providers').fadeOut();
                $('#completeorder').fadeOut();
                if ($('#isorg').length >0){
                    $('#isorg').fadeOut();
                }
                $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
                   $('#os3_region_sel').html(data);
                   if ($('#os3_region_sel option:selected').hasClass('iscity')){
                        $('#os35').val($('#os3_region_sel option:selected').text());
                        $('#os35_tr').hide();
                   }
                });
            }else{
                $('#newaddress').fadeOut();
                if ($('#delivery input[name=typedeliv]:checked').val()!='pickup'){
                    providersos3($(this).val());
                }else{
                    $('#completeorder').fadeIn();
                    if ($('#isorg').length >0){
                        $('#isorg').fadeIn();
                    }
                }
            }
        });
        $('#os3_providers_sel').change(function(){
            calctotalos3();
        });
        $('#os3_region_sel').change(function(){
            if ($('#os3_region_sel option:selected').hasClass('iscity')){
                $('#os35').val($('#os3_region_sel option:selected').text());
                $('#os35_tr').fadeOut();
            }else{
                $('#ecd13').val('');
                $('#os35_tr').fadeIn();
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
            $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getproviders', 'addressid':addressid, 'orderid':$('#os3_orderid').val()},function(data){
                $('#providers').fadeIn();
                $('#os3_providers_sel').html(data);
                if (f!=false){
                    calctotalos3();
                }
            });
        }
        if ($('#os3_addresses_sel').val()=='new'){
                $('#newaddress').fadeIn();
                $('#completeorder').fadeOut();
                if ($('#isorg').length >0){
                    $('#isorg').fadeOut();
                }
                $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
                   $('#os3_region_sel').html(data);
                   if ($('#os3_region_sel option:selected').hasClass('iscity')){
                        $('#os35').val($('#os3_region_sel option:selected').text());
                        $('#os35_tr').hide();
                   }
                });
        }else{
            providersos3($('#os3_addresses_sel').val(),false);
        }
        
        $('#os3_country_sel').change(function(){
            if ($(this).val()!='sel'){
               $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
                   $('#os3_region_sel').html(data);
               });
            }
        });
        $('#saveandselnewaddress').click(function(){
            $.post(main_file_name+'?do=orderstep3&a=1',{'do':'savenewaddress',
                                                  'os3_addresscontact':$('#newaddress input[name=os3_addresscontact]').val(),
                                                  'os3_addresstelephone':$('#newaddress input[name=os3_addresstelephone]').val(),
                                                  'os3_addresscountry':$('#os3_country_sel').val(),
                                                  'os3_addressregion':$('#os3_region_sel').val(),
                                                  'os3_addressindex':$('#newaddress input[name=os3_addressindex]').val(),
                                                  'os3_addresscity':$('#newaddress input[name=os3_addresscity]').val(),
                                                  'os3_addressstr':$('#newaddress input[name=os3_addressstr]').val(),
                                                  'os3_addresshouse':$('#newaddress input[name=os3_addresshouse]').val(),
                                                  'os3_addressbuild':$('#newaddress input[name=os3_addressbuild]').val(),
                                                  'os3_addressapt':$('#newaddress input[name=os3_addressapt]').val(),
                                                  'os3_addresscomment':$('#newaddress input[name=os3_addresscomment]').val()
                                          },function(data){
                   $('#os3_addresses_sel').html(data);
                   $('#newaddress').fadeOut();
                   providersos3($('#os3_addresses_sel').val(),true);
            });
        });
        $('#os3_offer_lab').click(function(){
            $('#os3_offer_text').modal({opacity:80, overlayCss: {backgroundColor:"#cccccc"}, overlayClose:true, closeClass :"os3_offer_close"});
            $('#os3_offer_yes').click(function(){
                $('#os3_offer').attr('checked', true);
                    $('#deliveryaddress').fadeOut();
                    if ($('#os3_offer').attr('checked')==true){
                        $('#delivery').fadeIn();
                    }else{
                        $('#delivery').fadeOut();
                        $('#completeorder').fadeOut();
                        $('#os3_total').fadeOut();
                        $('#deliveryfirm').fadeOut();
                    }
            });
            $('#os3_offer_close').click(function(){
                $('#os3_offer').attr('checked', false);
                    $('#deliveryaddress').fadeOut();
                    if ($('#os3_offer').attr('checked')==true){
                        $('#delivery').fadeIn();
                    }else{
                        $('#delivery').fadeOut();
                        $('#completeorder').fadeOut();
                        $('#os3_total').fadeOut();
                        $('#deliveryfirm').fadeOut();
                    }
            });
        });
    };
    if ($('#os2').length >0){
            var oid = $('input[name=os2_orderid]').val();
            var uid = $('input[name=os2_userid]').val();
               
        $.ajax_upload($('#uploadcover'), {
            action : 'include/cover.php',
            name : 'myfile',
            data : {
                orderid : oid,
                userid : uid
            },
            onSubmit : function(file, ext) {
                $('#loading').fadeIn();
                $('#coverlayout').fadeOut();
                $('#mess').fadeOut();
                $('#os2_agreement').fadeOut();
                $('#tonextstep').fadeOut();
                $('#buttonskip').fadeOut();
                $('#os2_agreement_ch').attr('checked',false);
            },
            onComplete : function(file, response) {
                $('#loading').fadeOut();
                var obj = jQuery.parseJSON(response);
                if (obj.error == false){   
                    if (obj.skiptest==false){
                        $('#mess').text(obj.messgood);
                        $('#mess').fadeIn();
                        $('#coverlayout').fadeIn();
                        $('#os2_agreement').fadeIn();
                        $('#os2_agreement_ch').change(function(){
                            if ($(this).attr('checked')==true){
                                $('#tonextstep').fadeIn();
                            }else{
                                $('#tonextstep').fadeOut();
                            }
                        });
                        $('#buttonskip').fadeOut();
                    }else{
                        $('#mess').text(obj.messgood);
                        $('#mess').fadeIn();
                        $('#tonextstep').fadeIn();
                        $('#buttonskip').fadeOut();
                    }
                }else{
                    $('#buttonskip').fadeIn();
                    $('#mess').text(obj.errortext);
                    $('#mess').fadeIn();
//                    setTimeout(function(){$('#mess').fadeOut()},6000);
                }             
            }
        }); 
        $('#tonextstep').click(function(){
            $('#loading').fadeIn();
            $('#os2 input.button').fadeOut();
        });
    }
    if ($('#os1').length >0){

        var oid = $('input[name=os1_orderid]').val();
        var uid = $('input[name=os1_userid]').val();
        var ordcount = $('input[name=os1_count]').val();
        
        $('#toauthorname').click(function(){
            $('#resblockleg').hide();
            $('#os1_res').hide();
            $('#tonextstep').hide();
            $('#os1_agreement').attr('checked', false);
            $('#os1_agree').fadeOut();
            $('#resultblock').fadeOut(function(){
                $('#nameandauthorleg').show();
                $('#authorname').fadeIn();
            })
        });
        $('#toresultblock').click(function(){
            $('#nameandauthorleg').hide();
            $('#authorname').fadeOut(function(){
                $('#resblockleg').show();
                $('#resultblock').fadeIn();
            })
        });

        $('#editadditionalservice1 a').click(function(){
            $('#editadditionalservice1').hide();
            $('#editadditionalservice').show();
        });
        $('#additionalservice input[type=checkbox]').change(function(){
            var additional ='';
            $('#additionalservice input:checked').each(function(index,el){
                additional += ($(el).val()+':');
            });
            $.post(main_file_name+'?do=orderstep1&a=1',{'do':'updateadditionalservice', 'additional':additional, 'o':oid,'userId':uid},function(data){
                var obj = jQuery.parseJSON(data);

            });
        });
        function newbind( pages){
            $.post(main_file_name+'?do=orderstep1&a=1',{'do':'newbind', 'PageCount':pages, 'o':oid,'userId':uid},function(data){
                $('#newbindtd').html(data);
                $('#newbindtd input[name=binding]').change(function(){
                    $('#os1_userpages').css('border', '0');
                    $('#os1_curpages').css('border', '0');
                    $('#loading').fadeIn();
                    $('#os1_res').fadeOut();
                    $('#newbind').fadeOut();
                    $.post('include/doccount.php',{'do':'newstestbind', 'newbind':$('input[name=binding]:checked').val(), 'orderid' : oid,'userid' : uid},function(data){
                        $('#loading').fadeOut();
                        var obj = jQuery.parseJSON(data);
                        if (obj.error != false){
                            $('#messerror').show().text(obj.error);
                        }
                        $('#os1_res').fadeIn();
                        $('#os1_layout').attr('href', decodeURIComponent(obj.pathpdf));
                        $('#os1_countsymb').text(obj.CharacterCount);
                        $('#os1_curpages').text(obj.PageCount);
                        if (obj.pathblock != false){
                            $('#os1_uploadedblock').attr('href', decodeURIComponent(obj.pathblock));
                            $('#hidepdf').show();
                        }
                        if (obj.pf){
                            $('#os1_userpages').css('border', ' 1px solid #ff0000');
                            $('#os1_curpages').css('border', ' 1px solid #ff0000');
                            if (obj.newbind==false){
                                $('#os1_agree').fadeIn();
                            }else{
                                newbind(obj.newbind);
                            }
                        }else{
                            $('#os1_agree').fadeIn();
                        }
                    });
                });
                $('#newbind').fadeIn();
            });
        }
        $.ajax_upload($('#uploadblock'), {
            action : 'include/doccount.php',
            name : 'myfile',
            data : {
                orderid : oid,
                userid : uid,
                count : ordcount
            },
            onSubmit : function(file, ext) {
                $('#os1_userpages').css('border', '0');
                $('#os1_curpages').css('border', '0');
                $('#correctpages').hide();
                $('#loading').fadeIn();
                $('#os1_res').fadeOut();
                $('#newbind').fadeOut();
                $('#hidepdf').hide();
                $('#os1_agree').fadeOut();
            },
            onComplete : function(file, response) {
                $('#loading').fadeOut();
                var np = $('#uploadblock_after').text();
                $('#uploadblock').val(np);
                var obj = jQuery.parseJSON(response);
                if (obj.error == false){
                    $('#debug').text(obj.debug);
                    $('#os1_res').fadeIn();
                    $('#os1_layout').attr('href', decodeURIComponent(obj.pathpdf));
                    $('#os1_countsymb').text(obj.CharacterCount);
                    $('#os1_curpages').text(obj.PageCount);
                    if (obj.pathblock != false){
                        $('#os1_uploadedblock').attr('href', decodeURIComponent(obj.pathblock));
                        $('#hidepdf').show();
                    }
                    if (obj.pf){
                        $('#os1_userpages').css('border', ' 1px solid #ff0000');
                        $('#os1_curpages').css('border', ' 1px solid #ff0000');
                        $('#correctpages').show();
                        if (obj.newbind==false){
                            $('#os1_agree').fadeIn();
                            $('#os1_agreement_lab').click(function(){
                                $('#os1_agreement_text').modal({opacity:80, overlayCss: {backgroundColor:"#cccccc"}, overlayClose:true, closeClass :"os1_agreement_close"});
                                $('#os1_agreement_yes').click(function(){
                                    $('#os1_agreement').attr('checked', true);
                                    if ($('#os1_agreement').attr('checked')==true){
                                        $('#tonextstep').fadeIn();
                                    }else{
                                        $('#tonextstep').fadeOut();
                                    }
                                });
                                $('#os1_agreement_close').click(function(){
                                    $('#os1_agreement').attr('checked', false);
                                    if ($('#os1_agreement').attr('checked')==true){
                                        $('#tonextstep').fadeIn();
                                    }else{
                                        $('#tonextstep').fadeOut();
                                    }
                                    
                                });
                            });
                        }else{
                            newbind(obj.newbind);
                        }
                    }else{
                        $('#os1_agree').fadeIn();
                    }
                }else{
                    $('#messerror').show().text(obj.error);
//                    setTimeout(function(){$('#messerror').fadeOut()},30000);
                }
            }
        });
        $('#os1_agreement').change(function(){
            if ($(this).attr('checked')==true){
                $('#tonextstep').fadeIn();
            }else{
                $('#tonextstep').fadeOut();
            }
        });
        $('#tonextstep').click(function(){
            $('#loading').fadeIn();
            $('#os1 input.button').fadeOut();
        });
   } 
    if ($('#messid').length >0){
//        setTimeout(function(){$('#messid').fadeOut()},5000);
    }
    if ($('#dataclient').length >0){
        $('#ecd_addresses_sub').hide();
        $('#ecd_addresses_sel').change(function(){
            $('#ecd_addresses').submit();
        });
        edit = 0;
        if ($('#ecd19').length>0){
            edit = $('input[name=ecd_editaddress]').val();
        }
        $.post(main_file_name+'?do=editclientdata&a=1',{'do':'getregion', 'countryid':$('#ecd_country_sel').val(),'edit':edit},function(data){
            $('#ecd_region_sel').html(data);
            if ($('#ecd_region_sel option:selected').hasClass('iscity')){
                $('#ecd13').val($('#ecd_region_sel option:selected').text());
                $('#ecd13_tr').hide();
            }
        });
        $('#ecd_country_sel').change(function(){
            if ($(this).val()!='sel'){
               $.post(main_file_name+'?do=editclientdata&a=1',{'do':'getregion', 'countryid':$('#ecd_country_sel').val(),'edit':edit},function(data){
                   $('#ecd_region_sel').html(data);
               });
            }
        });
        $('#ecd_region_sel').change(function(){
            if ($('#ecd_region_sel option:selected').hasClass('iscity')){
                $('#ecd13').val($('#ecd_region_sel option:selected').text());
                $('#ecd13_tr').fadeOut();
            }else{
                $('#ecd13').val('');
                $('#ecd13_tr').fadeIn();
            }
        });
        $('#ecd0').change(function(){
            if ($(this).val()==0){
                $('.orgdata').fadeOut();
            }else{
                $('.orgdata').fadeIn();
            }
        });
    }
    if ($('#os4').length >0){
        if ($('#os4_zdes').length >0){
            $('#os4_zdes').click(function(){
                $('#qiwi').prepend('<img src="img/ajax-loader.gif" alt="Loading" /><br>');
                $.post(main_file_name+'?do=orderstep4&a=1',{'do':'resetbillqiwi', 'o':$('#os4_orderid').val()},function(data){
                    $('#qiwi').html(data);
                    $('#os4_send').click(function(){
                        $('#qiwi').prepend('<img src="img/ajax-loader.gif" alt="Loading" /><br>');
                        if ($('#os4_qiwiphone').val().length==10){
                            $.post(main_file_name+'?do=orderstep4&a=1',{'phone':$('#os4_qiwiphone').val(),'do':'createbill', 'o':$('#os4_orderid').val()},function(data){
                                $('#qiwi').html(data);
                            });
                        }
                    });
                });
            });
        }
        if ($('#os4_send').length >0){
            $('#os4_send').click(function(){
                $('#qiwi').prepend('<img src="img/ajax-loader.gif" alt="Loading" /><br>');
                if ($('#os4_qiwiphone').val().length==10){
                    $.post(main_file_name+'?do=orderstep4&a=1',{'phone':$('#os4_qiwiphone').val(),'do':'createbill', 'o':$('#os4_orderid').val()},function(data){
                        $('#qiwi').html(data);
                    });
                }
            });
        }
        
        $('.methpay').css({'opacity':0.5, 'cursor':'pointer'}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})});
        $('#sberbimg').click(function(){
            if ($('#sverb').css('display')=='none'){
                $('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'});});
                $('.meth').slideUp();
                $(this).unbind('mouseleave');
                $(this).unbind('mouseenter');
                $(this).css({'opacity': 1});
                $(this).mouseenter(function(){$('#tooltipsber').show();}).mouseleave(function(){$('#tooltipsber').hide();});
                $('#sverb').slideDown();
            }else{
                $(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'});$('#tooltipsber').show();}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});$('#tooltipsber').hide();});
                $('#sverb').slideUp();
            }
        }).mouseenter(function(){$(this).attr('title','');$('#tooltipsber').show();}).mouseleave(function(){$('#tooltipsber').hide();});
        $('#qiwiimg').click(function(){
            if ($('#qiwi').css('display')=='none'){
                $('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})});
                $('.meth').slideUp();
                $(this).unbind('mouseleave');
                $(this).unbind('mouseenter');
                $(this).css({'opacity': 1});
                $(this).mouseenter(function(){$('#tooltipqiwi').show();}).mouseleave(function(){$('#tooltipqiwi').hide();});
                $('#qiwi').slideDown();
            }else{
                $(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})});
                $('#qiwi').slideUp();
            }
        }).mouseenter(function(){$(this).attr('title','');$('#tooltipqiwi').show();}).mouseleave(function(){$('#tooltipqiwi').hide();});;
        $('#robokassaimg').click(function(){
            if ($('#robokassa').css('display')=='none'){
                $('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})});
                $('.meth').slideUp();
                $(this).unbind('mouseleave');
                $(this).unbind('mouseenter');
                $(this).css({'opacity': 1});
                $(this).mouseenter(function(){$('#tooltiprobo').show();}).mouseleave(function(){$('#tooltiprobo').hide();});
                $('#robokassa').slideDown();
            }else{
                $(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});$('.tooltip').hide();});
                $('#robokassa').slideUp();
            }
        }).mouseenter(function(e){$(this).attr('title','');$('#tooltiprobo').show();}).mouseleave(function(){$('#tooltiprobo').hide();});;
		$('#avangard-visa-mastercard-img').click(function(){
			if ($('#avangard-visa-mastercard').css('display')=='none'){
				$('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})});
				$('.meth').slideUp();
				$(this).unbind('mouseleave');
				$(this).unbind('mouseenter');
				$(this).css({'opacity': 1});
				$(this).mouseenter(function(){$('#tooltipavangard').show();}).mouseleave(function(){$('#tooltipavangard').hide();});
				$('#avangard-visa-mastercard').slideDown();
			}else{
				$(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});$('.tooltip').hide();});
				$('#avangard-visa-mastercard').slideUp();
			}
		}).mouseenter(function(e){$(this).attr('title','');$('#tooltipavangard').show();}).mouseleave(function(){$('#tooltipavangard').hide();});;
    }
    if ($('#so1').length >0){
        $('#so1_offer').change(function(){
            $('#deliveryaddress').fadeOut();
            if ($(this).attr('checked')==true){
                $('#delivery').fadeIn();
            }else{
                $('#delivery input[name=typedeliv]').each(function(i,el){
                    $(el).attr('checked', false);
                });
                $('#delivery').fadeOut();
                $('#completeorder').fadeOut();
                $('#so1_total').fadeOut();
                $('#deliveryfirm').fadeOut();
            }
        });
        $('#delivery input[name=typedeliv]').change(function(){
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
                    calctotal(true);
                    
                }
                else{
                    calctotal(true);
                }
            }else{
                $('#selectaddress').show();
                $('#selectaddressbill').hide();
                $('#deliveryaddress').fadeIn();
                $('#deliveryfirm').fadeIn();
                if ($('#so1_addresses_sel').val()=='new'){
                    $('#newaddress').fadeIn();
                    $('#providers').fadeOut();
                    $('#completeorder').fadeOut();
                    if ($('#isorg').length >0){
                        $('#isorg').fadeOut();
                    }
                    $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getregion', 'countryid':$('#so1_country_sel').val()},function(data){
                       $('#so1_region_sel').html(data);
                       if ($('#so1_region_sel option:selected').hasClass('iscity')){
                            $('#so15').val($('#so1_region_sel option:selected').text());
                            $('#so15_tr').hide();
                       }
                    });
                }else{
                    calctotal();
                }
            }
        });
        $('#so1_addresses_sel').change(function(){
            if ($(this).val()=='new'){
                $('#newaddress').fadeIn();
                $('#providers').fadeOut();
                $('#completeorder').fadeOut();
                if ($('#isorg').length >0){
                    $('#isorg').fadeOut();
                }
                $.post(main_file_name+'?do=shoporderstep1&a=1',{'do':'getregion', 'countryid':$('#so1_country_sel').val()},function(data){
                   $('#so1_region_sel').html(data);
                   if ($('#so1_region_sel option:selected').hasClass('iscity')){
                        $('#so1').val($('#so1_region_sel option:selected').text());
                        $('#so15_tr').hide();
                   }
                });
            }else{
                $('#newaddress').fadeOut();
                if ($('#delivery input[name=typedeliv]:checked').val()!='pickup'){
                    providersso1($(this).val());
                }else{
                    $('#completeorder').fadeIn();
                    if ($('#isorg').length >0){
                        $('#isorg').fadeIn();
                    }
                }
            }
        });
        $('#so1_providers_sel').change(function(){
            calctotal();
        });
        $('#so1_region_sel').change(function(){
            if ($('#so1_region_sel option:selected').hasClass('iscity')){
                $('#so15').val($('#so1_region_sel option:selected').text());
                $('#so15_tr').fadeOut();
            }else{
                $('#ecd13').val('');
                $('#so15_tr').fadeIn();
            }
        });
        function calctotal(f){
            if (typeof(f)=='undefined' && $('#delivery input[name=typedeliv]:checked').val()!='pickup'){
                var tot = parseInt($('#totalcosts').val())+parseInt($('#so1_providers_sel option:selected').attr('title'));
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
            $('#so1_total').fadeIn();
            if ($('#isorg').length >0){
                $('#isorg').fadeIn();
            }
        }
        function providersso1(addressid,f){
            $.post(main_file_name+'?do=shoporderstep1&a=1',{'do':'getproviders', 'addressid':addressid, 'orderid':$('#so1_orderid').val()},function(data){
                $('#providers').fadeIn();
                $('#so1_providers_sel').html(data);
                if (f!=false){
                    calctotal();
                }
            });
        }
        if ($('#so1_addresses_sel').val()=='new'){
                $('#newaddress').fadeIn();
                $('#completeorder').fadeOut();
                if ($('#isorg').length >0){
                    $('#isorg').fadeOut();
                }
                $.post(main_file_name+'?do=shoporderstep1&a=1',{'do':'getregion', 'countryid':$('#so1_country_sel').val()},function(data){
                   $('#so1_region_sel').html(data);
                   if ($('#so1_region_sel option:selected').hasClass('iscity')){
                        $('#so15').val($('#so1_region_sel option:selected').text());
                        $('#so15_tr').hide();
                   }
                });
        }else{
            providersso1($('#so1_addresses_sel').val(),false);
        }
        
        $('#so1_country_sel').change(function(){
            if ($(this).val()!='sel'){
               $.post(main_file_name+'?do=shoporderstep1&a=1',{'do':'getregion', 'countryid':$('#so1_country_sel').val()},function(data){
                   $('#so1_region_sel').html(data);
               });
            }
        });
        $('#saveandselnewaddress').click(function(){
            $.post(main_file_name+'?do=shoporderstep1&a=1',{'do':'savenewaddress',
                                                  'so1_addresscontact':$('#newaddress input[name=so1_addresscontact]').val(),
                                                  'so1_addresstelephone':$('#newaddress input[name=so1_addresstelephone]').val(),
                                                  'so1_addresscountry':$('#so1_country_sel').val(),
                                                  'so1_addressregion':$('#so1_region_sel').val(),
                                                  'so1_addressindex':$('#newaddress input[name=so1_addressindex]').val(),
                                                  'so1_addresscity':$('#newaddress input[name=so1_addresscity]').val(),
                                                  'so1_addressstr':$('#newaddress input[name=so1_addressstr]').val(),
                                                  'so1_addresshouse':$('#newaddress input[name=so1_addresshouse]').val(),
                                                  'so1_addressbuild':$('#newaddress input[name=so1_addressbuild]').val(),
                                                  'so1_addressapt':$('#newaddress input[name=so1_addressapt]').val(),
                                                  'so1_addresscomment':$('#newaddress input[name=so1_addresscomment]').val()
                                          },function(data){
                   $('#so1_addresses_sel').html(data);
                   $('#newaddress').fadeOut();
                   providersso1($('#so1_addresses_sel').val(),true);
            });
        });
        $('#so1_offer_lab').click(function(){
            $('#so1_offer_text').modal({opacity:80, overlayCss: {backgroundColor:"#cccccc"}, overlayClose:true, closeClass :"so1_offer_close"});
            $('#so1_offer_yes').click(function(){
                $('#so1_offer').attr('checked', true);
                    $('#deliveryaddress').fadeOut();
                    if ($('#so1_offer').attr('checked')==true){
                        $('#delivery').fadeIn();
                    }else{
                        $('#delivery').fadeOut();
                        $('#completeorder').fadeOut();
                        $('#so1_total').fadeOut();
                        $('#deliveryfirm').fadeOut();
                    }
            });
            $('#so1_offer_close').click(function(){
                $('#so1_offer').attr('checked', false);
                    $('#deliveryaddress').fadeOut();
                    if ($('#so1_offer').attr('checked')==true){
                        $('#delivery').fadeIn();
                    }else{
                        $('#delivery').fadeOut();
                        $('#completeorder').fadeOut();
                        $('#so1_total').fadeOut();
                        $('#deliveryfirm').fadeOut();
                    }
            });
        });
    };
    
    if ($('#so2').length >0){
        if ($('#so2_zdes').length >0){
            $('#so2_zdes').click(function(){
                $('#qiwi').prepend('<img src="img/ajax-loader.gif" alt="Loading" /><br>');
                $.post(main_file_name+'?do=shoporderstep2&a=1',{'do':'resetbillqiwi', 'o':$('#so2_orderid').val()},function(data){
                    $('#qiwi').html(data);
                    $('#so2_send').click(function(){
                        $('#qiwi').prepend('<img src="img/ajax-loader.gif" alt="Loading" /><br>');
                        if ($('#so2_qiwiphone').val().length==10){
                            $.post(main_file_name+'?do=shoporderstep2&a=1',{'phone':$('#so2_qiwiphone').val(),'do':'createbill', 'o':$('#so2_orderid').val()},function(data){
                                $('#qiwi').html(data);
                            });
                        }
                    });
                });
            });
        }
        if ($('#so2_send').length >0){
            $('#so2_send').click(function(){
                $('#qiwi').prepend('<img src="img/ajax-loader.gif" alt="Loading" /><br>');
                if ($('#so2_qiwiphone').val().length==10){
                    $.post(main_file_name+'?do=shoporderstep2&a=1',{'phone':$('#so2_qiwiphone').val(),'do':'createbill', 'o':$('#so2_orderid').val()},function(data){
                        $('#qiwi').html(data);
                    });
                }
            });
        }
        
        $('.methpay').css({'opacity':0.5, 'cursor':'pointer'}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})});
        $('#sberbimg').click(function(){
            if ($('#sverb').css('display')=='none'){
                $('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'});});
                $('.meth').slideUp();
                $(this).unbind('mouseleave');
                $(this).unbind('mouseenter');
                $(this).css({'opacity': 1});
                $(this).mouseenter(function(){$('#tooltipsber').show();}).mouseleave(function(){$('#tooltipsber').hide();});
                $('#sverb').slideDown();
            }else{
                $(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'});$('#tooltipsber').show();}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});$('#tooltipsber').hide();});
                $('#sverb').slideUp();
            }
        }).mouseenter(function(){$(this).attr('title','');$('#tooltipsber').show();}).mouseleave(function(){$('#tooltipsber').hide();});
        $('#qiwiimg').click(function(){
            if ($('#qiwi').css('display')=='none'){
                $('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})});
                $('.meth').slideUp();
                $(this).unbind('mouseleave');
                $(this).unbind('mouseenter');
                $(this).css({'opacity': 1});
                $(this).mouseenter(function(){$('#tooltipqiwi').show();}).mouseleave(function(){$('#tooltipqiwi').hide();});
                $('#qiwi').slideDown();
            }else{
                $(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})});
                $('#qiwi').slideUp();
            }
        }).mouseenter(function(){$(this).attr('title','');$('#tooltipqiwi').show();}).mouseleave(function(){$('#tooltipqiwi').hide();});;
        $('#robokassaimg').click(function(){
            if ($('#robokassa').css('display')=='none'){
                $('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})});
                $('.meth').slideUp();
                $(this).unbind('mouseleave');
                $(this).unbind('mouseenter');
                $(this).css({'opacity': 1});
                $(this).mouseenter(function(){$('#tooltiprobo').show();}).mouseleave(function(){$('#tooltiprobo').hide();});
                $('#robokassa').slideDown();
            }else{
                $(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});$('.tooltip').hide();});
                $('#robokassa').slideUp();
            }
        }).mouseenter(function(e){$(this).attr('title','');$('#tooltiprobo').show();}).mouseleave(function(){$('#tooltiprobo').hide();});;
		$('#avangard-visa-mastercard-img').click(function(){
			if ($('#avangard-visa-mastercard').css('display')=='none'){
				$('.methpay').css({'opacity':0.5, 'border-bottom': '0'}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'})}).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})});
				$('.meth').slideUp();
				$(this).unbind('mouseleave');
				$(this).unbind('mouseenter');
				$(this).css({'opacity': 1});
				$(this).mouseenter(function(){$('#tooltipavangard').show();}).mouseleave(function(){$('#tooltipavangard').hide();});
				$('#avangard-visa-mastercard').slideDown();
			}else{
				$(this).mouseenter(function(){$(this).css({'opacity':1,'border-bottom': '2px #EE0000 solid'})}).mouseleave(function(){$(this).css({'opacity':0.5,'border-bottom': '0'});$('.tooltip').hide();});
				$('#avangard-visa-mastercard').slideUp();
			}
		}).mouseenter(function(e){$(this).attr('title','');$('#tooltipavangard').show();}).mouseleave(function(){$('#tooltipavangard').hide();});;
    }
    
    
    
    

});