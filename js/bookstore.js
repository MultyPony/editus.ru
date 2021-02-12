$(function(){    
    var main_file_name = 'editus.php';
    $('.addtocart').click(function(e){
        e.preventDefault();
        $.post(main_file_name+'?do=addtocart&a=1',{'itemid':$(this).attr('href')},function(data){
            $('#cart').show();
            $('#carts').text(data);
        });
        if ($('#'+$(this).attr('href')+'alr').length==0){
            $(this).after('<a id="'+$(this).attr('href')+'alr" style="margin-left:15px;" href="editus.php?do=showcart" class="button"><span> Перейти в корзину </span></a>');
        }
    });
    if ($('input[name=search]').val().length==0 || $('input[name=search]').val()=='Поиск'){
        $('input[name=search]').val('Поиск').click(function(){$(this).val('')}).blur(function(){
            if ($(this).val().length==0){$(this).val('Поиск');}
        });
    }
});


