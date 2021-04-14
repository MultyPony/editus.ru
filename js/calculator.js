$(function () {

    $.post('include/project_ajax.php', { 'do': 'getPaperSizeBlock' }, function (data) {
        $('#paperSizeBlock').html(data);
        $('#paperSizeBlock').fadeIn();
        $('input[name=size]').change(function () {
            $('#volume').fadeIn();
            $('#color-block').fadeIn();
            $('input[name=colorblock]').change(function () {
                $('#paperTypeBlock').fadeOut();
                $('#show-total').fadeOut();
                $('#calculate-btn').hide();

                color = $('input[name=colorblock]:checked').val();
                $.post('include/project_ajax.php', { 'do': 'getPaperTypeBlock', 'color': color }, function (data) {
                    $('#paperTypeBlock').html(data);
                    $('#paperTypeBlock').fadeIn();

                    $('input[name=paperblock]').change(function () {

                        $.post('include/project_ajax.php', {
                            'do': 'getPaperTypeBind',
                            'pages': $('.pages').val(),
                            'size_paper': $('input[name=size]:checked').val()
                        }, function (data) {
                            let jsonResp = JSON.parse(data);
                            if (jsonResp == false) {
                                $('.no-binding').html('<h3>Крепление</h3><p>К сожалению, креплений для данного количества страниц нет</p>');
                                return;
                            }
                            let softRes = '';
                            let hardRes = '';

                            // console.log(jsonResp);
                            jsonResp.forEach(function (item, index, array) {
                                if (item.coverType === 'soft') {
                                    softRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="soft" value="${item.bindingId}" /></td>`;
                                } else if (item.coverType === 'hard') {
                                    hardRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="hard" value="${item.bindingId}" /></td>`;
                                }
                            });
                            $('#binding-soft').html(softRes);
                            $('#binding-hard').html(hardRes);
                            $('#binding').fadeIn();

                            $('input[name=binding]').change(function () {
                                $('.lamination-wrap').fadeIn();

                                $('.lamination-wrap').change(function () {
                                    $('#calculate-btn').fadeIn();
                                    $('#calculate-btn').click(function () {

                                        $.post('include/project_ajax.php',
                                            {
                                                'do': 'calculator',
                                                'size_paper': $('input[name=size]:checked').val(),
                                                'pages': $('.pages').val(),
                                                'count': $('.tirage').val(),
                                                'bind': $('input[name=binding]:checked').val(),
                                                'papertype_block': $('input[name=paperblock]:checked').val(),
                                                'printtype_block': $('input[name=colorblock]:checked').val(),
                                                'papertype_cover': $('input[name=binding]').data('coverType'),
                                            }, function (data) {
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
                                                $('.count').text($('.tirage').val());
                                                $('.total').text(response.total);
                                                $('.delivcost').text(response.deliveryCost);
                                                
                                                $('.format_name').text($('input[name=size]:checked').data('formatName'));
                                                $('.format_size_text').text($('input[name=size]:checked').data('formatSize'));
                                                $('.show-pages').text($('.pages').val());

                                                $('#block').fadeOut();

                                                $('#show-total').fadeIn();
                                                
                                            }); // $.post


                                    });
                                });
                            });
                        });


                    });
                });
            });
        });
    });


    // $('input[name=colorblock]').change(function () {
    //     $('#show-total').fadeOut();
    //     $('#calculate-btn').hide();
    //     color = $('input[name=colorblock]:checked').val();
    //     $('#paperTypeBlock').fadeOut();
    //     $('#paperSizeBlock').fadeOut();
    //     $('#count').fadeOut();
    //     $('#binding').fadeOut();
    //     $.post('include/project_ajax.php', { 'do': 'getPaperTypeBlock', 'color': color }, function (data) {
    //         $('#paperTypeBlock').html(data);
    //         $('#paperTypeBlock').fadeIn(function () {
    //             $('input[name=paperblock]').change(function () {
    //                 $('#paperSizeBlock').fadeOut();
    //                 $('#count').fadeOut();
    //                 $('#binding').fadeOut();
    //                 $('#show-total').fadeOut();
    //                 $('#calculate-btn').fadeOut();
    //                 $.post('include/project_ajax.php', { 'do': 'getPaperSizeBlock' }, function (data) {
    //                     $('#paperSizeBlock').html(data);
    //                     $('#paperSizeBlock').fadeIn();

    //                     $('input[name=size]').change(function () {
    //                         $('#show-total').fadeOut();
    //                         $('#calculate-btn').fadeOut();
    //                         $('#count').fadeIn();
    //                         $.post('include/project_ajax.php', {
    //                             'do': 'getPaperTypeBindForCalulator',
    //                             'pages': $('.pages').val(),
    //                             'size_paper': $('input[name=size]:checked').val()
    //                         }, function (data) {
    //                             let jsonResp = JSON.parse(data);
    //                             if (jsonResp == false) {
    //                                 $('.no-binding').html('<h3>Крепление</h3><p>К сожалению, креплений для данного количества страниц нет</p>');
    //                                 return;
    //                             }
    //                             let softRes = '';
    //                             let hardRes = '';

    //                             // console.log(jsonResp);
    //                             jsonResp.forEach(function (item, index, array) {
    //                                 if (item.coverType === 'soft') {
    //                                     softRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="soft" value="${item.bindingId}" /></td>`;
    //                                 } else if (item.coverType === 'hard') {
    //                                     hardRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="hard" value="${item.bindingId}" /></td>`;
    //                                 }
    //                             });
    //                             $('#binding-soft').html(softRes);
    //                             $('#binding-hard').html(hardRes);
    //                             $('#binding').fadeIn();

    //                             $('input[name=binding]').change(function () {
    //                                 $('#calculate-btn').fadeIn();
    //                             });
    //                         });
    //                     });
    //                 });
    //             });
    //         });
    //     });

    //     $('#calculate-btn').click(function () {


    //         $.post('include/project_ajax.php',
    //             {
    //                 'do': 'calculator',
    //                 'orderid': $('input[name=orderid]').val(),
    //                 'size_paper': $('input[name=size]:checked').val(),
    //                 'pages': $('.pages').val(),
    //                 'count': $('.tirage').val(),
    //                 'bind': $('input[name=binding]:checked').val(),
    //                 'papertype_block': $('input[name=paperblock]:checked').val(),
    //                 'printtype_block': $('input[name=colorblock]:checked').val(),
    //                 'papertype_cover': $('input[name=cover]').val(),
    //                 'isbnChecked': Boolean($('input[name=isbn]').is(':checked')),
    //             }, function (data) {
    //                 let response = JSON.parse(data);
    //                 $('#show-total').fadeIn();
    //                 $('#total-val').text(response.total);
    //             }); // $.post
    //     });

    // });

    $('.pages').change(function(){
        $('#show-total').fadeOut();
        $('#calculate-btn').fadeOut();
        $('.lamination-wrap').fadeOut();

        if($('#binding').css('display') !== 'none') {
            $('#binding').fadeOut();

            $.post('include/project_ajax.php', {
                'do': 'getPaperTypeBind',
                'pages': $('.pages').val(),
                'size_paper': $('input[name=size]:checked').val()
            }, function (data) {
                let jsonResp = JSON.parse(data);
                if (jsonResp == false) {
                    $('.no-binding').html('<h3>Крепление</h3><p>К сожалению, креплений для данного количества страниц нет</p>');
                    return;
                }
                let softRes = '';
                let hardRes = '';

                // console.log(jsonResp);
                jsonResp.forEach(function (item, index, array) {
                    if (item.coverType === 'soft') {
                        softRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="soft" value="${item.bindingId}" /></td>`;
                    } else if (item.coverType === 'hard') {
                        hardRes += `<td><label for="bt_${item.bindingId}"><img src="img/bindtype_${item.bindingId}.jpg" border="0" /></label><label for="bt_${item.bindingId}" >${item.bindingName}</label><input id="bt_${item.bindingId}" type="radio" name="binding" data-cover-type="hard" value="${item.bindingId}" /></td>`;
                    }
                });
                $('#binding-soft').html(softRes);
                $('#binding-hard').html(hardRes);
                $('#binding').fadeIn();

                $('input[name=binding]').change(function () {
                    $('#calculate-btn').fadeIn();
                });
            });

        }

    });
});