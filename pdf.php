﻿<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: //editus.ru/new/pdf.html'.$ref); 
exit(); 
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="//www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<title>Как подготовить книгу к печати</title>
<meta name="keywords" content="подготовка макета, как сделать макет книги">

<meta name="description" content="Издательство Эдитус. Печать книг и подготовка макетов книги к печати.">

<link rel="stylesheet" type="text/css" href="css/styles.css" media="all">

<link rel="shortcut icon" href="img/favicon.ico">
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
 
<link href="css/lightbox.css" rel="stylesheet" />
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox.js"></script>   
<script type="text/javascript" src="js/jquery.simplemodal.1.4.1.min.js"></script>
    
<script type="text/javascript">
        <!--
        $(function(){
            $('.contactmail').click(function(e){
                e.preventDefault();
                var src = "./contactmail.php";
                $.modal('<iframe src="' + src + '" height="450" width="550" style="border:0">', {
                        opacity:80,
                        overlayCss: {backgroundColor:"#cccccc"},
                        containerCss:{
                                backgroundColor:"#ffffff",
                                border:"8px solid #444",
                                padding:"12px",
                                margin: "0 auto"
                        },
                        overlayClose:true
                });
            });
        });
        //-->
    </script>
</head>

<body>
<div>


<div id="left">
<div id="relative">
<a href="//editus.ru"><img src="img/logo.gif" width="250" height="328" alt="Editus" border="0"></a>
<?php include 'topmenu.php';?>
</div>


<div>

<?php include 'menumaket.php';?>
<div style="text-align:right;">
<img src="img/client.jpg" style="padding-top:80px;"/>
<a href="contact.php" class="head">Не уверены, что все сделали правильно? Приходите к нам! Мы предоставим Вам рабочее место и дадим необходимые консультации абсолютно БЕСПЛАТНО!!!</a>
</div>
</div>
</div>


<div id="right">

<?php include 'mainmenu.php';?>

<h1>Технические требования</h1>

<br /><br /><br />
<div class="text">
<p class="head">Внимание!</p>
<p><strong>Данная информация предназначена для тех, кто верстает макеты в профессиональных издательских программах!</strong> Если Вы готовите макет в Word, то Вам <a class="head" href="template.php">сюда &rarr;</a></p>
<p>При приеме макетов осуществляется автоматическая проверка файлов,  которая выявляет не все перечисленные ниже ошибки. В связи с этим мы не гарантируем их стопроцентное отслеживание.</p>
<p>Макеты,  не соответствующие данным требованиям,  могут быть доработаны без согласования с заказчиком.</p>
<p>При возникновении брака ввиду несоблюдения технических требований, вся ответственность ложится на сторону, предоставившую некорректный макет.</p>
<p>Гарантированный срок хранения предоставленной вёрстки, PostScript- и PDF-файлов – 12 месяцев.</p>
<br /><br />
<h2>Электронные носители</h2>
<ul>
<li>CD-, DVD-диски или любые накопители c USB-интерфейсом; </li>
<li>Макеты (ссылки на макеты) можно отправить по электронной почте <a href="mailto:zakaz@editus.ru">zakaz@editus.ru</a>;</li>
<li>Мы не принимаем самораспаковывающиеся архивы (расширение .exe). </li>
</ul>

<h2>Форматы файлов</h2>
<ul>
<li>PDF с внедренными шрифтами PDF/X-1a:2001;  </li>
<li>TIF-файлы (не рекомендуется для изображений, содержащих элементы малого размера, в т.ч. мелкий текст). <em>Не принимается отдельными файлами для печати многостраничной продукции!</em>; </li>
<li>Adobe® Illustrator®;</li> 
<li>Adobe® InDesign®. </li>
</ul>
<h2>PS- и PDF-файлы</h2>
<ul>
<li>Печатный файл должен быть постраничный; </li>
<li>PS- и PDF-файл нужно сохранять без цветового профиля (ICC Profile),  т.е.  опция  «внедрить цветовой профиль»  должна была отключена;</li>
<li>Настройки при выводе PDF – <strong>PDF/X-1a:2001</strong>. Издательство не несет ответственности за возможное несоответствие с макетом при выводе печати PDF с другими настройками!</li>
</ul>
<h2>Общие правила вёрстки</h2>
<ul>
<li>Размер документа должен быть равен послеобрезному формату книги. Верстка должна быть постраничной в одном файле. </li>
<li>Выборочный лак, конгрев, тиснение и т.п. должны быть в векторном виде, окрашены в 100% чёрного и сохранены как отдельный файл, дополнительно необходимо предоставить файл с их точным расположением в макете, куда они наносятся. </li>
<li>Если какой-либо элемент верстки вплотную подходит к краю, то он должен быть выпущен за обрез. Вынос за обрезной формат должен быть не менее 3 мм. </li>
<li>Располагайте значимую информацию не ближе 5 мм от линии реза или сгиба. Значимые элементы на твердой обложке рекомендуется располагать не ближе 15 мм от сгиба листа. Учитывайте отступ от корешка: при скреплении шитьем - 4 мм; при креплении втачку - 15 мм. <a href="shablon.php#calc">Рассчитать размеры разворота обложки</a></li>
<li>Количество страниц не должно превышать: 
при твердом переплете - 800 стр.;
при мягком переплете - 560 стр.</li>

