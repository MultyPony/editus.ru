<fieldset id="so2">
    <legend class="orderstepname"><h2><?php echo _SO2_ORDERSTEP2; ?></h2></legend>
    <h4><?php echo _SO2_SELECTPAY;?></h4>
        <br>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td><img src="img/avangard_logo.png" id="avangard-visa-mastercard-img" class="methpay" title="При оплате заказа банковской картой ввод реквизитов карты происходит в системе электронных платежей ОАО АКБ «Авангард», которая прошла сертификацию в платежных системах Visa и MasterCard. Представленные Вами данные полностью защищены и никто, включая наш интернет-магазин, не может их получить." ></td>
            <td><img src="img/robokassa.jpg" id="robokassaimg" class="methpay" title="ROBOKASSA - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone." ></td>
            <td><img src="img/sber.jpg" id="sberbimg" class="methpay" title="БАНК - Оплата по квитанции в любом банке, который принимает платежи от физических лиц, в т.ч. через интернет-банк. Обратите внимание, что платежи через Сбербанк поступят на наш расчетный счет не ранее чем через 3 рабочих дня." ></td>
        </tr>
        

    </table>
     <div id="avangard-visa-mastercard" style="text-align: center; display: none;" class="meth">
        <?php echo $robokassa;?>
    </div>
    <div id="sverb" style="text-align: center; display: none;" class="meth">
        <p><a href="<?php echo $hrefkvit; ?>"><?php echo _SO2_DOWNLOADBILL; ?></a></p>
        <p><a href="<?php echo $hrefkvit2; ?>"><?php echo _SO2_DOWNLOADBILL2; ?></a></p>
    </div>
    <div id="robokassa" style="text-align: center; display: none;" class="meth">
        <?php echo $robokassa;?>
    </div>
    
    
   
    
    
    
    
    <div class="tooltip" id="tooltipavangard" style="display: none;"><p><abbr title="ROBOKASSA">ROBOKASSA</abbr> - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone.</p></div>
    <div class="tooltip" id="tooltiprobo" style="display: none; "><p><abbr title="ROBOKASSA">ROBOKASSA</abbr> - Оплата с помощью банковских карт, в любой электронной валюте, с помощью сервисов мобильная коммерция (МТС и Билайн), платежи через интернет-банк ведущих Банков РФ, платежи через банкоматы, через терминалы мгновенной оплаты, через систему денежных переводов Contact, а также с помощью приложения для iPhone.</p></div>
    <div class="tooltip" id="tooltipsber" style="display: none;"><p><abbr title="БАНК">БАНК</abbr> - Оплата по квитанции в любом банке, который принимает платежи от физических лиц, в т.ч. через интернет-банк. Обратите внимание, что платежи через Сбербанк поступят на наш расчетный счет не ранее чем через 3 рабочих дня.</p></div>
</fieldset>