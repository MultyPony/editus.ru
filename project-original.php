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
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="//<?php echo $_SERVER['SERVER_NAME'];?>/new/js/jquery-1.8.3.min.js"><\/script>')
	</script>
	<script type="text/javascript" src="js/project.js"></script>
	<script>
		$(function() {
			$('#site-navigation > ul > li').removeClass('current-menu-item').eq(1).addClass('current-menu-item')
		});
	</script>
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
									if (!isset($_GET['c'])) {
								?>

										<!-- .entry-header -->
										<header class="entry-header">
											<h1 class="entry-title">Печать книги</h1>
										</header>
										<!-- .entry-header -->
										<?php include 'topmenu.php'; ?>
										<h2>Выберите переплет книги</h2>

										<div class="entry-content">
											<div class="span7">
												<table width="100%">
													<tr align="center">
														<th colspan="3">Мягкая обложка</th>
													</tr>
													<tr align="center">
														<td>
															<img src="../img/skley.jpg" title="Клеевое скрепление" alt="Клеевое скрепление"><br>Клеевое
															скрепление
														</td>
														<td>
															<img src="../img/skrep.jpg" title="Брошюровка скобой" alt="Брошюровка скобой"><br>Брошюровка
															скобой
														</td>
														<td>
															<img src="../img/pruj.jpg" title="Переплет на пружине" alt="Переплет на пружине"><br>Переплет
															на пружине
														</td>
													</tr>
													<tr align="center">
														<td colspan="3" style="border:none;"><br /><a class="button red" href="project.php?c=s">Выбрать
																мягкую обложку</a></td>
													</tr>
												</table>
											</div>
											<div class="span5">
												<table width="100%">
													<tr align="center">
														<th colspan="2">Твердая обложка</th>
													</tr>
													<tr align="center">
														<td><img src="../img/tverd.jpg" title="Скрепление с шитьем" alt="Скрепление с шитьем"><br>Скрепление с шитьем</td>
														<td><img src="../img/dust.jpg" title="Скрепление втачку" alt="Скрепление втачку"><br>Скрепление
															втачку</td>
													</tr>
													<tr align="center">
														<td colspan="2" style="border:none;"><br /><a class="button red" href="project.php?c=h">Выбрать
																твердую обложку</a></td>
													</tr>
												</table>
											</div>
										</div>
						</div>
					<?php } elseif ($_GET['c'] == 's') { ?>
						<header class="entry-header">
							<h1 class="entry-title">Печать книги</h1>
						</header>

						<?php include 'topmenu.php'; ?>

						<form name="order" method="post" action="<?php echo Main_config::$main_file_name; ?>?pj=n">
							<div class="entry-content" id="block">
								<h2>Выберите параметры книги</h2>
								<h3>Цветность блока</h3>
								<table width="100%">
									<tr align="center">
										<td>
											<label for="bblackp">
												<img src="../img/black.jpg" title="Черно-белая печать" alt="Черно-белая печать"><br>Черно-белая
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
								<div id="paperTypeBlock" style="display: none;"></div>
								<div id="paperSizeBlock" style="display: none;"></div>
								<div id="count" style="display: none;">
									<h3>Объем</h3>
									<table width="100%">
										<tr>
											<td>Количество страниц*:</td>
											<td>
												<input id="softpages" type="text" name="volume" size="6" maxlength="6" value="64" />
												<input type="hidden" id="addpages" name="addvolume" size="6" maxlength="6" value="0" />
											</td>
										</tr>
										<tr>
											<td>Тираж*:</td>
											<td><input id="softcount" type="text" name="count" size="6" maxlength="3" value="1" />
											</td>
										</tr>
									</table>
								</div>
								<div id="binding"></div>
								<br />
								<input type="button" id="topapercover" class="button" value="Назад" />
								<input id="toadd" type="button" class="button red" value="Далее" />
							</div>
							<div class="entry-content" id="add" style="display: none;">
								<div id="total"></div>
								<input type="hidden" name="cover" value="soft" />
								<input type="button" id="topaperblock" class="button" value="Пересчитать" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button red" value="Начать печать" />
							</div>
						</form>


					<?php } elseif ($_GET['c'] == 'h') { ?>

						<header class="entry-header">
							<h1 class="entry-title">Печать книги</h1>
						</header>
						<?php include 'topmenu.php'; ?>

						<form name="order" method="post" action="<?php echo Main_config::$main_file_name; ?>?pj=n">
							<div class="entry-content" id="block">
								<h2>Выберите параметры книги</h2>
								<h3>Цветность блока</h3>
								<table width="100%">
									<tr align="center">
										<td>
											<label for="bblackp">
												<img src="../img/black.jpg" title="Черно-белая печать" alt="Черно-белая печать"><br>Черно-белая
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


								<div id="paperTypeBlock" style="display: none;">
								</div>
								<div id="paperSizeBlock" style="display: none;">
								</div>
								<div id="count" style="display: none;">

									<h3>Объем</h3>
									<table width="100%">
										<tr>
											<td>Количество страниц*:</td>
											<td>
												<input id="hardpages" type="text" name="volume" size="6" maxlength="6" value="64" />
												<input type="hidden" id="addpages" name="addvolume" size="6" maxlength="6" value="0" />
											</td>
										</tr>
										<tr>
											<td>Тираж*:</td>
											<td><input id="hardcount" type="text" name="count" size="6" maxlength="3" value="1" />
											</td>
										</tr>
									</table>
								</div>
								<div id="binding">
								</div>
								<br />
								<input type="button" id="topapercover" class="button" value="Назад" />
								<input id="toadd" type="button" class="button red" value="Далее" />
							</div>
							<div class="entry-content" id="add" style="display: none;">
								<div id="total"></div>
								<input type="hidden" name="cover" value="hard" />
								<input type="button" id="topaperblock" class="button" value="Пересчитать" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button red" value="Начать печать" />

							</div>
						</form>
				<?php }
								} ?>
				<div style="margin-top: 20px;"></div>

				</article>
					</div>
				</div>
			</div>
	</div>
	</section>
	<?php include 'footer.php'; ?>

</body>

</html>