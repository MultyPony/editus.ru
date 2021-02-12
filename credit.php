<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: http://www.editus.ru/new/credit.html'.$ref); 
exit(); 
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<title>Печать книг в кредит</title>
<meta name="keywords" content="печать книг в кредит">

<meta name="description" content="Печать книг в кредит, не выходя из дома.">

<link rel="stylesheet" type="text/css" href="css/styles.css" media="all">

<link rel="shortcut icon" href="img/favicon.ico">
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
 
<link href="css/lightbox.css" rel="stylesheet" />
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/lightbox.js"></script>   
<script type="text/javascript" src="js/jquery.simplemodal.1.4.1.min.js"></script>
    <script type="text/javascript">
     function look(type)
      {
       param=document.getElementById(type);
       if(param.style.display == "none") param.style.display = "block";
       else param.style.display = "none"
      }
    </script>
	<script type="text/javascript" src="js/jquery.simplemodal.1.4.1.min.js"></script>
<script type="text/javascript">
        <!--
        $(function(){
            $('.creditrequest').click(function(e){
                e.preventDefault();
                var src = "./creditrequest.php";
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

<h1>Печать книг в кредит</h1>



<img src="img/credit.jpg" title="Печать книг в кредит" alt="Печать книг в кредит" style="padding-top:50px;" />
<br><br><br><a class="button creditrequest" href="#"><span>Оформить печать книг в кредит</span></a>
<div class="text"><br /><br /><br />

<h2>Теперь у нас можно заказать печать книг в кредит, <br />не выходя из дома</h2>
<ul>
<li>Без справок, имея только паспорт </li>
<li>Без похода в банк</li>
<li>Одобрение в течение часа</li>
<li>Сумма от 2 000 до 300 000 рублей </li>
<li>Действительно, не выходя из дома</li>
<li>Возможность бесплатного досрочного погашения</li>
<li>Срок от 6 до 24 месяцев</li>
<li>Первый взнос от 0 до 50%
</ul>
<br />
<h2>Как происходит оформление заказа в кредит</h2>
<br />
<table cellpadding="15">
<tr>
<td width="300"><img src="img/cred1.jpg" title="Заполните заявку" alt="Заполните заявку" />
<p>Нажмите кнопку ниже "Оформите печать книг в кредит". Укажите свои данные</p></td>
<td width="300"><img src="img/cred2.jpg" title="Уточнение данных" alt="Уточнение данных" />
<p>С Вами свяжется кредитный менеджер для уточнения паспортных данных</p></td>
</tr>
<tr>
<td width="300"><img src="img/cred3.jpg" title="Обработка заявки" alt="Обработка заявки" />
<p>Ваша заявка обрабатывается банками-партнерами. Решение в течение 1 часа</p></td>
<td width="300"><img src="img/cred4.jpg" title="Подписание договора" alt="Подписание договора" />
<p>Кредитный менеджер согласует удобное для Вас место и время подписания кредитного договора</p></td>
</tr>
<tr>
<td width="300"><img src="img/cred5.jpg" title="Заключение договор" alt="Заключение договор" />
<p>Теперь Вам остается ознакомиться с текстом кредитного договора и подписать его</p></td>
<td width="300"><img src="img/cred6.jpg" title="Первоначальный взнос" alt="Первоначальный взнос" />
<p>Внесите первоначальный взнос (от 10% стоимости заказа) и ждите уведомление о готовности тиража!</p></td>
</tr>

</table>

<img src="img/banki.jpg" title="Печать книг в кредит" alt="Печать книг в кредит" style="padding-top:50px;" />


<br><br /><br />
<h2>Требования к заёмщикам</h2>
<ul>
<li>возраст от 18 до 75 лет</li>
<li>гражданство: Российская Федерация </li>
<li>постоянная регистрация</li>
<li>общая сумма заказа - от 2 до 300 т.р., включая доставку, услуги дизайна, верстки, корректуры и проч.
</ul>

<br><br>

<h2>Часто задаваемые вопросы</h2>

<div class="question"><a href="javascript:look('div1');">Я хочу заказать печать книг в кредит. Что мне делать?</a></div>
<div id="div1" style="display:none; margin-left:20px;">Нажмите кнопку «Оформить печать книг в кредит», укажите номер заказа, ФИО, контактный телефон и электронную почту. С Вами свяжется кредитный менеджер, чтобы уточнить паспортные данные. После этого Ваша анкета отправляется в банки-партнеры. В течение часа с Вами свяжутся и скажут, какой банк одобрил кредит. В случае одобрения несколькими банками кредитный менеджер поможет Вам выбрать наиболее выгодную кредитную программу. Вы сообщите удобное время и место встречи с курьером  для подписания кредитного договора. После подписания и оплаты первоначального взноса заказ будет принят в работу и Вам останется только ждать уведомления о готовности тиража.</div>

<div class="question"><a href="javascript:look('div3');">A придется ли ехать в банк?</a></div>
<div id="div3" style="display:none; margin-left:20px;">В банк ехать не надо, кредитный менеджер сам подъедет к Вам на работу или домой, чтобы подписать кредитный договор.</div>

<div class="question"><a href="javascript:look('div4');">Нужны ли дополнительные справки?</a></div>
<div id="div4" style="display:none; margin-left:20px;">Справок не нужно. Главное – паспорт. Желательно предоставить также на выбор: или водительские права, или загранпаспорт, или свидетельство пенсионного страхования.</div>

<div class="question"><a href="javascript:look('div5');">Какие требования к заемщику?</a></div>
<div id="div5" style="display:none; margin-left:20px;">Возраст от 18 до 75 лет, гражданство  - Российская Федерация, занятость на последнем месте работы не менее 3-х месяцев. </div>

<div class="question"><a href="javascript:look('div6');">В каких регионах я могу оформить кредит?</a></div>
<div id="div6" style="display:none; margin-left:20px;">В регионах присутствия отделений банков-партнеров.</div>

<div class="question"><a href="javascript:look('div8');">Какая процентная ставка по кредиту?</a></div>
<div id="div8" style="display:none; margin-left:20px;">Все зависит от банка, у каждого из них много вариантов кредитных программ. Кредитный менеджер поможет подобрать наиболее выгодный для Вас вариант.
</div>
<div class="question"><a href="javascript:look('div9');">На какой срок я могу получить кредит?</a></div>
<div id="div9" style="display:none; margin-left:20px;">От 6 до 24 месяцев.
</div>
<div class="question"><a href="javascript:look('div10');">Какой первоначальный взнос?</a></div>
<div id="div10" style="display:none; margin-left:20px;">Первоначальный взнос по кредиту от 10%. По Вашему желанию он может быть больше.
</div>
<div class="question"><a href="javascript:look('div11');">Когда можно будет получить тираж книги, если я оформляю кредит?</a></div>
<div id="div11" style="display:none; margin-left:20px;">После подписания кредитного договора и внесения первоначального взноса заказ будет принят в работу, о готовности тиража Вы будете уведомлены по телефону или электронной почте.
</div>
<div class="question"><a href="javascript:look('div12');">Входит ли доставка в сумму кредита?</a></div>
<div id="div12" style="display:none; margin-left:20px;">Вы можете включить доставку в сумму кредита.
</div>


<div class="question"><a href="javascript:look('div16');">А могу я на сайте оформить кредит, а потом забрать деньги, а не книги?</a></div>
<div id="div16" style="display:none; margin-left:20px;">Нет. Банк в случае оформления заявки на сайте предоставляет целевой кредит, т.е. на конкретный заказ на печать книги с определенными параметрами.
 </div>



 </div>

<br><br><br><a class="button creditrequest" href="#"><span>Оформить печать книг в кредит</span></a>

<?php include 'footer.php';?>

</div>
</div>

</body>

</html>
