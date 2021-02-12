<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: //www.editus.ru/new/online.html'.$ref); 
exit(); 
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml"> 

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<title>Как издать свою собственную книгу</title>
<meta name="keywords" content="издать свою книгу, издать свою собственную книгу, как издать книгу">

<meta name="description" content="Издательство Эдитус знает все о том, как издать книгу. Мы будем рады поделиться своими знаниями с Вами, предложив Вам комплексное и качественное обслуживание.">

<link rel="stylesheet" type="text/css" href="css/styles.css" media="all">

<link rel="shortcut icon" href="img/favicon.ico">
</head>

<body>
<div>


<div id="left">
<div id="relative">
<a href="http://www.editus.ru"><img src="img/logo.gif" width="250" height="328" alt="Editus" border="0"></a>
<?php include 'topmenu.php';?>
</div>


<div>

<?php include 'menubook.php';?>
</div>

</div>

</div>
</div>


<div id="right">

<?php include 'mainmenu.php';?>


<h1>Как издать книгу online</h1>

<div class="text"><br /><br /><noindex>
<iframe width="560" height="315" src="//www.youtube.com/embed/YrroKqrGKz4" frameborder="0" allowfullscreen></iframe>
<br /><br />
<font style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size:30pt; color:#ff0000;">1.</font><font class="tabletitle"><strong>&nbsp&nbspРАССЧИТАЙТЕ СТОИМОСТЬ ПЕЧАТИ</strong></font>
<br><br>
<h2>Выберите обложку и переплет</h2>
<br>
<table class="infotable">
<tr height="100" align="center">
<td width="120" valign="bottom"><img src="img/skley.jpg" width="100" height="100" border="0"></td>
<td width="120" valign="bottom"><img src="img/skrep.jpg" width="100" height="100" border="0"></td>
<td width="120" valign="bottom"><img src="img/pruj.jpg" width="100" height="100" border="0"></td>
<td width="120" valign="bottom"><img src="img/tverd.jpg" width="100" height="100" border="0"></td>
<td width="120" valign="bottom"><img src="img/dust.jpg" width="100" height="100" border="0"></td>
</tr>
<tr align="center">
<td>Клеевое <br>скрепление</td>
<td>Брошюровка <br>скобой</td>
<td>Переплет <br>на пружине</td>
<td>Скрепление <br>с шитьем</td>
<td>Скрепление <br>втачку</td>
</tr>
<tr align="center">
<td colspan="3"><hr align="center" width="320" size="0"></td>
<td colspan="2"><hr align="center" width="200" size="0"></td>
</tr>
<tr align="center">
<td colspan="3">Мягкая обложка</td>
<td colspan="2">Твердая обложка</td>
</tr>
</table>
<br><br>
<h2>Выберите оформление блока</h2>
<br>
<table class="infotable">
<tr height="100" align="center">
<td width="120" valign="bottom"><img src="img/black.jpg" width="100" height="100" border="0"></td>
<td width="120" valign="bottom"><img src="img/color.jpg" width="100" height="100" border="0"></td>
</tr>
<tr align="center">
<td>Черно-белая <br>печать</td>
<td>Цветная <br>печать</td>
</tr>
</table>

<br><br>
<h2>Рекомендуемая бумага</h2>
<br>
<table class="infotable">
<tr>
<td width="200" style="padding-right:10px;"><strong>Офсетная</strong>, 80 гр/м2.<br> Плотность бумаги для принтеров. Применяется для печати книг с иллюстрациями. Благодаря большей плотности, иллюстрации меньше просвечивают на обороте листа. Высокая белизна.<br />
</td>
<td width="200" style="padding-right:10px;"><strong>Colotech</strong>, 90-120 гр/м2. <br> Суперкаландрирование (машинная прессовка) придает дополнительную гладкость и создает очень ровную структуру. Рекомендуется для подготовки наиболее престижных документов в цвете или черно-белых.
Ослепительная белизна и яркость при высоком уровне непрозрачности листа создают безупречно профессиональный вид.
</td>
<td width="200" style="padding-right:10px;"><strong>Мелованная</strong>, 130 гр/м2.<br> Высококачественная бумага, используемая для производства глянцевых журналов, презентационных каталогов, буклетов, фотоальбомов и других материалов, для которых важна яркость красок и приятный внешний вид. Дает четкие отпечатки и приятна на ощупь.<br />
</td>
</tr>
</table>

