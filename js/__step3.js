$(function(){

    $('#uploadblock').click(function(){
        $('#uploadblock_file').click();     
    });

    $('#uploadblock_file').change(function(evt){
        if (evt.target.value === '') return; //nothing selected
        
        let file_data = $('#uploadblock_file').prop('files')[0];
        let dotIndex = file_data.name.lastIndexOf('.');
        let fileExt = file_data.name.slice(dotIndex);

        if(file_data.type !== 'application/pdf' && fileExt !== '.pdf') {
            $('#load-error').fadeIn();
            $('#load-error').text('Неверный тип файла');
            $('#pdf-info').fadeOut();
            $('#book-parameters-btn').fadeOut();
            $('#uploadblock').removeClass('black');
            $('#uploadblock').addClass('red');
            return;
        } else {
            $('#load-error').fadeOut();
        }

        var form_data = new FormData();                  
        form_data.append('file', file_data);
        // console.log(form_data);
        
        
        $('.loading-block').show();
        $('#uploadblock').prop('disabled', true);    
        $('#uploadblock').css('cursor','not-allowed');    
        
        let orderid = $('input[name=orderid]').val();

        $.ajax({
            url: `upload.php?do=cover-upload&orderid=${orderid}`, // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
                if (php_script_response !== '') {
                    let response = JSON.parse(php_script_response); 
                    if ('success' in response) {
                        console.log('Файл прошел проверку');
                        // after all checks
                        $('#os1_booksize').text(`${response.bookSize} (${response.bookWidth}х${response.bookHeight})`);
                        $('input[name=book-size]').val(response.formatId);
                        $('input[name=book-width]').val(response.bookWidth);
                        $('input[name=book-height]').val(response.bookHeight);
                        $('#os1_pagenumber').text(response.pageCount);
                        $('input[name=page-count]').val(response.pageCount);
                        $('#pdf-info').fadeIn();
                        $('#book-parameters-btn').fadeIn();
                        // $('#uploadblock').css("background-color", "#333");
                        $('#uploadblock').addClass('black');
                        $('#uploadblock').removeClass('red');
                    } else {
                        $('#messerror').text(response.error);
                        $('#messerror').fadeIn(response.error);
                        console.log('Файл не прошел проверку');
                        console.log(response.error);
                    }
                    $('.loading-block').hide();
                    $('#uploadblock').prop('disabled', false);
                    $('#uploadblock').css('cursor','pointer'); 
                }
            }
        });
    });

});