</ul>

<h2>Красочность и оверпринты</h2>
<ul>
<li>Все объекты должны быть в CMYK (исключение - печать по Pantone).  Использование RGB и других цветовых моделей приведёт к искажению цвета. </li>
<li>Сумма красок не должна превышать 330%. В противном случае возможно небольшое искажение цвета. </li>
<li>Процент содержания каждой краски должен быть не менее 5%. </li>
<li>Крупные по площади чёрные объекты красьте глубоким чёрным (c25 m20 y20 k100). Никогда не окрашивайте в составной чёрный мелкий текст. </li>
<li>Необходимо представлять себе действие опции «overprint» (наложение одного цвета поверх другого);  если эта опция необходима, следует информировать об этом менеджера, в противном случае в макете не должно быть оверпринтов. По умолчанию все векторные объекты, окрашенные в 100% чёрного, печатаются поверх других красок (оверпринт на чёрном включен), со всех остальных объектов оверпринт снимается. </li>
<li>Проследите,  чтобы под крупными по площади чёрными векторными объектами не было объектов другого цвета,  или покрасьте их в глубокий чёрный. В противном случае они могут проступить из-под чёрной краски. </li>
</ul>
<h2>Растровые форматы и связанные с макетом файлы (линки)</h2>
<ul>
<li>Разрешение картинок должно лежать в диапазоне 260–350dpi.  Мы оставляем за собой право уменьшить избыточное разрешение до 300dpi. </li>
<li>Запрещается использовать OLE-объекты  (таблицы Excel, текст из Word, картинки, скопированные через клипборд (ctrl+c / ctrl+v) в вёрстку). </li>
<li>Все связанные с макетом файлы должны быть собраны в одну папку; эта же папка должна содержать файл верстки. </li>
<li>Нельзя сохранять в растровом файле слои (Layers),  альфа-каналы и цветовой профиль (ICC Profile).  Склейте слои командой Flatten layers,  при записи снимите галку «Include ICC-profile».  Если изображение в макете содержит ICC-профиль,  оно будет сконвертировано в профиль ISO Coated ECI  с TIL=300  через цветовую модель LAB.  Такой подход гарантирует качественную печать макета, однако следует отметить, что возможно некоторое изменение цвета.</li>
</ul>
<h2>Эффекты и обтравленные изображения</h2>
<ul>
<li>Недопустимо использование встроенных Pattern, Texture и PostScript  заливок, элементы с такими заливками необходимо растрировать с фоном в единый Bitmap. </li>
<li>При использовании таких эффектов  как прозрачность,  тень,  линза, gradient mesh  и т.п.  все элементы,  содержащие перечисленные эффекты, необходимо растрировать с фоном в единый Bitmap.</li>
</ul>
<h2>Линии и мелкие объекты</h2>
<ul>
<li>Мелкие объекты,  мелкий текст и тонкие линии выглядят лучше,  если они окрашены только одной из четырех составляющих CMYK (или пантоном с плотностью краски 100%). Составной цвет может привести к появлению цветных ореолов вокруг покрашенных им объектов. </li>
<li>Не рекомендуется делать мелкие белые объекты,  мелкий белый текст и тонкие белые линии на фоне,  состоящем из нескольких красок, так как они могут не пропечататься или пропечататься частично. </li>
<li>Толщина одноцветной линии должна быть больше 0,05мм (0,15pt).  При использовании в макете столь тонких линий учтите,  что мы автоматически увеличиваем толщину всех линий до 0,15pt,  если она меньше этого значения.  Толщина многоцветных линий и белых линий на составном фоне должна быть не меньше 0,5pt. </li>
<li>Если не избежать использования в линиях нескольких цветов или цвет один,  но не 100%,  делайте толщину линий максимально возможной. </li>
<li>При тиснении фольгой (клише – магний): минимальная толщина линий на бумаге- 0,2 мм или 0,566 pt,  на искусственных переплетных материалах – 0,3 мм или 0,549 pt; минимальное расстояние межпробельных элементов - 0,5 мм или 1,4175 pt.</li>
</ul>
<h2>Шрифты</h2>
<ul>
<li>Наличие шрифтов допустимо только в программе InDesign или в PS-/PDF-файлах. Во всех остальных случаях переводите шрифты в кривые. </li>
</ul>
 </div>

<br><br><br><a class="button contactmail" href="#"><span>Отправить материалы</span></a>

<?php include 'footer.php';?>

</div>
</div>

</body>

</html>