<br><br>
<h2>Формат книжных изданий</h2>
<br>
<table class="infotable">
<tr align="center">
<td width="80" valign="bottom"><img src="img/a4.png" width="27" height="41" border="0"></td>
<td width="80" valign="bottom"><img src="img/a5.png" width="19" height="29" border="0"></td>
<td width="80" valign="bottom"><img src="img/letter.png" width="27" height="39" border="0"></td>
<td width="80" valign="bottom"><img src="img/digest.png" width="18" height="31" border="0"></td>
<td width="80" valign="bottom"><img src="img/square.png" width="27" height="29" border="0"></td>
<td width="80" valign="bottom"><img src="img/pocket.png" width="15" height="23" border="0"></td>
</tr>
<tr align="center">
<td valign="top">A4</td>
<td valign="top">A5</td>
<td valign="top">Letter</td>
<td valign="top">Digest</td>
<td valign="top">Square</td>
<td valign="top">Pocket</td>
</tr>
<tr align="center" id="infotable">
<td valign="top">210 x <br>297 мм</td>
<td valign="top">148 х <br>210 мм</td>
<td valign="top">215 х<br>280 мм</td>
<td valign="top">140 х<br>220 мм</td>
<td valign="top">210 х<br>210 мм</td>
<td valign="top">120 х<br>150 мм</td>
</tr>
</table>
<br><br>
<h2>Дополнительные услуги</h2>
<br>
<table class="text">
<tr>
<td width="200"><strong>Дизайн обложки</strong>
<br><br><img src="img/books.jpg" width="119" height="100" border="0">
</td>
<td width="300"><strong>Издательский пакет</strong><br>
<br>- ISBN
<br>- классификационные индексы УДК, ББК
<br>- авторский знак
<br>
- 16 обязательных экземпляров книги в РКП (<noindex><a href="http://www.bookchamber.ru/content/for_publ/oe.html" target="_blank">Федеральный Закон "Об обязательном экземпляре документов"</a></noindex>)
</td>
</tr>
</table>

<br><br>
<br><br>
<font style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size:30pt; color:#ff0000;">2.</font><font class="tabletitle"><strong>&nbsp&nbspЗАГРУЗИТЕ ТЕКСТ</strong></font>
<br><br>
<table class="text"><tr><td width="200">
<h2>Скачайте шаблон блока Word </h2>
<br><a href="http://www.editus.ru/template.php">Как правильно подготовить<br>блок к печати</a>
</td>
<td><img src="img/arrow.gif" width="30" height="31" border="0"></td>
<td width="170">
<h2>Загрузите файл Word</h2>
<br><img src="img/ms_word.jpg" width="80" height="77" border="0">
</td>
<td><img src="img/arrow.gif" width="30" height="31" border="0"></td>
<td width="200">
<h2>Скачайте готовый к печати макет PDF</h2>
<font color="ff3300">Внимательно проверьте готовый к печати макет PDF.
<br>Внести изменения после отправки макета в печать невозможно! </font>
<br>Если Вас не устраивает макет, внесите изменения в файл Word и нажмите кнопку "Загрузить повторно".
</td></tr></table>

<br><br>
<br><br>
<font style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size:30pt; color:#ff0000;">3.</font><font class="tabletitle"><strong>&nbsp&nbspЗАГРУЗИТЕ ОБЛОЖКУ</strong></font>
<br><br>
<table class="text"><tr><td width="200">
<h2>Скачайте шаблон обложки </h2>
<br><a href="http://www.editus.ru/template.php">Как правильно подготовить<br>обложку к печати</a><br>
<p>Вы можете пропустить этот шаг. К стоимости заказа добавится стоимость дизайна обложки</p>
</td>
<td><img src="img/arrow.gif" width="30" height="31" border="0"></td>
<td width="170">
<h2>Загрузите файл обложки</h2>
<br><img src="img/cover.jpg" width="80" border="0">
</td>
<td><img src="img/arrow.gif" width="30" height="31" border="0"></td>
<td width="200">
<h2>Скачайте готовый к печати макет PDF</h2>
<font color="ff3300">Внимательно проверьте готовый к печати макет PDF.
<br>Внести изменения после отправки макета в печать невозможно! </font>
<br>Если Вас не устраивает макет, внесите изменения в файл обложки и нажмите кнопку "Загрузить повторно"
</td></tr></table>

<br><br>


<br><br>
<font style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size:30pt; color:#ff0000;">4.</font><font class="tabletitle"><strong>&nbsp&nbspВЫБЕРИТЕ СПОСОБ ОПЛАТЫ</strong></font>
<br><br>

<noindex>


<table><tr height="60">

<td style="padding-right:20px;" align="center"><img src="img/sber580.gif" height="35" border="0"></td>

