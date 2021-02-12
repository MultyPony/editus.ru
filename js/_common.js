$(function(){
    var main_file_name = 'editus.php';
    if ($('#listorders').length > 0 ){
        $('#listorders').tablesorter( {headers: {5: {sorter: false}, 6: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#listarchive').length > 0 ){
        $('#listarchive').tablesorter({cssHeader: 'header'} );
    }
    if ($('#listprojects').length > 0 ){
         $.tablesorter.addParser({ 
            // set a unique id 
            id: 'my', 
            is: function(s) { 
                // return false so this parser is not auto detected 
                return false; 
            }, 
            format: function(s) { 
                // format your data for normalization 
                var t = parseInt(s);
                return t; 
            }, 
            // set type, either numeric or text 
            type: 'numeric' 
        }); 
        $('#listprojects').tablesorter( {headers: {3:{sorter:'my'}, 4: {sorter: false}, 5: {sorter: false}}, cssHeader: 'header', textExtraction: 'simple'});
        $('.editcount').dblclick(function(){
            var id = $(this).attr('id');
            var val = parseInt($('#'+id).text());
            var inp = $('<input id="'+id+'inp" type="text" style="width:15px; border:1 solid #000;" value="'+val+'" />').blur(function(){
                var newval = parseInt($('#'+id+'inp').val());
                if (newval == 0 || isNaN(newval)){
                    newval = 1;
                }
                $('#'+id).text(newval);
                if (val != newval){
                    $.post(main_file_name+'?do=listprojects&a=1',{'do':'calc','orderid':parseInt(id),'count':newval},function(data){
                        $('#'+id+'res').text(data);
                        $('#listprojects').trigger("update");
                    });
                }
            });
            $(this).html(inp);
            $('#'+id+'inp').focus().select();
//            $('#'+id+'inp').change(function(){
//                alert('chan')
//            });
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
            $('#newaddress').fadeOut();
            $('#deliveryaddress').fadeOut();
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
//                $('#completeorder').fadeIn();
//                $('#deliveryfirm').fadeOut();
//                $('#os3_providers_sel').val(0);
//                $('#selectaddress').hide();
//                $('#selectaddressbill').show();
//                if ($('#os3_addresses_sel').val()=='new'){
//                    $('#newaddress').fadeIn();
//                    $('#providers').fadeOut();
//                    $('#completeorder').fadeOut();
//                    if ($('#isorg').length >0){
//                        $('#isorg').fadeOut();
//                    }
//                    $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getregion', 'countryid':$('#os3_country_sel').val()},function(data){
//                       $('#os3_region_sel').html(data);
//                       if ($('#os3_region_sel option:selected').hasClass('iscity')){
//                            $('#os35').val($('#os3_region_sel option:selected').text());
//                            $('#os35_tr').hide();
//                       }
//                    });
                else{
                    calctotal(true);
                }
            }else{
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
                    calctotal();
                }
            }
        });
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
                    providers($(this).val());
                }else{
                    $('#completeorder').fadeIn();
                    if ($('#isorg').length >0){
                        $('#isorg').fadeIn();
                    }
                }
            }
        });
        $('#os3_providers_sel').change(function(){
            calctotal();
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
        function calctotal(f){
            if (typeof(f)=='undefined' && $('#delivery input[name=typedeliv]:checked').val()!='pickup'){
                $.post(main_file_name+'?do=orderstep3&a=1',{'do':'calc','idprovid':$('#os3_providers_sel').val(), 'totalcosts':parseFloat($('#totalcosts').val())},function(data){
                   $('#prwithdeliv').text(data);
                });
            }else{
                $.post(main_file_name+'?do=orderstep3&a=1',{'do':'calc','idprovid':-1, 'totalcosts':parseFloat($('#totalcosts').val())},function(data){
                   $('#prwithdeliv').text(data);
                });
            }
            $('#completeorder').fadeIn();
            $('#os3_total').fadeIn();
            if ($('#isorg').length >0){
                $('#isorg').fadeIn();
            }
        }
        function providers(addressid,f){
            $.post(main_file_name+'?do=orderstep3&a=1',{'do':'getproviders', 'addressid':addressid},function(data){
                $('#providers').fadeIn();
                $('#os3_providers_sel').html(data);
                if (f!=false){
                    calctotal();
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
            providers($('#os3_addresses_sel').val(),false);
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
                   providers($('#os3_addresses_sel').val(),true);
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
                        $('#os2_agreement').fadeIn();
                        $('#buttonskip').fadeOut();
                    }
                }else{
                    $('#buttonskip').fadeIn();
                    $('#mess').text(obj.errortext);
                    $('#mess').fadeIn();
                    setTimeout(function(){$('#mess').fadeOut()},6000);
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
//                if (obj.makeup != 1){
//                    $('#templatebcover').fadeIn();
//                }else{
//                    $('#templatebcover').fadeOut();
//                }
//                if (obj.edit != 1){
//                    $('#templateblock').fadeIn();
//                }else{
//                    $('#templateblock').fadeOut();
//                }
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
//                        $('#os1_totalblocks').text(obj.totalblock);
//                        $('#os1_totaladds').text(obj.totaladds);
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
//                    $('#os1_totalblocks').text(obj.totalblock);
//                    $('#os1_totaladds').text(obj.totaladds);
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
                    setTimeout(function(){$('#messerror').fadeOut()},6000);
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
//    if ($('#ecd_addresses').length >0){
//        $('#addresses').hide();
//        $('#curier').change(function(){
//            if ($(this).attr('checked')==true){
//                $('#addresses').fadeIn('fast');
//            }
//        })
//        $('#samovivoz').change(function(){
//            if ($(this).attr('checked')==true){
//                $('#addresses').fadeOut('fast');
//            }
//        });
//        $.post('index.php?do=editclientdata&a=1',{'do':'getregion', 'countryid':$('#ecd_country_sel').val()},function(data){
//               $('#ecd_region_sel').html(data);
//               alert(data)
//        });
//        $('#ecd_country_sel').change(function(){
//            if ($(this).val()!='sel'){
//               $.post('index.php?do=editclientdata&a=1',{'do':'getregion', 'countryid':$('#ecd_country_sel').val()},function(data){
//                   $('#ecd_region_sel').html(data);
//                   
//               });
//            }
//        });
//    }  
    if ($('#messid').length >0){
        setTimeout(function(){$('#messid').fadeOut()},5000);
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

});