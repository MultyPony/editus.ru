<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: //editus-dev.ru/services-certificate.php'.$ref); 
exit(); 
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml"> 

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>Печать книг в кожаном переплете</title>
    <meta name="keywords" content="книги в кожаном переплете, подарочная книга, книги в подарок" />
    <meta name="description" content="Подарочные книги в кожаном переплете, тиснение золотой фольгой" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" media="all" />
    <link rel="shortcut icon" href="img/favicon.ico" />
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


<div>

<?php include 'menubook.php';?>

</div>
</div>


<div id="right">

<?php include 'mainmenu.php';?>



<h1>Книги в подарок</h1>



<table>

<tr style="height:180px">

<td width="200" valign="bottom"><img src="img/leatherbooks1.jpg" width="150" height="150" border="0" alt="" /></td>

<td width="200" valign="bottom"><img src="img/leatherbooks2.jpg" width="150" height="150" border="0" alt="" /></td>

<td width="200" valign="bottom"><img src="img/leatherbooks3.jpg" width="150" height="150" border="0" alt="" /></td>
</tr></table>


<div class="text">
<br /><br />
Издательство «Эдитус» предлагает издать книгу в эксклюзивном переплете ручной работы из экокожи, которая представляет собой качественный заменитель натуральный кожи нового поколения: 
<ul>
<li> Фактура поверхности точно имитирует натуральную кожу;</li>
<li> Высокие тактильные свойства — теплая и мягкая на ощупь;</li>
<li> Стойкость к истиранию и разрыву;</li>
<li> Экологически чистая по составу, не вызывает аллергии.</li>
</ul>
Подобрать цвет и фактуру экокожи можно в нашем <a href="contact.php" target="_blank">офисе</a>.
<br /><br />
По Вашему желанию возможна дополнительная индивидуальная отделка издания:
<ul>
<li>нанесение Вашего логотипа, фирменного знака, тиснение золотой и серебряной фольгой;</li>
<li>блок из дизайнерской бумаги;</li>
<li>футляры и подарочная упаковка.</li>
</ul>
</div>
<br><br><br><a class="button contactmail" href="#"><span>Заказать книгу в подарок</span></a>
<?php include 'footer.php';?>

</div>
</div>

</body>

</html>
