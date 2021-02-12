<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="//www.w3.org/1999/xhtml"> 

<head>

<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <meta name="author" content="Editus Publishing">

<title>Оплата и доставка</title>
    <meta name="description" content="Как оплатить заказ на печать книг. Выбор способа доставки: доставка по всей России и зарубеж. Сроки доставки.">
    <meta name="keywords" content="печать книги, печать книг от одного экземпляра, печать книг малыми тиражами, издать книгу, напечатать книгу, печать книги онлайн, напечатать книгу онлайн">

<?php include 'links.php';?>
<script>$(function() { $('#site-navigation > ul > li').removeClass('current-menu-item').eq(0).addClass('current-menu-item') });</script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script type="text/javascript" src="cdek/widjet.js" charset="utf-8" id="ISDEKscript" ></script>
    <script type="text/javascript">
   var cartWidjet = new ISDEKWidjet ({
       defaultCity: 'Москва',
	   cityFrom: 'Москва', // доставка ведется из Екатеринбурга
       choose: false, // не будем отображать кнопку выбора ПВЗ
       hidedelt: true, // скроем возможность выбора типа доставки
       goods: [ // установим данные о товаре для корректного расчета стоимости доставки
           { length: 20, width: 20, height: 20, weight: 2 }
       ],
       popup: true, // включим режим всплывающего окна
       onCalculate: calculated
   });
   // сделаем так, чтобы при расчете доставки до ПВЗ обновлялась информация в блоке с деталями доставки
   function calculated(params){
       ipjq('#delPrice').html(params.profiles.pickup.price);
       ipjq('#delTime').html(params.profiles.pickup.term);
   }
</script>


</head>



<body>

<!-- #PAGE -->
    <div id="page" class="hfeed site">
<?php include 'top.php';?>




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
                                    
                                    <!-- .entry-header -->
                                    <header class="entry-header">
                                         <h1 class="entry-title">Оплата и доставка</h1>
                                    </header>
                                    <!-- .entry-header -->
                                    
                             		<!-- .featured-image -->  
                              <div class="featured-image">
                              	<img src="new/images/blog/07.jpg" alt="Способы оплаты" class="aligncenter" />
                              </div>
                              <!-- .featured-image --> 
                              
    								<!-- .entry-content -->
                                    <div class="entry-content">
                                    	<section id="oplata">
                                        <h2>Способы оплаты 
                                        <i class="fa fa-cc-visa"></i> <i class="fa fa-cc-mastercard"></i> <i class="fa fa-cc-paypal"></i></h2>
                                        <h4>Оплата банковской картой</h4>
<p>Оплата происходит через авторизационный сервер Процессингового центра Банка с использованием Банковских кредитных карт
        следующих платежных систем:</p>
        <div>
          <img style="height: 18px;" src="new/images/logo_pay/mir.png" alt="МИР" title="МИР">&nbsp;
          <img style="height: 18px;" src="new/images/logo_pay/visa.png" alt="VISA International" title="VISA International">&nbsp;
          <img style="height: 20px;" src="new/images/logo_pay/mastercard.png" alt="MasterCard Worldwide" title="MasterCard Worldwide">
        </div>
      </p>
      <h5 class="rbru__left">Передача данных</h5>
      <p>Для осуществления платежа Вам потребуется сообщить данные Вашей пластиковой карты. Передача этих сведений производится
        с соблюдением всех необходимых мер безопасности. Данные будут сообщены только на авторизационный сервер Банка по защищенному
        каналу (протокол TLS). Информация передается в зашифрованном виде и сохраняется только на специализированном сервере
        платежной системы. </p>
      <h5 class="rbru__left">Процесс оплаты</h5>
      <p>При выборе формы оплаты с помощью пластиковой карты проведение платежа по заказу производится непосредственно после его
        оформления. После завершения оформления заказа в нашем магазине, Вы должны будете нажать на кнопку "Оплата картой",
        при этом система переключит Вас на страницу авторизационного сервера Банка, где Вам будет предложено ввести данные пластиковой
        карты, инициировать ее авторизацию, после чего вернуться в наш магазин кнопкой "Вернуться в магазин". После того, как
        Вы возвращаетесь в наш магазин, система уведомит Вас о результатах авторизации. В случае подтверждения авторизации
        Ваш заказ будет автоматически выполняться в соответствии с заданными Вами условиями. В случае отказа в авторизации
        карты Вы сможете повторить процедуру оплаты.</p>

                                        <h4>Электронные деньги</h4>
                                        При оформлении заказа онлайн оплата происходит через систему <abbr title="Robokassa">Robokassa</abbr>. Мы также можем выставить счет на онлайн-оплату <abbr title="PayPal">PayPal</abbr> или <abbr title="Яндекс.Деньги">Яндекс.Деньги</abbr> при заказе через <a href="//editus.ru/contact.php">электронную почту</a> или в <a href="//editus.ru/contact.php">нашем офисе</a>.
                                        
                                        

