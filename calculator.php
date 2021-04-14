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
	<link rel="stylesheet" type="text/css" media="print" href="new/css/grid.css">
	<link rel="stylesheet" type="text/css" href="new/css/grid.css">
	<link rel="stylesheet" type="text/css" href="new/css/style.css">
	<link rel="stylesheet" type="text/css" href="new/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="new/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="new/js/google-code-prettify/prettify.css">
	<link rel="stylesheet" type="text/css" href="new/css/uniform.default.css">
	<link rel="stylesheet" type="text/css" href="new/css/main.css">
	<link rel="stylesheet" type="text/css" href="new/css/flexslider.css">
	<!-- SCRIPTS -->
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="new/js/jquery-1.8.3.min.js"><\/script>')
	</script>
	<!-- <script type="text/javascript" src="js/project.js"></script> -->
	<script type="text/javascript" src="js/calculator.js"></script>
	<script>
		$(function() {
			$('#site-navigation > ul > li').removeClass('current-menu-item').eq(1).addClass('current-menu-item')
		});
	</script>
	<script type="text/javascript" src="cdek/widjet.js" charset="utf-8" id="ISDEKscript"></script>
	<style>
		label,
		input {
			cursor: pointer;
		}

		#binding {
			display: none;
		}

		.binding-wrap {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
		}

		.lamination-wrap {
			display: flex;
			flex-wrap: wrap;
			flex-direction: column;
			align-items: flex-start;
		}

		.lamination__input {
			margin-right: 0.5em;
		}

		#toadd {
			margin-top: 2em;
		}

		.input-num {
			width: 100px !important;
		}
	</style>
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
									<h1 class="entry-title">Калькулятор</h1>
								</header>

								<form name="order" method="post" action="">
									<div class="entry-content" id="block">


										<h2>Выберите параметры книги</h2>

										<!-- Формат бумаги -->
										<div id="paperSizeBlock" style="display: none;"></div>

										<!-- Объем -->
										<div id="volume" style="display: none;">
											<h3>Объем</h3>
											<table>
												<tr>
													<td>Введите количество страниц</td>
													<td><input class="input-num pages" type="number" min="4" max="800" value="4"></td>
												</tr>
												<tr>
													<td>Введите количество экземпляров</td>
													<td><input class="input-num tirage" type="number" value="1" min="1" max="999"></td>
												</tr>
											</table>
										</div>


										<!-- Цвет -->
										<div id="color-block" style="display: none;">
											<h3>Цветность блока</h3>
											<table width="100%">
												<tr align="center">
													<td>
														<label for="bblackp">
															<img src="/img/black.jpg" title="Черно-белая печать" alt="Черно-белая печать"><br>Черно-белая
															печать
														</label>
														<input id="bblackp" type="radio" name="colorblock" value="black" />
													</td>
													<td>
														<label for="bcolorp">
															<img src="../img/color.jpg" title="Цветная печать" alt="Цветная печать"><br>Цветная печать
														</label>
														<input id="bcolorp" type="radio" name="colorblock" value="color" />
													</td>
												</tr>
											</table>
										</div>


										<!-- Тип бумаги -->
										<div id="paperTypeBlock" style="display: none;"></div>


										<!-- Крепление (нов) -->
										<div id="binding" class="entry-content" style="display: none;">
											<h3>Выберите переплет книги</h3>
											<div class="no-binding"></div>
											<div class="binding-wrap">
												<div class="">
													<!-- span7 -->
													<table width="100%">
														<tr align="center">
															<th colspan="3">Мягкая обложка</th>
														</tr>
														<tr id="binding-soft" align="center">
															<!-- Вставл сюда -->
														</tr>
														<!-- <tr align="center">
															<td colspan="3" style="border:none;"><br />
															</td>
														</tr> -->
													</table>
												</div>
												<div class="">
													<!-- span5 -->
													<table width="100%">
														<tr align="center">
															<th colspan="2">Твердая обложка</th>
														</tr>
														<tr id="binding-hard" align="center">
															<!-- Вставл сюда -->
														</tr>
														<!-- <tr align="center">
															<td colspan="2" style="border:none;"><br />
															</td>
														</tr> -->
													</table>
												</div>
											</div>
											<p><a class="more-link" href="new/pereplet.html" target="_blank">Какой переплет выбрать?</a></p>
										</div>

										<!-- Ламинация -->
										<div class="lamination-wrap" style="display: none;">
											<h3 class="lamination__title">Ламинация</h3>
											<label class="lamination__label">
												<input class="lamination__input" type="radio" name="lamination" value="matte">Матовая
											</label>
											<label class="lamination__label">
												<input class="lamination__input" type="radio" name="lamination" value="glossy">Глянцевая
											</label>
										</div>

										<!-- Дополнительные услуги -->
										<section id="additional-services" style="display: none;">
											<h2>Дополнительные услуги</h2>
											<table id="isbn">
												<tbody>
													<tr>
														<td>
															<input type="hidden" id="10" name="10" value="2000">
															<label>
																<input type="checkbox" name="isbn" value="10"> Издательский пакет (ISBN, номера УДК, ББК, авторский знак, 16 обязательных экземпляров книги в РКП (Федеральный Закон "Об обязательном экземпляре документов") ( <a href="http://www.bookchamber.ru/oe.html" target="_blank">?</a> )
															</label>
														</td>
													</tr>
												</tbody>
											</table>
										</section>

										<input id="calculate-btn" type="button" class="button red" value="Посчитать" style="display: none; margin-top: 40px" />
									</div> <!-- id="block" -->

									<div class="entry-content" id="show-total" style="display: none;">
										<div id="total">
											<table width="100%">
												<tr>
													<td colspan="2">
														<h3 class="typeofcover"></h3>
													</td>
												</tr>
												<tr>
													<td><img class="bind_img" src="" border="0"></td>
													<td>Размер: <b><span class="format_name"></span></b> <span class="format_size_text"></span><br>
														Крепление: <span class="bind_name"></span><br>
														Обложка цветная с <span class="lamination_type"></span> ламинацией<br>
														Блок: <span class="pr_printtypeblock_name"></span>, <span class="pr_papertypeblock_name"></span>, <span class="show-pages"></span> стр.<br>
														Тираж: <b><span class="count"></span> экз. </b><br>
													</td>
												</tr>
											</table>

											<h2>Стоимость печати тиража:  <span class="label" id="vpr"><span class="total"></span></span> руб.</h2><br><br>
										</div>
										<a href="calculator.php">
											<input id="restart" type="button" class="button red" value="Начать заново" />
										</a>
									</div>
								</form>

								<div style="margin-bottom: -40px;"></div>
							</article>
						</div> <!-- readable-content -->
					</div> <!-- id=content -->
				</div> <!-- id="primary" -->
			</div> <!-- row row-fluid -->
		</section>
		<?php include 'footer.php'; ?>
</body>

</html>