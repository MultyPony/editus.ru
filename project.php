﻿<?php
	session_start();
	
	// foreach ($_POST as $value) {
	// 	echo $value . "\n";
	// }
	function checkAndSet() {
		$vals = [
			'author' => 'os1_author',
			'book_name' => 'os1_name',
			'pages' => 'page-count',
			'book_format_id' => 'book-size',
			'book_width' => 'book-width',
			'book_height' => 'book-height',
		];
		foreach ($vals as $key => $val) {
			if (isset($_POST[$val])) {
				$_SESSION[$key] = $_POST[$val];
			} else {
				// echo "<h1>Отсутсвует $val</h1>";
				return false;
			}
		}
		return true;
	}
	if(checkAndSet()) {
		header('Location: ' . 'book-parameters.php');
		die();
	}

	// require_once(__DIR__ . '/include/lang/funcOrderClient_lang.php');
// $s = file_get_contents('//ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . 'editus.ru');

//ПОТОМ РАСКОМЕНТ
// $s = file_get_contents('//ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
// $user = json_decode($s, true);

//$user['network'] - соц. сеть, через которую авторизовался пользователь
//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
//$user['first_name'] - имя пользователя
//$user['last_name'] - фамилия пользователя


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
	<!-- <script type="text/javascript" src="js/project.js"></script> --> <!-- Скрипт для выбора типа страниц и тд -->
	<script type="text/javascript" src="js/__project.js"></script> <!-- Мой Скрипт -->
	<script>
		$(function() {
			$('#site-navigation > ul > li').removeClass('current-menu-item').eq(1).addClass('current-menu-item')
		});
	</script>
	<style>
		.input-wrap {
			display: flex; 
			flex-direction: column
		}
		.error-empty {
			display: none;
			font-size: 14px;
			color: red;
		}
		#pdf-info {
			margin: 25px 0;
		}

		#load-error {
			margin: 0;
			margin-left: 1em;
			color: red;
		}

		#messerror {
			color: #d11111;
		}

		.flex {
			display: flex;
			align-items: center;
		}

		.black {
			background-color: #333;
		}

		/* LOADING */
		section.loading-block {
			display: flex;
    		align-items: center;
			margin: 1em 0;
		}
		.loading-text {
			margin-left: 2em;
		}

		@keyframes ldio-8024eleltpf {
			0% { transform: translate(-50%,-50%) rotate(0deg); }
			100% { transform: translate(-50%,-50%) rotate(360deg); }
		}
		.ldio-8024eleltpf div {
		position: absolute;
		width: 60px;
		height: 60px;
		border: 10px solid #db1a21;
		border-top-color: transparent;
		border-radius: 50%;
		}
		.ldio-8024eleltpf div {
		animation: ldio-8024eleltpf 1s linear infinite;
		top: 50px;
		left: 50px
		}
		.loadingio-spinner-rolling-ukqrsssj2un {
		width: 74px;
		height: 74px;
		display: inline-block;
		overflow: hidden;
		background: #ffffff;
		}
		.ldio-8024eleltpf {
		width: 100%;
		height: 100%;
		position: relative;
		transform: translateZ(0) scale(0.74);
		backface-visibility: hidden;
		transform-origin: 0 0; /* see note above */
		}
		.ldio-8024eleltpf div { box-sizing: content-box; }
		/* generated by https://loading.io/ */
	</style>
</head>

<body>
	<!-- #PAGE -->
	<div id="page" class="hfeed site">

		<?php include 'top.php'; ?>
		
		<!-- #main -->
		<section id="main" class="middle wrapper">
			<div class="row row-fluid">
				<div id="content" role="main">
					<header class="entry-header">
						<h1 class="entry-title">Загрузка блока</h1>
					</header>
					<?php include 'topmenu.php'; ?>
					<div class="blog-single readable-content">
						<fieldset id="os1">
							<legend class="orderstepname"><h2>Оформление заказа:
								<span id="nameandauthorleg">название и автор</span>
								<span id="resblockleg" style="display: none;">загрузка текста</span></h2>
							</h2>
							</legend>
							<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" style="margin: 0;">
								<div id="authorname">
									<p class="input-wrap">
										<label for="os1_name">Название книги:</label>
										<input id="os1_name" type="text" name="os1_name" placeholder="Война и мир"/>
										<span class="error-empty error-bookname">Введите название книги</span>
									</p>
									<p class="input-wrap">
										<label for="os1_author">Автор:</label>
										<input id="os1_author" type="text" name="os1_author" placeholder="Лев Толстой"/>
										<span class="error-empty error-author">Введите имя автора</span>
									</p>
									<div>
										<input type="button" class="button red" id="toresultblock" value="Далее" />
									</div>
								</div>

								<div id="resultblock" style="display: none;" >
									<p>
										Поддерживаемый формат - PDF.<br>
										Загружая PDF-файл, проверьте настройки: <strong>PDF/X-1a:2001 гарантирует качественную печать и отсутствие ошибок</strong>
										<a class="head" href="new/pdf.html" target="_blank">(требования к PDF)</a>. 
									</p>
									<!-- .entry-content -->
									<div class="entry-content">
										<p>
										<a href="template.php" class="more-link" target="_blank">Как подготовить макет книги самостоятельно?<span class="meta-nav"> →</span></a>
										</p>
									</div>
									<!-- .entry-content -->
									<div>
										<div>
											<div class="flex">
												<input type="button" class="button red" id="uploadblock" value="Загрузить блок" />
												<p id="load-error"></p>
											</div>
											<input type="file" id="uploadblock_file" accept=".pdf" style="display: none;" />
										</div>
									</div>
									<span style="display: none; cursor:pointer;" id="uploadblock_after">Загрузить повторно</span>
									
									<!-- LOADING -->
									<section class="loading-block" style="display: none;">
										<div class="loadingio-spinner-rolling-ukqrsssj2un">
											<div class="ldio-8024eleltpf">
												<div></div>
											</div>
										</div>
										<p class="loading-text">Файл загружен. Идет проверка...</p>
									</section>
									

									<p id="messerror" style="display: none;"></p>

									<table id="pdf-info" style="display: none;">
										<tr>
											<td>Размер книги: </td>
											<td style="padding-left:10px;" id="os1_booksize"></td>
										</tr>
										<tr>
											<td>Количество страниц: </td>
											<td style="padding-left:10px;" id="os1_pagenumber"></td>
										</tr>
									</table>
									<!-- <div > -->
										<!-- <a href="/book-parameters.php"> -->
											<input id="book-parameters-btn" type="submit" class="button red" value="Выбрать параметры книги" style="display: none;"/>
										<!-- </a> -->
									<!-- </div> -->
								</div>
								<input type="text" hidden name="book-size">
								<input type="text" hidden name="book-width">
								<input type="text" hidden name="book-height">
								<input type="text" hidden name="page-count">
							</form>
						</fieldset>
					</div>
				</div>
			</div>
		</section>
	<?php include 'footer.php'; ?>
	</div>
</body>

</html>