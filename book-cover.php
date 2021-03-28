<?php
    session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8" />
	<title>Заказ книг - расчет стоимости по цифровой печати</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Расчет стоимости печати книг с готовых макетов.">
	<meta name="keywords" content="печать книги, печать книг от одного экземпляра, печать книг малыми тиражами, издать книгу, напечатать книгу">
	<meta name="author" content="Editus Publishing">
	<!-- FAV and TOUCH ICONS -->
	<link rel="shortcut icon" href="../new/images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../new/images/ico/logo-144.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../new/images/ico/logo-114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../new/images/ico/logo-72.png">
	<link rel="apple-touch-icon-precomposed" href="../new/images/ico/logo-57.png">

	<!-- FONTS -->
	<link href='//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,700,100,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

	<!--[if lte IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/selectivizr-min.js"></script>
        <![endif]-->

	<!-- STYLES -->
	<link rel="stylesheet" type="text/css" media="print" href="//editus-dev.ru/new/css/grid.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/grid.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/style.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/js/google-code-prettify/prettify.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/uniform.default.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/main.css">
	<link rel="stylesheet" type="text/css" href="//editus-dev.ru/new/css/flexslider.css">
	<!-- SCRIPTS -->
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
	<!-- #PAGE -->
	<div id="page" class="hfeed site">

		<?php include 'top.php'; ?>
		<!-- #main -->
		<section id="main" class="middle wrapper">
			<div class="row row-fluid">
				<!-- #primary -->
				<div id="primary" class="site-content">
					<!-- #content -->
					<div id="content" role="main">
						<!-- .row -->
						<div class="row-fluid readable-content page">
							<!-- .hentry -->
							<article class="post hentry">

								<header class="entry-header">
									<h1 class="entry-title">Дизайн обложки</h1>
								</header>

								<?php include 'topmenu.php'; ?>

                                <div class="entry-content">
                                    <label>
                                        <input type="radio" name="cover-option" id="" value="load">
                                        Загрузить свою обложку
                                    </label>
                                    <label>
                                        <input type="radio" name="cover-option" id="" value="editor">
                                        Редактор обложки
                                    </label>
                                    <form id="load-form" method="post" action="editus.php?do=orderstep3&amp;o=149021" style="margin: 0; display: none">
                                        <p>
                                            Скачайте шаблон обложки с рассчитанными под Ваш заказ размерами, подготовьте макет согласно нашим рекомендациям и загрузите Ваш готовый файл обложки.
                                            <a class="more-link" target="_blank" href="new/cover.html"> Как подготовить макет обложки самостоятельно?
                                                <span class="meta-nav">→</span>
                                            </a>
                                        </p>
                                        <div class="alert info" id="templatecover">
                                            Загружаемое изображение должно быть в 
                                            <span style="font-weight: bold;">формате PDF с разрешением не менее 300 dpi</span></br>
                                            <span style="font-weight: bold;">Размер обложки до обреза ?</span></br>
                                            <span style="font-weight: bold;">Ширина корешка ?</span>
                                        </div>
                                                            
                                            <div>
                                                <div> 
                                                    <div style="float:left; padding-right: 20px;">
                                                        <a class="button" href="/include/get.php?uid=10857&amp;oid=149021&amp;o=covertemplate">
                                                            Cкачать шаблон
                                                        </a>
                                                    </div>
                                                <div>
                                                <div style="position: relative; display: block; overflow: hidden;">
                                                    <input type="button" class="button red" id="uploadcover" value="Загрузить обложку">
                                                    <input type="file" name="myfile" style="position: absolute; margin: 0px; padding: 0px; width: 220px; opacity: 0; top: -4.54688px; left: 458.422px;">
                                                </div>
                                            </div>
                                        </div>
                                        <p id="loading" style="display: none;">
                                            &nbsp;Подождите, идет загрузка<br>
                                            <img src="img/ajax-loader.gif" alt="Loading">
                                        </p>
                                        <!-- <p id="mess" style="">Изображение не соответствует размерам шаблона</p> -->
                                        </div>
                                        <div id="coverlayout" style="display: none;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Загруженный файл обложки:</td>
                                                        <td><a href="/include/get.php?uid=10857&amp;oid=149021&amp;o=cover">скачать</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Готовый к печати макет PDF:</td>
                                                        <td>
                                                            <a href="/include/get.php?uid=10857&amp;oid=149021&amp;o=coverlayot" target="_blank">скачать</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            <div class="alert">
                                                Для просмотра макета необходимо установить <a target="_blank" href="//get.adobe.com/reader/">Adobe Acrobat Reader</a>&nbsp;<a target="_blank" href="//get.adobe.com/reader/"><img style="height:25px; vertical-align: bottom;" src="img/get_adobe_reader.gif" alt="Adobe Reader"></a>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="hidden" value="1" name="os2_newo">
                                            <input type="hidden" value="149021" name="os2_orderid" id="os2_orderid">
                                            <input type="hidden" value="10857" name="os2_userid" id="os2_userid">
                                                        
                                            <p id="os2_agreement" style="display: none;"><input type="checkbox" name="agreement" id="os2_agreement_ch"> Я утверждаю готовый макет PDF к печати</p>
                                            
                                            <input type="submit" style="display: none;" class="button red" id="tonextstep" value="Перейти к доставке и оплате">
                                        </div>
                                    </form>
                                    <input style="display: none" type="submit" class="button red" id="" value="Проверить макеты">
                                </div> <!-- entry-content -->
                                
							</article>
						</div>	<!-- readable-content -->
					</div> <!-- id=content -->
				</div> <!-- id="primary" -->
			</div> <!-- row row-fluid -->
		</section>
	<?php include 'footer.php'; ?>
    <script>
        $('input[name=cover-option]').change(function(evt){
            $('#load-form').fadeOut();
            if (evt.target.value === 'load') {
                $('#load-form').fadeIn();
            }
        });

    </script>
</body>
</html>