<h4>Наличная оплата</h4>
Вы можете оплатить заказ наличными в <a href="//editus.ru/contact.php">нашем офисе</a>.

<h4>Безналичная оплата</h4>
Оплатить заказ можно через любой банк, который принимает платежи от физических лиц, в том числе через Интернет-банк. Счет можно скачать при заказе онлайн, получить по электронной почте или в бумажном виде в <a href="//editus.ru/contact.php">нашем офисе</a>. 

                                        <h4>В кредит</h4>

<ul>
<li>Без справок, имея только паспорт </li>
<li>Без похода в банк</li>
<li>Одобрение в течение часа</li>
<li>Сумма до 500 000 рублей </li>
<li>Действительно, не выходя из дома</li>
<li>Возможность бесплатного досрочного погашения</li>
</ul>
                                        
                                        <a href="credit.php" class="more-link">Узнать про кредит <span class="meta-nav">→</span></a>
                                        <br>
        <div class="alert">
                                                	<strong> ВНИМАНИЕ: </strong>услуги предоставляются на условиях 100% предоплаты. Заказы оформленные, но не оплаченные в течение трех рабочих дней с момента оформления заказа, могут быть перерасчитаны согласно действующим на момент оплаты расценкам.
                                                </div>              
        </section>   
                                       	<hr>
                                        <section id="dostavka">
                                        <h2>Доставка <i class="fa fa-truck"></i></h2>
                                        

<h4>Самовывоз</h4>
<p>Готовый тираж можно забрать с нашего склада по адресу: 129515, г. Москва, ул. Академика Королева, д. 13.
Выдача заказов со склада производится строго с 09-00 до 17-00 по будним дням. Для получения тиража необходим номер заказа (указывается в уведомлении о готовности) или название книги.
<a href="//editus.ru/contact.php#sklad" class="more-link">Схема проезда <span class="meta-nav">→</span></a>

<h4>Курьерская доставка</h4>
Доставка производится в любой населенный пункт России и за рубеж. 
<br />Стоимость доставки - от 250 руб. (рассчитывается в зависимости от региона доставки и веса тиража). 
<br />Сроки доставки - от 2 рабочих дней после готовности тиража книги. 
<br />Вес - не ограничен.

<!--<h4>Экспресс-доставка по Москве</h4>
Доставка курьером на метро или на авто в течение одного рабочего дня с момента готовности тиража. 
<br />Стоимость доставки - от 400 руб. (рассчитывается при онлайн-заказе в зависимости от веса тиража). 
<br />Сроки доставки - 1 календарный день с момента готовности тиража книги. 
<br />Вес - до 100 кг.--></p>
											
												<div class="alert">
                                                	<strong> ВАЖНО! </strong>При получении тиража книги внимательно проверьте содержимое. В случае недостачи или повреждения тиража книги оформите соответствующий акт при курьере.
                                                </div>
                                                <div class="alert error">
                                                	<strong> ВАЖНО! </strong>Пожалуйста, внимательно проверьте адрес доставки при оформлении заказа. В случае изменения адреса после передачи тиража в курьерскую службу взимается дополнительная плата.
                                                </div>
<br />
 <h4>Пункты выдачи заказов</h4>
  Доставка производится в любой регион России. 
<br />Стоимость доставки - от 150 руб. (рассчитывается в зависимости от региона доставки и веса тиража). 
<br />Сроки доставки - от 2 рабочих дней после готовности тиража книги. 
<br />Вес - до 20 кг.
	<br />												
   <a href='javascript:void(0)' onclick='cartWidjet.open()' class="more-link">Показать ПВЗ на карте <span class="meta-nav">→</span></a>
<div class="alert">Стоимость доставки зависит от веса тиража книги и региона доставки и рассчитывается автоматически на шаге "Оформление заказа: доставка".
                                        </div>
</section>
                                	</div>
                                    <!-- .entry-content -->
                                
                            	</article>
                            	<!-- .hentry -->
                            
                            </div>
                            <!-- .row -->

</div>
                    <!-- #content -->
                    
                </div>
                <!-- #primary -->
                    
                
          
         
         
         </div>
      </section>
      <!-- #main --> 
<?php include 'footer.php';?>
<?php include 'scripts_read.php';?>

</body>
</html>