<td style="padding-right:20px;" align="center"><img src="img/qiwi.gif" height="40" border="0"></td>

<td style="padding-right:20px;" valign="middle" colspan="6"><img src="img/robokassa.gif" height="25" border="0"></td>

</tr><tr>

<td style="padding-right:20px;" valign="middle" align="center"><img src="img/logo_visa.gif" height="25" border="0"></td>

<td style="padding-right:20px;" valign="middle"><img src="img/mastercard-logo.gif" height="25" border="0"></td>

<td style="padding-right:20px;" valign="middle"><img src="img/webmoney.png" height="35" border="0"></td>



<td style="padding-right:20px;" valign="middle" ><a href="https://money.yandex.ru" target="_blank"><img src="https://money.yandex.ru/img/yamoney_logo120x60.gif " alt="Я принимаю Яндекс.Деньги" title="Я принимаю Яндекс.Деньги" border="0" height="30"/></a></td>

<td style="padding-right:20px;" valign="middle"><img src="img/moneymail.jpg" height="20" border="0"></td>

<td style="padding-right:20px;" valign="middle"><img src="img/rbk.gif" height="25" border="0"></td>

<td style="padding-right:20px;" valign="middle"><img src="img/alfa.gif" height="30" border="0"></td>

<td style="padding-right:20px;" valign="middle"><img src="img/handy.png" height="25" border="0"></td>

</tr></table>
</noindex>

<br><br>

<br><br>
<font style="font-family: Palatino Linotype, Book Antiqua, Palatino, serif; font-size:30pt; color:#ff0000;">5.</font><font class="tabletitle"><strong>&nbsp&nbspПОЛУЧИТЕ ТИРАЖ</strong></font>
<br><br>


Вы можете выбрать самовывоз со <a href="map.php" target="_blank">склада</a> или закажите <a href="map.php" target="_blank">доставку</a> курьерской службой в любой населенный пункт России и зарубежом. На указанный Вами при регистрации электронный адрес будет отправлено уведомление о готовности тиража.

  <br><br> <br><p>Если у Вас возникли вопросы, Вы можете обратиться в <a href="editus.php?do=supportclient">службу технической поддержки</a> через личный кабинет.</p>
</div>

<br><br><br><a class="button" href="http://www.editus.ru/project.php" onclick="this.blur();"><span> Издать книгу on-line</span></a>
<br><br><br>
<h1>Как издать книгу - с чего начать?</h1>

