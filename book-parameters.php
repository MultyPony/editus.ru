<?php
// $s = file_get_contents('//ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . 'editus.ru');

//ПОТОМ РАСКОМЕНТ
// $s = file_get_contents('//ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
// $user = json_decode($s, true);

//$user['network'] - соц. сеть, через которую авторизовался пользователь
//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
//$user['first_name'] - имя пользователя
//$user['last_name'] - фамилия пользователя


session_start();
$logopath = '';
if (isset($_SESSION['myPartnerId'])) {
	$logopath = './partner_logo/logo_' . $_SESSION['userId'] . '.jpg';
} else {
	if (isset($_SESSION['partnerId']) && $_SESSION['partnerId'] != 0) {
		$logopath = './partner_logo/logo_' . $_SESSION['partnerId'] . '.jpg';
	} else {
		$logopath = './img/logo.gif';
	}
}
require_once './config.inc.php';
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
	<script type="text/javascript" src="js/project.js"></script>
	<script>
		$(function() {
			$('#site-navigation > ul > li').removeClass('current-menu-item').eq(1).addClass('current-menu-item')
		});
	</script>
	<script type="text/javascript" src="cdek/widjet.js" charset="utf-8" id="ISDEKscript"></script>
	<style>
		label, input {
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

								<?php
									if (Main_config::$serviceoff != 1 || isset($_SESSION['admin'])) {
								?>

								<header class="entry-header">
									<h1 class="entry-title">Печать книги</h1>
								</header>

								<?php include 'topmenu.php'; ?>

								<form name="order" method="post" action="<?php echo Main_config::$main_file_name; ?>?pj=n">
									<div class="entry-content" id="block">
										<h2>Выберите параметры книги</h2>
										<h3>Цветность блока</h3>

										<!-- Цвет -->
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

										<!-- Тип бумаги -->
										<div id="paperTypeBlock" style="display: none;"></div>


										<!-- Крепление (нов) -->
										<div id="binding" class="entry-content">
											<h3>Выберите переплет книги</h3>
											<div class="binding-wrap">
												<div class=""> <!-- span7 -->
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
												<div class=""> <!-- span5 -->
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
										
										<!-- Тираж -->
										<div id="count" style="display: none;">
											<h3>Объем</h3>
											<table width="100%">
												<tr>
													<td>Тираж*:</td>
													<td><input id="softcount" type="text" name="count" size="6" maxlength="3" value="1" />
													</td>
												</tr>
											</table>
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

											<div  id="delivery" class="validate-form">
													<h5>Тип доставки</h5>
													<label class="inline-label">
														<input type="radio" name="typedeliv" value="pickup" /> Самовывоз
													</label>
													<label class="inline-label">
														<input type="radio" name="typedeliv" value="deliver" /> Доставка
													</label>
													<label class="inline-label cdek-label">
														<input type="radio" name="typedeliv" value="pickup-point" onclick='window.cartWidjet.open()'/> Пункт самовывоза
													</label>
											</div>

											<!-- Поля для СДЭК -->
											<div id="pvz_cdek" style="display: none;">
												<div>
													<table width="100%">
														<tbody>
															<tr>
																<td style="text-align: right; width:35%">
																	<span id="show_pvz_address">Адрес ПВЗ:</span>
																</td>
																<td style="text-align: left; vertical-align: middle;">
																	<input id="os3_pvz_address" type="text" name="os3_pvz_address" readonly>
																</td>
															</tr>
															<tr>
																<td style="text-align: right; width:35%">
																	<span id="show_delivery_price">Стоимость доставки:</span>
																</td>
																<td style="text-align: left; vertical-align: middle;">
																	<input id="os3_delivery_price" type="text" readonly>
																	<input id="hidden_del_price" type="hidden" value="0" name="os3_delivery_price"/>
																	<input id="hidden_del_citytoid" type="hidden" value="0" name="os3_delivery_citytoid"/>
																</td>
															</tr>
														</tbody>
													</table>
												</div>             
											</div>

											
										</section>
										
										<!-- <input type="button" id="topapercover" class="button" value="Назад" /> -->
										<input id="toadd" type="button" class="button red" value="Далее" />
									</div> <!-- id="block" -->

									<div class="entry-content" id="add" style="display: none;">
										<div id="total"></div>
										<input type="hidden" name="cover" value="soft" />
										<input type="button" id="topaperblock" class="button" value="Пересчитать" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button red" value="Перейти к дизайну обложки" />
									</div>

									<input type="text" hidden name="book-width" value="<?php echo $_SESSION['book_width'] ?>">
									<input type="text" hidden name="book-height" value="<?php echo $_SESSION['book_height'] ?>">	
									<input type="text" hidden name="volume" value="<?php echo $_SESSION['pages'] ?>">	
									<input type="text" hidden name="size" value="<?php echo $_SESSION['book_format_id'] ?>">	
								</form>			
							
								<?php //}
									} ?>
								<div style="margin-top: 20px;"></div>
							</article>
						</div>	<!-- readable-content -->
					</div> <!-- id=content -->
				</div> <!-- id="primary" -->
			</div> <!-- row row-fluid -->
		</section>
	<?php include 'footer.php'; ?>

	<script type="text/javascript">
        window.cartWidjet = new ISDEKWidjet({
            defaultCity: 'auto',
            cityFrom: 'Москва',
            hidedelt: true,
            popup: true,
            onChoose: function(wat) {
                window.pvz = wat;
                window.showPvzFields();

            },
        });
    </script>

</body>
</html>