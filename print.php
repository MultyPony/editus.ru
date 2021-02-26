<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: //editus-dev.herokuapp.com/services-print.php'.$ref); 
exit(); 
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<title>Печать книг от 1 экземпляра, срочная печать книг</title>

<meta name="keywords" content="издать книгу, печать книги, где напечатать книгу, как напечатать книгу, напечатать книгу, срочная печать книг">

<meta name="description" content="Издательство Эдитус. Печать книг в любых тиражах – от 1 экземпляра в твердом и мягком переплете. Собственная типография, высокое качество, верстка онлайн, технологии Print-on-Demand, приемлемые цены. Срочная печать книг">

<link rel="stylesheet" type="text/css" href="css/styles.css" media="all">

<link rel="shortcut icon" href="img/favicon.ico">
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    
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
<a href="http://www.editus.ru"><img src="img/logo.gif" width="250" height="328" alt="Editus" border="0"></a>
<?php include 'topmenu.php';?>
</div>


<div >

<?php include 'menubook.php';?>
<div style="margin: 40px 0 0 60px;"><script id="id_script_banner_4" type="text/javascript" src="http://choconet.ru/index.php?dispatch=aff_banner.view&bid=4&type=js_content&sl=RU&product_ids=&aff_id=2"></script></div>
</div>
</div>


<div id="right">

<?php include 'mainmenu.php';?>


<h1>Печать книг</h1>

<table class="footer">
<tr><td><noindex><iframe src="http://player.rutv.ru/index/iframe/video_cid/26388/acc_video_id/412191" frameborder="0" title="Сюжет Вести-24 на нашем производстве!" style="width: 550px; height: 469px; border: none;"></iframe></noindex></td></tr>
<tr><td align="right" width="550">Сюжет снят на базе производства Издательства Эдитус</td></tr>
</table>

<div class="text">


Издательство «Эдитус» предлагает несколько удобных способов печати книг в Москве. У нас Вы можете выбрать как более экономичный вариант (<a href="http://www.editus.ru/online.php">верстка онлайн</a>), так и весь комплекс услуг, когда продукция оформляется для производства профессионалами.
<br /><br />

<h2>Как печатать книги?</h2>

Если Вам необходима печать книги, Вы можете выбрать любой удобный для Вас способ взаимодействия с нашим издательством. Это может быть заказ через <a href="http://www.editus.ru/online.php">онлайн-сервис</a>, отправка рукописи и требований к печати посредством <a class="contactmail" href="#">электронной почты</a> или визит в наш <a href="http://www.editus.ru/contact.php">офис</a>, где можно ознакомиться с образцами изданных экземпляров и оформить договор.
<br /><br />
<h2>Где напечатать книгу в типографии через интернет?</h2> 

Издательство «Эдитус» предлагает уникальную возможность печатать книги, верстая издание самостоятельно через наш специальный <a href="http://www.editus.ru/online.php">онлайн-сервис</a>. Онлайн-сервис позволяет выполнить верстку книги, загрузив исходные материалы, и отправить готовый макет на печать тиража в считанные минуты. Вам достаточно следовать предложенным инструкциям – и в самые сжатые сроки Вы сможете получить необходимый Вам тираж. 
<br /><a href="http://www.editus.ru/online.php">Смотреть инструкцию</a> по подготовке макета для печати книг.
<br />Вы просто вставляете в Word Ваши тексты и изображения, устанавливаете нужные настройки, и готовый макет отправляется на печать в наше издательство. Кроме того, мы осуществляем печать книг  с готовых PDF-материалов. Их Вы можете также загрузить через <a href="http://www.editus.ru/online.php">онлайн-сервис</a> или отправить на наш <a class="contactmail" href="#">электронный адрес</a>. С требованиями к PDF-материалам можно ознакомиться <a href="http://www.editus.ru/question.php">здесь</a>. 
<br /><br />
<h2>Нужна срочная печать книг?</h2>
Как правило, сроки оговариваются при каждом конкретном заказе и зависят от загруженности производства на текущий момент. 
<br /><strong>Ориентировочные сроки печати книг </strong>(при тираже до 100 экземпляров): 
<br />Мягкая обложка – 5-7 рабочих дней с момента оплаты и утверждения макета. 
<br />Твердая обложка – 10-14 рабочих дней с момента оплаты и утверждения макета. 
<br />При тираже до 20 экземпляров срок печати книг может быть уменьшен до 2-3 рабочих дней.
<br /><strong>В случае, если Вам помимо печати книг необходимо подготовить макет книги</strong>: срок изготовления оригинал-макета может быть сокращен до 1 рабочего дня.
<br /><strong>Если Вам необходима печать книг с издательским пакетом</strong>: мы присваиваем ISBN, индексы классификации УДК и ББК, авторский знак в течение одного рабочего дня.
<br /><br />
<h2>Гарантия качества</h2>
Наше производство успешно работает на рынке оперативной цифровой и офсетной печати в Москве с 1992 года, обладает <a href="http://www.editus.ru/equip.php">современным оборудованием</a>, квалифицированными специалистами и отработанными технологиями производства, мы накопили огромный опыт в изготовлении полиграфической продукции любой сложности. <a href="review.php">Посмотреть отзывы</a>. 
<br />Чтобы развеять сомнения, Вы всегда можете посмотреть образцы изготовленных книг в нашем <a href="http://www.editus.ru/contact.php">офисе</a>. 
<br><br>
Наиболее часто задаваемые вопросы по печати книг<a href="question.php">>></a>

</div>
<br /><br /><br /><a class="button" href="online.php" onclick="this.blur();"><span> Как издать книгу on-line</span></a>


<?php include 'footer.php';?>

</div>
</div>

</body>

</html>

