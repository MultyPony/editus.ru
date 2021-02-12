$(function(){
    if ($('#usersmailer').length>0){
        $('.hideshow').click(function(e){
            e.preventDefault();
            var w = $(this).parent().attr('id');
            $('#'+w+' .mails').each(function(i,el){
                if ($(el).attr('checked')){
                    $(el).attr('checked', false);
                }else{
                    $(el).attr('checked', true);
                }
            });
        });
        $('.mess').each(function(i,el){
            $(el).click(function(e){
                e.preventDefault();
                $('#all'+$(this).attr('id')).show();
                $(this).remove();
            });
        });
        $('.mail').each(function(i,el){
            $(el).click(function(e){
                e.preventDefault();
                $('#all'+$(this).attr('id')).show();
                $(this).remove();
            });
        });
    }
    if ($('#usermenu').length>0){
        $('#usermenu li').click(function(){
            $('.showm').removeClass('showm').addClass('hidem');
            $(this).children('ul').removeClass('hidem').addClass('showm');
            $('#usermenu li').removeClass('acttab');
            $(this).addClass('acttab');
        });
    }
    if ($('#ordersshopdelivery').length > 0 ){
        $('.tab').hide();
        if ($('#activetab').val().length>1){
            $('#'+$('#activetab').val()+'-tab').show();
            $('#'+$('#activetab').val()).css({'background':'#000','color':'#fff'});
            $('.orderid').focus();
        }
        $('.but').click(function(){
            $('.tab').hide();
            $('#'+$(this).attr('id')+'-tab').show();
            $('.but').css({'background':'#FFF','color':'#000'});
            $(this).css({'background':'#000','color':'#fff'});
            $('.orderid').focus();
        });
    }
    if ($('#ordersdelivery').length > 0 ){
        $('.tab').hide();
        if ($('#activetab').val().length>1){
            $('#'+$('#activetab').val()+'-tab').show();
            $('#'+$('#activetab').val()).css({'background':'#000','color':'#fff'});
            $('.orderid').focus();
        }
        $('.but').click(function(){
            $('.tab').hide();
            $('#'+$(this).attr('id')+'-tab').show();
            $('.but').css({'background':'#FFF','color':'#000'});
            $(this).css({'background':'#000','color':'#fff'});
            $('.orderid').focus();
        });
    }
    if ($('#listuser').length > 0 ){
	$.tablesorter.addParser({
            // set a unique id
            id: 'dateParse',
            is: function(s) {
                // return false so this parser is not auto detected
                return false;
            },
            format: function(s) {
                // format your data for normalization
                var t = parseInt(s.replace(/(\d+):(\d+)+ (\d+)\.(\d+)\.(\d+)/, '$5$4$3$2$1'));
                return t;
            },
            // set type, either numeric or text
            type: 'numeric'
        });
        $('#listuser').tablesorter({headers: {3: {sorter: 'dateParse'}}});
    }
    if ($('#ordersmakeup').length > 0 ){
        $('.tab').hide();
        if ($('#activetab').val().length>1){
            $('#'+$('#activetab').val()+'-tab').show();
            $('#'+$('#activetab').val()).css({'background':'#000','color':'#fff'});
            $('#orderid').focus();
        }
        $('.but').click(function(){
            $('.tab').hide();
            $('#'+$(this).attr('id')+'-tab').show();
            $('.but').css({'background':'#FFF','color':'#000'});
            $(this).css({'background':'#000','color':'#fff'});
            $('#orderid').focus();
        });
    }
    if ($('#editisbn').length > 0 ){
        $('.tab').hide();
        if ($('#activetab').val().length>1){
            $('#'+$('#activetab').val()+'-tab').show();
            $('#'+$('#activetab').val()).css({'background':'#000','color':'#fff'});
        }
        $('.but').click(function(){
            $('.tab').hide();
            $('#'+$(this).attr('id')+'-tab').show();
            $('.but').css({'background':'#FFF','color':'#000'});
            $(this).css({'background':'#000','color':'#fff'});
        });
    }
    if ($('#orderlistsadmin').length > 0 ){
        $('#orderlistsadmin').tablesorter( {headers: {1: {sorter: false}, 2: {sorter: false}, 3: {sorter: false}, 11: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#listshopallorders').length > 0 ){
        $('#listshopallorders').tablesorter( {headers: {1: {sorter: false}, 3: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#ordersforpay').length > 0 ){
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
        $('#ordersforpay').tablesorter( {headers: {1: {sorter: false},2:{sorter:'my'},  4: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#oredersformod').length > 0 ){
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
        $('#oredersformod').tablesorter( {headers: {1: {sorter: false},2:{sorter:false},  3: {sorter: false}, 6: {sorter: false}}, cssHeader: 'header'} );
    }
    if ($('#editproviderscosts'.length > 0)){
        $.post('index.php?do=editproviderscosts&a=1',{'do':'getregion', 'countryid':$('#newcountry').val()},function(data){
            $('#newregion').html(data);
        });
        $('#newcountry').change(function(){
            $.post('index.php?do=editproviderscosts&a=1',{'do':'getregion', 'countryid':$('#newcountry').val()},function(data){
                $('#newregion').html(data);
            });
        });
    }
    if ($('#ordersformanualedit').length > 0 ){
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
        $('#ordersformanualedit').tablesorter( {headers: {1: {sorter: false},2:{sorter:false},  3: {sorter: false}, 6: {sorter: false}}, cssHeader: 'header'} );
        $('.replblock').each(function(index,el){
            $.ajax_upload(el , {
                action : 'index.php?do=ordersformanualedit&a=1',
                name : 'myfile',
                data : {
                    'orderid' : '',
                    'userid' :'',
                    'do' : "replaceblock"
                },
                onSubmit : function(file, ext) {
                    $('<div id="loadshow" style="position:fixed;right:5px; top:5px; border-radius:5px;opacity: 0.3;background:#000000; padding: 10px;">Loading...</div>').appendTo('body');
                    this.settings.data.orderid = parseInt($(this.button).attr('id'));
                    this.settings.data.userid = parseInt(($(this.button).attr('href')));
                },
                onComplete : function(file, response) {
                    if (response.length>1){
                        $('#loadshow').text(response);
                        setTimeout( function(){window.location.reload();}, 3000);
//                        alert(response);
                    }
                }
            }); 
        });
        $('.replcover').each(function(index,el){
            $.ajax_upload(el , {
                action : 'index.php?do=ordersformanualedit&a=1',
                name : 'myfile',
                data : {
                    'orderid' : '',
                    'userid' :'',
                    'do' : "replacecover"
                },
                onSubmit : function(file, ext) {
                    $('<div id="loadshow" style="position:fixed;right:5px; top:5px; border-radius:5px;opacity: 0.3;background:#000000; padding: 10px;">Loading...</div>').appendTo('body');
                    this.settings.data.orderid = parseInt($(this.button).attr('id'));
                    this.settings.data.userid = parseInt(($(this.button).attr('href')));
                },
                onComplete : function(file, response) {
                    if (response.length>1){
                        $('#loadshow').text(response);
                        setTimeout( function(){window.location.reload();}, 3000);
                        
//                        alert(response);
                    }
                }
            }); 
        });

    }
    
});
