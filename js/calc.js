/**
 * Created by minx on 14.05.15.
 */
$(document).ready(function () {
    var dimensionUnit = " мм";
	var plus = "+ ";
    var pagesMin;
    var pagesMax;
    var calcPreviewBack = $(new Image()),
        calcPreviewSpine = $(new Image()),
        calcPreviewFront = $(new Image());
    var previewCoefficient = 0.75;

    $.fn.resize = function (h, w) {
        m = Math.ceil;
        $(this).each(function () {
            $(this).css({height: h, width: w});
        })
    };

    $("#radio").buttonset().change(function () {
        setPageLimits();
        changeAnnotationImg();
        resizePreview();
    });

    $("#calcWidth").slider({
        range: "min",
        min: 90,
        max: 300,
        value: 210,
        slide: function (event, ui) {
            $("#calcWidthVal").val(ui.value + dimensionUnit);
            resizePreview();
        }
    });
    $("#calcWidthVal").val($("#calcWidth").slider("value") + dimensionUnit);

    $("#calcHeight").slider({
        range: "min",
        min: 130,
        max: 460,
        value: 297,
        slide: function (event, ui) {
            $("#calcHeightVal").val(ui.value + dimensionUnit);
            resizePreview();
        }
    });
    $("#calcHeightVal").val($("#calcHeight").slider("value") + dimensionUnit);

    //    мягкая обложка: min = 20, max = 560
    //    твердая обложка: min = 64, max = 800
    function setPageLimits() {
        var cover = $("#radio :radio:checked").attr('id');
        if (cover == 'calcSoftCover') {
            pagesMin = 20;
            pagesMax = 560;
        }
        else {
            pagesMin = 64;
            pagesMax = 800;
        }

        // проверяем и корректируем кол-во страниц при необходимости
        var currPagesVal = $("#calcPagesVal").prop("value");
        if (currPagesVal > pagesMax) {
            $("#calcPagesVal").val(pagesMax);
        }
        if (currPagesVal < pagesMin) {
            $("#calcPagesVal").val(pagesMin);
        }

        // устанавливаем новый рейндж на слайдере
        $("#calcPages").slider({
            min: pagesMin,
            max: pagesMax
        });

        // корректируем положение слайдера
        $("#calcPages").slider('value', currPagesVal);
        $("#calcPagesVal").val()
    }

    setPageLimits();
    $("#calcPages").slider({
        range: "min",
        step: 2,
        min: pagesMin,
        max: pagesMax,
        value: 400,
        slide: function (event, ui) {
            $("#calcPagesVal").val(ui.value);
            calculateSpine();
            resizePreview();
        }
    });
    $("#calcPagesVal").val($("#calcPages").slider("value"));


    $("#calcDensity").slider({
        range: "min",
        step: 10,
        min: 70,
        max: 160,
        value: 80,
        slide: function (event, ui) {
            $("#calcDensityVal").val(ui.value);
            calculateSpine();
            resizePreview();
        }
    });
    $("#calcDensityVal").val($("#calcDensity").slider("value"));

    /*
     Формула расчета корешка:
     Толщина корешка = (С*Б/1600)*1,1
     где С - количество страниц
     Б - плотность бумаги
     */

    function calculateSpine() {
        var pages = $("#calcPagesVal").prop("value");
        var density = $("#calcDensityVal").prop("value");
        //Number((6.688689).toFixed(1));
        var spine = Number(((pages * density / 1600) + 0).toFixed(0));
        $("#calcSpineVal").val(spine + dimensionUnit);
    }


    calculateSpine();
    function changeAnnotationImg() {
        var cover = $("#radio :radio:checked").attr('id');
        $('.foot').empty();
        if (cover == 'calcSoftCover') {
            calcPreviewBack.attr({
                'src': 'img/id5_soft_back.png',
                width: '400px',
                border: '1'
            }).appendTo($('#preview')).fadeIn();
            calcPreviewSpine.attr({
                'src': 'img/id5_spine.png',
                width: '40px',
                border: '1'
            }).appendTo($('#preview')).fadeIn();
            calcPreviewFront.attr({
                'src': 'img/id5_soft_front.png',
                width: '400px',
                border: '1'
            }).appendTo($('#preview')).fadeIn();
        }
        else {
            calcPreviewBack.attr({
                'src': 'img/id5_hard_back.png',
                width: '400px',
                border: '1'
            }).appendTo($('#preview')).fadeIn();
            calcPreviewSpine.attr({
                'src': 'img/id5_spine.png',
                width: '40px',
                border: '1'
            }).appendTo($('#preview')).fadeIn();
            calcPreviewFront.attr({
                'src': 'img/id5_hard_front.png',
                width: '400px',
                border: '1'
            }).appendTo($('#preview')).fadeIn();
        }
    }

    function resizePreview() {
        var h = $("#calcHeightVal").prop("value"),
            w = $("#calcWidthVal").prop("value"),
            spine = $("#calcSpineVal").prop('value').slice(0, -2) * 1;

        var cover = $("#radio :radio:checked").attr('id');
        if (cover == 'calcSoftCover') {
            // геренируем превьюшку
            var newH = Math.round(h.slice(0, -2) * previewCoefficient);
            var newW = (w.slice(0, -2) * previewCoefficient);

            //Размер макета обложки (width х height) – width = ширина х 2 + толщина корешка, height = высота.
            var modelH = Math.round(h.slice(0, -2) * 1);
            var modelW = (w.slice(0, -2) * 2) + spine;

            $("label[for = calcCoverModelBleeds]").text("Обрез со всех сторон (bleeds):");
            $("#calcCoverModelBleeds").val(plus + 3 + dimensionUnit);
            $("label[for = calcCoverModelSpineMargin]").text("");
            $("#calcCoverModelSpineMargin").val("");
        }
        else {
            // геренируем превьюшку
            var newH = Math.round(h.slice(0, -2) * previewCoefficient);
            var newW = Math.round(w.slice(0, -2) * previewCoefficient);

            //Размеры макета обложки (width х height) ) – width = ширина х 2 + 18 + толщина корешка, height = высота + 10.
            var modelH = Math.round(h.slice(0, -2) * 1 + 10);
            var modelW = Math.round(w.slice(0, -2) * 2 + 22 + spine);

            $("label[for = calcCoverModelBleeds]").text("Загибы со всех сторон (bleeds):");
            $("#calcCoverModelBleeds").val(plus + 15 + dimensionUnit);
            $("label[for = calcCoverModelSpineMargin]").text("Отставы от корешка:");
            $("#calcCoverModelSpineMargin").val(6 + dimensionUnit);
        }

        $("#calcCoverModelHeight").val(modelH + dimensionUnit);
        $("#calcCoverModelWidth").val(modelW + dimensionUnit);
        var cover = $("#radio :radio:checked").attr('id');
        if (cover == 'calcSoftCover') {
            $("#calcCoverType").val("Мягкая обложка");
        }
        else {
            $("#calcCoverType").val("Твёрдая обложка");
        }

        // геренируем превьюшку
        calcPreviewBack.resize(newH, newW);
        calcPreviewSpine.resize(newH, spine);
        calcPreviewFront.resize(newH, newW);
    }

    changeAnnotationImg();
    resizePreview();
});