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
	<link rel="stylesheet" type="text/css" media="print" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/grid.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/grid.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/style.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/js/google-code-prettify/prettify.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/uniform.default.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/main.css">
	<link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['SERVER_NAME'];?>/new/css/flexslider.css">
	<!-- SCRIPTS -->
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
    <script src="js/fontfaceobserver.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.css" rel="stylesheet"></link>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cover-editor.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.1/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.0/jspdf.umd.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
									<h1 class="entry-title">Редактор обложки</h1>
								</header>

								<?php include 'topmenu.php'; ?>

                                <section class="cover-editor">
                                    <div class="canvas-wrap">
                                    <div class="panel-btn">
                                        <button class="btn-remove-bg-img btn-sq btn hidden">

                                        </button>
                                        <button class="btn-remove-selected btn-sq btn hidden">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 384 384" style="enable-background:new 0 0 384 384;" xml:space="preserve">
                                            <g><g><g><path d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"/>
                                                <polygon points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333 			"/>
                                            </g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                        </svg>
                                        </button>
                                    </div>
                                    <canvas id="c"></canvas>
                                    </div>
                                    <div class="ui-wrapper">
                                    <div class="template col"></div>
                                    <div class="col">
                                        <div class="row">
                                        <div class="background-picker">
                                            <input id="bg-file-input" type="file" accept=".png, .jpg, .jpeg" hidden>
                                            <button class="btn-bg-img btn-img btn-sq btn"></button>
                                        </div>
                                        <div class="col-buttons">
                                            <div class="wrap-btn-desc">
                                            <button class="btn-add-text btn-sq btn"></button>
                                            <span class="btntext">Вставить текст</span>
                                            </div>
                                            <div class="wrap-btn-desc">
                                            <!-- <button class="btn-bg-color btn-sq btn"></button> -->
                                            <input class="btn-bg-color btn-sq btn" type="color" id="head" name="head">
                                            <span class="btntext">Цвет фона</span>
                                            </div>
                                            <div class="wrap-btn-desc">
                                            <input id="add-img-input" type="file" accept=".png, .jpg, .jpeg" hidden>
                                            <button class="btn-add-img btn-img btn-sq btn"></button>
                                            <span class="btntext">Вставить изображение</span>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="font-options">
                                        <div class="font-option">
                                            <span class="font-options-desc">Шрифт</span>
                                            <select class="ff-select" name="select"> <!--Supplement an id here instead of using 'name'-->
                                            </select>
                                        </div>
                                        <div class="size-option">
                                            <span class="font-options-desc">Размер</span>
                                            <select class="fs-select"></select>
                                        </div>
                                        <div class="color-option">
                                            <span class="font-options-desc">Цвет</span>
                                            <input class="color-input" type="color">
                                        </div>
                                        </div>
                                        <div class="save-and-clear">
                                        <button class="btn-save btn">Сохранить и продолжить</button>
                                        <button class="btn-clear-all btn">Очистить всё</button>
                                        </div> 
                                    </div>
                                    </div>
                                </section>
                                
                                <form id="img-form" method="POST">
                                    <input id="image-data" hidden name="image">
                                </form>
                                
                                </div>
							
								
							</article>
						</div>	<!-- readable-content -->
					</div> <!-- id=content -->
				</div> <!-- id="primary" -->
			</div> <!-- row row-fluid -->
		</section>
	<?php include 'footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>