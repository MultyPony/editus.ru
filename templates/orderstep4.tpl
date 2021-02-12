<fieldset id="os4">
    <legend class="orderstepname"><h2><?php echo _OS4_ORDERSTEP4; ?></h2></legend>
    <!--<h4><?php echo _OS4_SELECTPAY;?></h4>-->
    <br>
    <table style="width: 100%; margin-bottom:20px;">
        <tr>
            <!--<td style="display: <?php echo $_GET['test'] ? 'block' : 'none';?>">
              <img src="img/avangard_logo.png" id="avangard-visa-mastercard-img" class="methpay" title="Visa/MasterCard." >
            </td>-->
            <td style="align-content: center; text-align: center;"><img src="img/robokassa.jpg" id="robokassaimg" class="" title="ROBOKASSA - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone." ></td>
           <!-- <td><img src="img/sber.jpg" id="sberbimg" class="methpay" title="БАНК - Оплата по квитанции в любом банке, который принимает платежи от физических лиц, в т.ч. через интернет-банк. Обратите внимание, что платежи через Сбербанк поступят на наш расчетный счет не ранее чем через 3 рабочих дня." ></td>-->
        </tr>
    </table>

<div id="avangard-visa-mastercard" style="text-align: center; display: none;" class="meth">
      Стоимость: <?php echo $amount; ?> руб.
      <form
              action="https://e-commerce.raiffeisen.ru/vsmc3ds/pay_check/3dsproxy_init.jsp"
              method=POST
              name="frm"
              accept-charset="windows-1251"
      >
        <input name="PurchaseDesc" type="hidden" value="pub<?php echo $orderNr;?>" />
        <input name="PurchaseAmt" type="hidden" value="<?php echo $amount;?>" />
        <input name="CountryCode" type="hidden" value="643" />
        <input name="CurrencyCode" type="hidden" value="643" />
        <input name="MerchantName" type="hidden" value="EDITUS" />
        <input name="MerchantURL" type="hidden" value="https://www.editus.ru" />
        <input name="MerchantCity" type="hidden" value="MOSCOW" />
        <input name="MerchantID" type="hidden" value="000001780571001-80571001" />
        <input name="HMAC" type="hidden" value="<?php echo $hmacRaiff;?>" />
        <input class='button red' type=submit value="Оплатить" />
      </form>
    </div>
    <div id="sverb" style="text-align: center; display: none;" class="meth">
        <p><a href="<?php echo $hrefkvit; ?>"><?php echo _OS4_DOWNLOADBILL; ?></a></p>
    </div>
    <div id="robokassa" style="text-align: center;" class="meth">
        <?php echo $robokassa;?>
    </div>
									<!-- .entry-content -->
    <div class="entry-content">
        <p>
        <a href="credit.php" class="more-link" target="_blank">напечатать книгу в кредит <span class="meta-nav">→</span></a></p>
    </div>
    <!-- .entry-content -->
    <div class="tooltip" id="tooltipavangard" style="display: none;">
      <p>Для осуществления платежа Вам потребуется сообщить данные Вашей пластиковой карты. Передача этих сведений производится с соблюдением всех необходимых мер безопасности. Данные будут сообщены только на авторизационный сервер Банка по защищенному каналу (протокол TLS). Информация передается в зашифрованном виде и сохраняется только на специализированном сервере платежной системы. Сайт и магазин не знают и не хранят данные вашей пластиковой карты.</p>
    </div>
    <div class="tooltip" id="tooltiprobo"><p><abbr title="ROBOKASSA">ROBOKASSA</abbr> - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone.</p></div>
    <div class="tooltip" id="tooltipsber" style="display: none;"><p><abbr title="БАНК">БАНК</abbr> - Оплата по безналичному расчету, в т.ч. через интернет-банк. Обратите внимание, что платежи через Сбербанк поступят на наш расчетный счет не ранее чем через 3 рабочих дня.</p></div>

</fieldset>
<!-- Google Code for order Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 949028215;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "rMILCLGR9wcQ94rExAM";
var google_conversion_value = 0;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/949028215/?value=0&amp;label=rMILCLGR9wcQ94rExAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
