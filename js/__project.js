const bookNameSelector = '#os1_name';
const authorSelector = '#os1_author';
const nextBtnSelector = '#toresultblock';

$(function(){
    let bookName = document.querySelector(bookNameSelector);
    let author = document.querySelector(authorSelector);
    let nextBtn = document.querySelector(nextBtnSelector);

    // Проверка полей автора и книги
    $(nextBtn).click(function() {
        if (bookName.value == '' || author.value == '' ) {
            if (bookName.value == '') {
                $('.error-bookname').fadeIn();
            } else {
                $('.error-bookname').fadeOut();
            }

            if (author.value == '') {
                $('.error-author').fadeIn();
            } else {
                $('.error-author').fadeOut();
            }
        } else {
            $('#authorname').fadeOut();
            $('#nameandauthorleg').hide();
            $('#resblockleg').show();
            $('#resultblock').fadeIn();
        }
    });

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
        $.ajax({
            url: 'upload.php', // point to server-side PHP script 
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
                        $('#os1_booksize').text(response.bookSize);
                        $('#os1_pagenumber').text(response.pageNumber);
                        $('#pdf-info').fadeIn();
                        $('#book-parameters-btn').fadeIn();
                        // $('#uploadblock').css("background-color", "#333");
                        $('#uploadblock').addClass('black');
                        $('#uploadblock').removeClass('red');
                    } else {
                        console.log('Файл не прошел проверку');
                        console.log(response.error);
                    }
                }
            }
        });
    });
});