<div class="text"><br><br><p>На сегодняшний день издание собственной книги – возможность, доступная каждому. Все большее количество авторов решаются на этот важный и ответственный шаг, непременно ведущий к творческому росту и самореализации. Напечатать можно что угодно: свои или чужие литературные произведения (в случае, если их содержание не перечит существующему законодательству и не нарушает чьих-то авторских прав), научные труды, а также возможно переиздание вышедшей книги ранее (репринт). </p>
<p>Тем не менее, в обществе закрепилось мнение, что <strong>издание книги</strong> – процесс сложный и на деле его осуществить без знакомств, популярности и больших денег нереально. Однако это не так. Современные технологии, доступные многим современным  издательствам, позволяют существенно упростить процедуры, которые раньше занимали много времени и средств. </p>
<p>Если же Вы решительно настроены  издать книгу, прежде чем отдавать ее в печать, стоит  заранее продумать некоторые моменты. Например, как будет выглядеть обложка книги, чтобы наиболее точно отражать суть содержания, какой необходим переплет, формат, стоит определить – ради чего вы собираетесь издаваться. Книга, рассчитанная на коммерческий оборот, должна быть особенно привлекательной, яркой и актуальной. Возможно, для этого понадобятся услуги профессионального художника. То же самое касается и иллюстраций, если таковые задуманы. Важную роль играет выбор названия будущей книги. Оно должно быть емким, отражать суть и цеплять читательское воображение. Все это позволит повысить конкурентоспособность книги на книжном рынке, ведь встречают обычно именно «по одежке». Но, даже если Вы не ставите перед собой цели успешности продаж, гораздо приятнее держать в руках свою книгу, оформленную профессионально и со вкусом. </p>
<p>Выбирая переплет книги, необходимо также учитывать цели и адресность издания. Например, книга для ребенка должна быть достаточно прочной, то есть иметь твердую обложку и плотные листы. На выбор переплета для книги, рассчитанной на взрослого читателя, в основном влияет частота будущего ее использования и фактор престижности. В твердой обложке книга выглядит солиднее, но и затрат она требует больше. При небольшом тираже (до 10 экземпляров) используется ручная сборка блока. Разумеется, это отражается на себестоимости переплета книги и итоговой цене заказа. При большем тираже сборка уже механизирована. Стоит помнить, что качество всегда требует дополнительных расходов на используемые материалы и комплектующие. Свойства бумаги влияют на прочность клеевого блока. Офсетные, газетные и книжные виды бумаг прекрасно скрепляются в клеевой блок и надежно фиксируются в нем за счет своей ворсистости. Мелованная бумага скрепляется хуже ввиду гладкости поверхности. Помимо этого, чем меньше плотность мелованной бумаги, тем лучше она держится в клеевом соединении. Сегодня в книжной печати существует девять типов переплета, каждый из которых имеет свои нюансы при изготовлении книг. Четыре из них относятся к брошюрам и книгам в мягкой обложке, а остальные пять – к изданиям в твердом переплете. Наибольшей популярностью в мире пользуется тип книжного переплета под номером №7 (или 7БЦ - скрепление с шитьем), поскольку он обладает оптимальными потребительскими качествами и высокой технологичностью изготовления. Для защиты обложки зачастую используется ламинация виниловой пленкой. Таким образом повышается ее износостойкость. Также обложки журналов или брошюр покрывают защитным либо УФ лаком. После такой обработки обложка изделия обретает полуматовый или глянцевый блеск. Защита лаков уступает пленке, но при больших тиражах влияет на удешевление продукции.</p>
<p> Относительно содержания, безусловно, книга должна быть хорошо вычитана. Для начала можно привлечь родственников или друзей, которые помогут выявить, возможно, упущенные Вами, мелкие технические недочеты. Имеет смысл обратиться к профессиональному литературному редактору и корректору.</p>
<p>Когда идея книги уже обрела четкие контуры, определена целевая аудитория и поставлены задачи – с учетом конъюнктуры рынка или без, настает время определиться с издательством. Ориентируясь на издание книги за счет коммерческого издательства, можно обречь себя на длительное ожидание и, с высокой долей вероятности, разочарование. Довольно редкий процент произведений неизвестных авторов утверждается в печать, и уж точно никто не возьмется за бесплатный выпуск малых тиражей, которые себя потом не окупят.  И здесь явное преимущество обретает издание книги за свой счет. </p>
<p>Раньше качественные книги можно было печатать только на массивных офсетных машинах, тиражом, начиная от нескольких тысяч экземпляров. Этот процесс являлся весьма затратным, и мог быть по карману только крупным компаниям. Теперь, с появлением технологии цифровой печати, при помощи которой книгу того же качества, а иногда даже и лучшего, можно печатать небольшими тиражами от нескольких экземпляров. Издание книг стало доступным по средствам самим авторам. Если Вы написали неплохую книгу, то стоит попробовать самостоятельно стать ее инвестором, издать небольшим тиражом и посмотреть, какой спрос среди читателей она получит. В случае возможного успеха коммерческие издательства  сами могут обраться к Вам с выгодными предложениями. Публикуясь за личные средства, автор получает гораздо больше прав на итоговый продукт сотрудничества, а также имеет возможность регулировать цену на свою книгу. Сам процесс подготовки к выходу книги пройдет быстро, увлекательно и под полным контролем со стороны заказчика.</p>
<p>Как издать свою собственную книгу, если цены на такие услуги в Москве высоки, а сотрудничество с издательством кажется слишком сложной процедурой? Для этого достаточно обратиться в <a href="index.php"><strong>«Эдитус»</strong></a> – мы будем рады предложить Вам профессиональное и оперативное обслуживание, в том числе и с помощью наших онлайн-сервисов. Детальные инструкции относительно того, как издать книгу, Вы найдете на этой странице. Здесь приведено описание нашего онлайн-сервиса, который позволяет выполнить верстку, загрузить готовые материалы и обложку и отправить нам заявку на печать тиража в считанные минуты. Предлагая обслуживание в режиме онлайн, мы заботимся о том, чтобы Вы могли издать свою собственную книгу так, как это будет наиболее удобным для Вас. Вам достаточно следовать предложенным ниже инструкциям – и в самые сжатые сроки Вы сможете получить необходимый Вам тираж. Таким образом «Эдитус» становится самым простым, удобным и выгодным ответом на вопрос о том, как издать книгу.</p></div>
<br><br><a class="button" href="project.php" onclick="this.blur();"><span> Издать книгу on-line</span></a>
<?php include 'footer.php';?>

</div>
</div>

</body>

</html>
